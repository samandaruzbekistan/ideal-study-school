<?php

namespace App\Repositories;

use App\Models\IdCardAttendance;

class IdCardAttendanceRepository
{
    public function getAttendanceByCardId($idCard)
    {
        return IdCardAttendance::where('id_card', $idCard)->whereNull('exit_time')->first();
    }

    public function updateExitTime($idCard, $workingMinutes)
    {
        $attendance = IdCardAttendance::where('id_card', $idCard)->whereNull('exit_time')->first();
        $attendance->update([
            'exit_time' => now(),
            'working_minutes' => $workingMinutes,
        ]);
    }

    public function insertStudentAttendance($studentId, $idCard, $isLate, $lateMinutes)
    {
        IdCardAttendance::create([
            'student_id' => $studentId,
            'id_card' => $idCard,
            'entry_time' => now(),
            'is_late' => $isLate,
            'date' => date('Y-m-d'), // Add this line to store the date of the attendance (new column in the database table: date
            'late_minutes' => $lateMinutes,
        ]);
    }

    public function insertEmployeeAttendance($employeeId, $idCard, $isLate, $lateMinutes, $position)
    {
        IdCardAttendance::create([
            'employee_id' => $employeeId,
            'id_card' => $idCard,
            'entry_time' => now(),
            'is_late' => $isLate,
            'late_minutes' => $lateMinutes,
            'position' => $position,
        ]);
    }
}
