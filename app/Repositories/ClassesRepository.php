<?php

namespace App\Repositories;

use App\Models\Classes;

class ClassesRepository
{
    public function getAllClasses(){
        return Classes::with('teacher')->orderBy('name', 'asc')->get();
    }

    public function add($name, $level, $teacher_id){
        $cl = new Classes;
        $cl->name = $name;
        $cl->level = $level;
        $cl->teacher_id = $teacher_id;
        $cl->save();
    }

    public function getClasses($name){
        return Classes::where('name', $name)->first();
    }

    public function getClassWithStudents($class_id){
        return Classes::with(['students' => function ($query) {
            $query->where('status', 1);
        }])->find($class_id);
    }

    public function getTeacherClass($teacher_id){
        return Classes::where('teacher_id', $teacher_id)->first();
    }
}
