<?php

namespace App\Repositories;

use App\Models\Student;

class StudentRepository
{
    public function getStudents(){
        return Student::with('class')->orderBy('name', 'asc')->paginate(100);
    }

    public function getStudentsAll(){
        return Student::all();
    }
    public function getStudentById($id){
        return Student::find($id);
    }

    public function getStudentByName($name){
        return Student::where('name', $name)->first();
    }

    public function add_student($name,$class_id,$phone, $r_id, $d_id, $q_id){
        $st = new Student;
        $st->name = $name;
        $st->class_id = $class_id;
        $st->phone = $phone;
        $st->region_id = $r_id;
        $st->district_id = $d_id;
        $st->quarter_id = $q_id;
        $st->save();
        return $st->id;
    }
}
