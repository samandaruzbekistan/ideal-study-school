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
use App\Services\SmsService;
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
        protected SmsService $smsService,
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
//        return $payments;
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
        $classes = $this->classesRepository->getClassWithStudents($class_id);
        $payments = $this->monthlyPaymentRepository->monthPaymentsBySubjectId($class_id);
        $payments_success = $this->monthlyPaymentRepository->getPaidPaymentsByMonth($class_id);
        return view('cashier.subject_students',['class_id'=>$class_id,'classes' => $classes, 'payments' => $payments,'payments_success' => $payments_success]);
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
        $rowsToInsert = [];
        if ($currentMonth > 8){
            for ($month = $currentMonth; $month <= 12; $month++){
                $row = [
                    'student_id' => $student_id,
                    'class_id' => $request->class_id,
                    'month' => Carbon::create($currentYear, $month, 1)->format('Y-m-d'),
                    'indebtedness' => $price,
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
            for ($month = $currentMonth; $month <= 8; $month++){
                $row = [
                    'student_id' => $student_id,
                    'class_id' => $request->class_id,
                    'month' => Carbon::create($currentYear, $month, 1)->format('Y-m-d'),
                    'indebtedness' => $price,
                ];
                $rowsToInsert[] = $row;
            }
        }
        $this->monthlyPaymentRepository->add($rowsToInsert);
        return back()->with('success',1);
    }

    public function student($id){
        $student = $this->studentRepository->getStudentWithSubjectsPayments($id);
        return view('cashier.student', ['student' => $student]);
    }

    public function update_student(Request $request){
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|numeric|digits:9',
            'student_id' => 'required|numeric',
        ]);
        $this->studentRepository->update_student($request->name, "998{$request->phone}",$request->student_id);
        return back()->with('updated',1);
    }

    public function search(Request $request){
        $students = $this->studentRepository->getStudentsByName($request->name);
        return response()->json($students);
    }



    public function getPayments($student_id){
        return $this->monthlyPaymentRepository->getPaymentByStudentId($student_id);
    }

    public function getPayment($payment_id){
        return $this->monthlyPaymentRepository->getPayment($payment_id);
    }

    public function paid(Request $request){
        $request->validate([
            'id' => 'required|numeric',
            'amount' => 'required|numeric',
            'type' => 'required|string',
        ]);
        $payment = $this->monthlyPaymentRepository->getPayment($request->id);
        $student = $this->studentRepository->getStudentById($payment->student_id);
        if ($request->amount > $payment->indebtedness) return back()->with('amount_error',1);
        if (!$payment) return back()->with('payment_error',1);
        if (($request->has('status')) || ($request->amount == $payment->amount)){
            $amount = $request->amount + $payment->amount_paid;
            $this->monthlyPaymentRepository->payment($payment->id, 0, $amount,$request->type, 1);
        }
        else{
            $this->monthlyPaymentRepository->addPayment($payment->student_id,$student->class_id,0,$payment->month, $request->amount);
            $amount = $payment->amount - $request->amount;
            $this->monthlyPaymentRepository->updatePayment($payment->id, $amount);
//            $amount_paid = $request->amount + $payment->amount_paid;
//            $amount = $payment->amount - $request->amount;
//            $this->monthlyPaymentRepository->payment($payment->id, $amount, $amount_paid,$request->type, 0);
        }
        return redirect()->route('cashier.home')->with('success',1);;
    }



    public function sendSmsStudent(Request $request){
        $request->validate([
            'number' => 'required|numeric|digits:12',
            'message' => 'required|string'
        ]);
        $result = $this->smsService->sendStudent($request->number, $request->message);
        $jsonEncoded = json_decode($result);
        if ($jsonEncoded->status != "waiting") return back()->with('sms_error', 1);
        return back()->with('sms_send',1);
    }

    public function payment_details(Request $request){
        return $this->monthlyPaymentRepository->getPaymentsByMonth($request->month, $request->class_id);
    }








    public function sms_to_group(Request $request){
        $request->validate([
            'class_id' => 'required|numeric',
            'message' => 'required|string',
        ]);
        $students = $this->studentRepository->getClassStudents($request->class_id);
//        return $students;
        $res = $this->smsService->sendSmsSubject($students,$request->message);
//        return $res;
        if($res['status'] == 'success') return back()->with('success',1);
        else return back()->with('error',1);
//        else return $res;
    }



    //    Region control
    public function districts($region_id){
        return $this->districtRepository->districts($region_id);
    }

    public function quarters($district_id){
        return $this->districtRepository->quarters($district_id);
    }

}
