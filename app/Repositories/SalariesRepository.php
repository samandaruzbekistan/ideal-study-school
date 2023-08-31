<?php

namespace App\Repositories;

use App\Models\Salary;

class SalariesRepository
{
    public function getSalaries(){
        return Salary::with('teacher')->get();
    }

    public function filtr($date){
        return Salary::where('date',$date)->get();
    }

    public function teacherSalaries($teacher_id){
        return Salary::with('teacher')->where('teacher_id', $teacher_id)->get();
    }

    public function add($tch_id, $month, $amount, $date, $desc,$id){
        $s = new Salary;
        $s->teacher_id = $tch_id;
        $s->month = $month;
        $s->amount = $amount;
        $s->date = $date;
        $s->description = $desc;
        $s->cashier_id = $id;
        $s->save();
    }
}
