<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Repositories\AttendanceRepository;
use App\Repositories\ClassesRepository;
use App\Repositories\ManagerRepository;
use App\Repositories\MonthlyPaymentRepository;
use App\Repositories\NotComeDaysRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TeacherRepository;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    public function __construct(
        protected TeacherRepository $teacherRepository,
        protected ManagerRepository $managerRepository,
        protected ClassesRepository $classesRepository,
        protected AttendanceRepository $attendanceRepository,
        protected NotComeDaysRepository $notComeDaysRepository,
        protected StudentRepository $studentRepository,
        protected MonthlyPaymentRepository $monthlyPaymentRepository,
        protected SmsService $smsService
    )
    {
    }

    //    Auth
    public function auth(LoginRequest $request){
        $teacher = $this->managerRepository->getManager($request->username);
        if (!$teacher){
            return back()->with('login_error', 1);
        }
        if (Hash::check($request->input('password'), $teacher->password)) {
            session()->flush();
            session()->put('manager',1);
            session()->put('cashier',1);
            session()->put('name',$teacher->name);
            session()->put('id',$teacher->id);
            session()->put('photo',$teacher->photo);
            session()->put('username',$teacher->username);
            return redirect()->route('cashier.home');
        }
        else{
            return back()->with('login_error', 1);
        }
    }

    public function change_payment(Request $request){
        $request->validate([
            'student_id' => 'required|numeric',
            'new_summa' => 'required|string'
        ]);
        $student = $this->studentRepository->getStudentById($request->student_id);
        $amountString = str_replace([' ', ','], '', $request->input('new_summa'));
        $amount = (float) $amountString;
        $this->studentRepository->update_contribution($request->student_id, $amount);
        $this->monthlyPaymentRepository->change_all_not_paid_amount($student->id, $student->contribution, $amount);
        return back()->with('success_update',1);
    }

    public function logout(){
        session()->flush();
        return redirect()->route('manager.login');
    }

    public function update_id_card(Request $request){
        $request->validate([
            'student_id' => 'required|numeric',
            'id_card' => 'required|string'
        ]);

        $this->studentRepository->update_id_card($request->student_id, $request->id_card);

        return back()->with('success_update',1);
    }

}
