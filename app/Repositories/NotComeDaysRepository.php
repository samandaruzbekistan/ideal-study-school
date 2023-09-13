<?php

namespace App\Repositories;

use App\Models\MonthlyPayment;
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

    public function deleteStudentDays($id){
        NotComeDays::where('student_id', $id)
            ->delete();
    }

    public function update_class($student_id,$class_id){
        NotComeDays::where('student_id', $student_id)
            ->update([
                'class_id' => $class_id
            ]);
    }
}
