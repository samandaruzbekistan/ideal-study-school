<?php

namespace App\Repositories;

use App\Models\Attendance;

class AttendanceRepository
{
    public function getAttedancesByClassId($class_id){
        $attedances = Attendance::where('class_id', $class_id)->get();
        return $attedances;
    }

    public function getAttendanceBySubjectId($id, $month){
        return Attendance::where('class_id', $id)
            ->whereMonth('date', $month)
            ->orderBy('date','desc')
            ->get();
    }

    public function getAttendanceByClassIdDate($sb_id, $date){
        return Attendance::where('class_id', $sb_id,)
            ->where('date', $date)
            ->first();
    }

    public function add($sb_id,$d,$c){
        $attendance = new Attendance;
        $attendance->class_id = $sb_id;
        $attendance->date = $d;
        $attendance->not_come_students_count = $c;
        $attendance->save();
        return $attendance->id;
    }
}
