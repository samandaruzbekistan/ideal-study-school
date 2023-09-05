<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Repositories\AttendanceRepository;
use App\Repositories\ClassesRepository;
use App\Repositories\NotComeDaysRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TeacherRepository;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function __construct(
        protected TeacherRepository $teacherRepository,
        protected ClassesRepository $classesRepository,
        protected AttendanceRepository $attendanceRepository,
        protected NotComeDaysRepository $notComeDaysRepository,
        protected StudentRepository $studentRepository,
        protected SmsService $smsService
    )
    {
    }

    //    Auth
    public function auth(LoginRequest $request){
        $teacher = $this->teacherRepository->getTeacher($request->username);
        if (!$teacher){
            return back()->with('login_error', 1);
        }
        if (Hash::check($request->input('password'), $teacher->password)) {
            session()->flush();
            session()->put('teacher',1);
            session()->put('name',$teacher->name);
            session()->put('id',$teacher->id);
            session()->put('photo',$teacher->photo);
            session()->put('username',$teacher->username);
            return redirect()->route('teacher.classes');
        }
        else{
            return back()->with('login_error', 1);
        }
    }

    public function update(Request $request){
        $request->validate([
            'password1' => 'required|string',
            'password2' => 'required|string',
            'username' => 'required|string',
        ]);
        if ($request->input('password1') != $request->input('password2')) return back()->with('password_error',1);
        $this->teacherRepository->update_password($request->password1, $request->username);
        return back()->with('success',1);
    }

    public function update_avatar(Request $request){
        $request->validate([
            'photo' => 'required|image|max:2048',
        ]);
        $cashier = $this->teacherRepository->getTeacher(session('username'));
        if ($cashier->photo != 'no_photo.jpg') unlink('img/avatars/'.$cashier->photo);
        $file = $request->file('photo')->extension();
        $name = md5(microtime());
        $photo_name = $name.".".$file;
        session()->put('photo', $photo_name);
        $path = $request->file('photo')->move('img/avatars/',$photo_name);
        $this->teacherRepository->update_photo($photo_name);
        return back()->with('success_photo',1);
    }

    public function logout(){
        session()->flush();
        return redirect()->route('teacher.login');
    }

    public function profile(){
        $admin = $this->teacherRepository->getTeacher(session('username'));
        return view('teacher.profile', ['user' => $admin]);
    }

    public function classes(){
        $classes = $this->classesRepository->getAllClasses();
        return view('teacher.classes', ['classes' => $classes]);
    }

    public function home($id){
        $classes = $this->classesRepository->getClass($id);
        $students = $this->studentRepository->getClassStudents($id);
        $attendances = $this->attendanceRepository->getAttendanceBySubjectId($id, '09');
        $absentDay = $this->notComeDaysRepository->getTotalAbsentDays($id,'09');

        return view('teacher.attendances', ['class_name'=>$classes->name,'absentDay'=> $absentDay,'attendances' => $attendances, 'students' => $students, 'class_id' => $classes->id]);

//        $attedances = $this->attendanceRepository->getAttedancesByClassId($classes->id);?
//        return view('teacher.attendances', ['attendances' => $attedances, 'class_id' => $classes->id]);
    }

    public function attendance_detail_day($id){
        return $this->notComeDaysRepository->getWithStudentName($id);
    }

    public function attendance_check(Request $request){
        $selectedStudentIds= $request->input('student_ids', []);
        $d = date('Y-m-d');
        $c= count($selectedStudentIds);
        $att = $this->attendanceRepository->getAttendanceByClassIdDate($request->class_id, $d);
        if ($att) return back()->with('error',1);
        $attendance_id = $this->attendanceRepository->add($request->class_id,$d,$c);
        $inserted_row = [];
        $students = [];
        foreach ($selectedStudentIds as $id){
            $students[] = $this->studentRepository->getStudentById($id);
            $inserted_row[] = [
                'student_id' => $id,
                'class_id' => $request->class_id,
                'date' => $d,
                'attendance_id' => $attendance_id
            ];
        }
        $this->smsService->NotifyNotComeStudentParents($students);
        $this->notComeDaysRepository->add($inserted_row);
        return back()->with('success',1);
    }

    public function attendance_detail($class_id, $month){
        $attendances = $this->attendanceRepository->getAttendanceBySubjectId($class_id, $month);
        $absentDay = $this->notComeDaysRepository->getTotalAbsentDays($class_id,$month);
        return [$absentDay,$attendances];
    }
}
