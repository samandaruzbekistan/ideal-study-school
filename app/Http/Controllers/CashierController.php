<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Repositories\AdminRepository;
use App\Repositories\CashierRepository;
use App\Repositories\ClassesRepository;
use App\Repositories\DistrictRepository;
use App\Repositories\MonthlyPaymentRepository;
use App\Repositories\OutlayRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TeacherRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CashierController extends Controller
{
    public function __construct(
        protected CashierRepository $cashierRepository,
        protected AdminRepository $adminRepository,
        protected TeacherRepository $teacherRepository,
        protected MonthlyPaymentRepository $monthlyPaymentRepository,
        protected OutlayRepository $outlayRepository,
        protected StudentRepository $studentRepository,
        protected ClassesRepository $classesRepository,
        protected DistrictRepository $districtRepository,
    )
    {
    }

    //    Auth
    public function auth(LoginRequest $request){
        $cashier = $this->cashierRepository->getCashier($request->username);
        if (!$cashier){
            return back()->with('login_error', 1);
        }
        if (Hash::check($request->input('password'), $cashier->password)) {
            session()->put('cashier',1);
            session()->put('name',$cashier->name);
            session()->put('id',$cashier->id);
            session()->put('photo',$cashier->photo);
            session()->put('username',$cashier->username);
            return redirect()->route('cashier.home');
        }
        else{
            return back()->with('login_error', 1);
        }
    }

    public function logout(){
        session()->flush();
        return redirect()->route('cashier.login');
    }

    public function home(){
        $payments = $this->monthlyPaymentRepository->getPaymentsByDate(date('Y-m-d'));
        return view('cashier.payment', ['payments' => $payments]);
    }

    public function profile(){
        $admin = $this->cashierRepository->getCashier(session('username'));
        return view('cashier.profile', ['user' => $admin]);
    }

    public function update(Request $request){
        $request->validate([
            'password1' => 'required|string',
            'password2' => 'required|string',
            'username' => 'required|string',
        ]);
        if ($request->input('password1') != $request->input('password2')) return back()->with('password_error',1);
        $this->cashierRepository->update_password($request->password1, $request->username);
        return back()->with('success',1);
    }

    public function update_avatar(Request $request){
        $request->validate([
            'photo' => 'required|image|max:2048',
        ]);
        $cashier = $this->cashierRepository->getCashier(session('username'));
        if ($cashier->photo != 'no_photo.jpg') unlink('img/avatars/'.$cashier->photo);
        $file = $request->file('photo')->extension();
        $name = md5(microtime());
        $photo_name = $name.".".$file;
        session()->put('photo', $photo_name);
        $path = $request->file('photo')->move('img/avatars/',$photo_name);
        $this->cashierRepository->update_photo($photo_name);
        return back()->with('success_photo',1);
    }


//  Class control
    public function classes(){
        $subs = $this->classesRepository->getAllClasses();
        $teachers = $this->teacherRepository->getTeachers();
        return view('cashier.classes', ['classes' => $subs, 'teachers' => $teachers]);
    }

    public function new_class(Request $request){
        $request->validate([
            'name' => 'required|string',
            'level' => 'required|numeric',
            'teacher_id' => 'required|string',
        ]);
        $cl = $this->classesRepository->getClasses($request->name);
        $teacher_cl = $this->classesRepository->getTeacherClass($request->teacher_id);
        if ($cl) return back()->with('name_error',1);
        if ($teacher_cl) return back()->with('teacher_error',1);
        $this->classesRepository->add($request->name, $request->level, $request->teacher_id);
        return back()->with('success',1);
    }

    public function classStudents($class_id){

    }

    public function students(){
        $classes = $this->classesRepository->getAllClasses();
        return view('cashier.students', ['students' => $this->studentRepository->getStudents(), 'classes' => $classes]);
    }

    public function new_student(Request $request){
        $request->validate([
            'name' => 'required|string',
            'date' => 'required|date',
            'phone' => 'required|numeric|digits:9',
            'region_id' => 'required|numeric',
            'district_id' => 'required|numeric',
            'quarter_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'class_id' => 'required|numeric',
        ]);
        $student_id = $this->studentRepository->add_student($request->name, $request->class_id,"998{$request->phone}",$request->region_id, $request->district_id, $request->quarter_id);
        $carbonDate = Carbon::parse($request->date);
        $currentYear = $carbonDate->year;
        $currentMonth = $carbonDate->month;
        $price = $request->amount;
        $daysInMonth = $carbonDate->daysInMonth;
        $firstMonthPrice = ceil(($price - (($price / $daysInMonth) * ($carbonDate->day - 1))) / 1000) * 1000;
        $rowsToInsert = [];
        if ($currentMonth > 8){
            $countdown = 0;
            for ($month = $currentMonth; $month <= 12; $month++){
                $countdown++;
                $row = [
                    'student_id' => $student_id,
                    'class_id' => $request->class_id,
                    'month' => Carbon::create($currentYear, $month, 1)->format('Y-m-d'),
                    'indebtedness' => ($countdown == 1) ? $firstMonthPrice : $price,
                ];

                $rowsToInsert[] = $row;
            }
            $currentYear++;
            for ($month = 1; $month <= 8; $month++){
                $row = [
                    'student_id' => $student_id,
                    'class_id' => $request->class_id,
                    'month' => Carbon::create($currentYear, $month, 1)->format('Y-m-d'),
                    'indebtedness' => $price,
                ];
                $rowsToInsert[] = $row;
            }
        }
        elseif ($currentMonth <= 8){
            $countdown = 0;
            for ($month = $currentMonth; $month <= 8; $month++){
                $countdown++;
                $row = [
                    'student_id' => $student_id,
                    'class_id' => $request->class_id,
                    'month' => Carbon::create($currentYear, $month, 1)->format('Y-m-d'),
                    'indebtedness' => ($countdown == 1) ? $firstMonthPrice : $price,
                ];
                $rowsToInsert[] = $row;
            }
        }
        $this->monthlyPaymentRepository->add($rowsToInsert);
        return back()->with('success',1);
    }














    //    Region control
    public function districts($region_id){
        return $this->districtRepository->districts($region_id);
    }

    public function quarters($district_id){
        return $this->districtRepository->quarters($district_id);
    }

}
