<?php

namespace App\Http\Controllers;

use App\Repositories\EmployeeRepository;
use App\Repositories\IdCardAttendanceRepository;
use App\Repositories\StudentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class TelegramController extends Controller
{
    public function __construct(
        protected StudentRepository $studentRepository,
        protected IdCardAttendanceRepository $idCardAttendanceRepository,
        protected EmployeeRepository $employeeRepository
    ) {
    }

    public function handleWebhook(Request $request)
    {
        $data = $request->all();
        Log::info('Telegram webhook received: ', $data);

        $message = $data['message']['text'] ?? null;

        if ($message) {
            $idCard = $message;
            try {
                $attendance = $this->idCardAttendanceRepository->getAttendanceByCardId($idCard);

                if ($attendance) {
                    $workingMinutes = now()->diffInMinutes($attendance->entry_time);
                    $this->idCardAttendanceRepository->updateExitTime($idCard, $workingMinutes);
                    $name = $attendance->position == 'student' ? $attendance->student->name : $attendance->employee->name;
                    $this->sendTelegramMessage($data['message']['chat']['id'], "$name ✅ Yo'qlama muvaffaqiyatli yangilandi");
                } else {
                    $this->processNewAttendance($idCard, $data['message']['chat']['id']);
                }
            } catch (\Exception $e) {
                Log::error('Error processing attendance: ' . $e->getMessage());
                $this->sendTelegramMessage($data['message']['chat']['id'], '❌ Xatolik yuz berdi. Iltimos, keyinroq urinib ko‘ring.');
            }
        }

        return response()->json(['status' => 'ok']);
    }

    protected function processNewAttendance($idCard, $chatId)
    {
        $isLate = now()->gt(Carbon::createFromTimeString('08:30'));
        $lateMinutes = $isLate ? now()->diffInMinutes(Carbon::createFromTimeString('08:30')) : 0;

        $student = $this->studentRepository->getStudentByIdCard($idCard);
        if ($student) {
            $this->idCardAttendanceRepository->insertStudentAttendance($student->id, $idCard, $isLate, $lateMinutes);
            $this->sendTelegramMessage($chatId, "{$student->name} ✅ Yo'qlama muvaffaqiyatli qabul qilindi");
        } else {
            $employee = $this->employeeRepository->getEmployeeByIC($idCard);
            if ($employee) {
                $this->idCardAttendanceRepository->insertEmployeeAttendance($employee->id, $idCard, $isLate, $lateMinutes, $employee->position);
                $this->sendTelegramMessage($chatId, "{$employee->name} ✅ Yo'qlama muvaffaqiyatli qabul qilindi");
            } else {
                $this->sendTelegramMessage($chatId, '⚠ Bunday ID card raqamli talaba yoki xodim topilmadi');
            }
        }
    }

    protected function sendTelegramMessage($chatId, $response)
    {
        $url = 'https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN') . '/sendMessage';
        $data = [
            'chat_id' => $chatId,
            'text' => $response,
        ];

        try {
            file_get_contents($url . '?' . http_build_query($data));
        } catch (\Exception $e) {
            Log::error('Telegram API Error: ' . $e->getMessage());
        }
    }
}
