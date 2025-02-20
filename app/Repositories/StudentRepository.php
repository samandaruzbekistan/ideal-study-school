<?php

namespace App\Repositories;

use App\Models\Student;

class StudentRepository
{
    public function getStudents(){
        return Student::with('class')->orderBy('name', 'asc')->where('status',1)->paginate(100);
    }

    public function getStudentsAll(){
        return Student::where('status',1)->get();
    }
    public function getStudentById($id){
        return Student::find($id);
    }

    public function getStudentByName($name){
        return Student::where('name', $name)->first();
    }

    public function update_student($name,$phone,$id){
        $st = Student::find($id);
        $st->name = $name;
        $st->phone = $phone;
        $st->save();
    }

    public function update_contribution($id, $contribution){
        Student::where('id', $id)->update([
            'contribution' => $contribution
        ]);
    }

    public function add_student($name,$class_id,$phone, $r_id, $d_id, $q_id, $date, $p){
        $st = new Student;
        $st->name = $name;
        $st->class_id = $class_id;
        $st->phone = $phone;
        $st->region_id = $r_id;
        $st->district_id = $d_id;
        $st->quarter_id = $q_id;
        $st->come_date = $date;
        $st->contribution = $p;
        $st->save();
        return $st->id;
    }

    public function getStudentWithSubjectsPayments($studentId){
        return Student::with('class', 'monthlyPayments')->find($studentId);
    }

    public function getStudentsByName($name){
        if ($name == '') return [];
        $users = Student::with('class')->whereRaw('LOWER(students.name) LIKE ?', ['%' . strtolower($name) . '%'])
            ->where('status', 1)
            ->get();
        return $users;
    }

    public function delete_student($id){
        Student::where('id', $id)->delete();
    }

    public function getClassStudents($class_id){
        return Student::where('class_id',$class_id)->where('status',1)->get();
    }

    public function deActivate($student_id){
        $st = Student::find($student_id);
        $st->status = 0;
        $st->save();
    }

    public function update_class($student_id, $class_id){
        Student::where('id', $student_id)
            ->update([
                'class_id' => $class_id
            ]);
    }

    public function getStudentName($name, $class_id){
        return Student::where('name', $name)
            ->where('class_id', $class_id)
            ->find();
    }

    public function updateIdCard($student_id, $id_card){
        Student::where('id', $student_id)
            ->update([
                'id_card' => $id_card
            ]);
    }

    public function getStudentByIdCard($id_card){
        return Student::where('id_card', $id_card)->first();
    }
}
