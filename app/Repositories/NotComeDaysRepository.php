<?php

namespace App\Repositories;

use App\Models\NotComeDays;
use Illuminate\Support\Facades\DB;

class NotComeDaysRepository
{
    public function add($arr){
        NotComeDays::insert($arr);
    }

    public function getTotalAbsentDays($subjectId, $month) {
        $data = NotComeDays::query()
            ->with(['student' => function ($query) {
                $query->select('id','name');
            }])
            ->select('student_id', DB::raw('COUNT(*) as total_absent_days'))
            ->where('class_id', $subjectId)
            ->whereMonth('date', $month)
            ->groupBy('student_id')
            ->get();


        return $data;
    }

    public function getWithStudentName($id){
        return NotComeDays::query()
            ->with(['student' => function ($query) {
                $query->select('id','name');
            }])
            ->where('attendance_id', $id)
            ->get();
    }
}
