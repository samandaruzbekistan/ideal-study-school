<?php

namespace App\Http\Controllers;

use App\Exports\OutlayExport;
use App\Exports\PaymentFilter;
use App\Exports\SalaryExport;
use App\Http\Requests\LoginRequest;
use App\Repositories\AdminOutlayRepository;
use App\Repositories\AdminRepository;
use App\Repositories\AttendanceRepository;
use App\Repositories\CashierRepository;
use App\Repositories\ClassesRepository;
use App\Repositories\MonthlyPaymentRepository;
use App\Repositories\NotComeDaysRepository;
use App\Repositories\OutlayRepository;
use App\Repositories\SalariesRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TeacherRepository;
use App\Services\SmsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function __construct(
        protected CashierRepository $cashierRepository,
        protected AdminRepository $adminRepository,
        protected TeacherRepository $teacherRepository,
        protected MonthlyPaymentRepository $monthlyPaymentRepository,
        protected OutlayRepository $outlayRepository,
        protected SmsService $smsService,
        protected StudentRepository $studentRepository,
        protected ClassesRepository $classesRepository,
        protected AttendanceRepository $attendanceRepository,
        protected NotComeDaysRepository $notComeDaysRepository,
        protected SalariesRepository $salariesRepository,
        protected AdminOutlayRepository $adminOutlayRepository,
    )
    {
    }

    public function newYear($class_id)
    {
        $startDate = Carbon::createFromDate(2024, 9, 1);
        $endDate = Carbon::createFromDate(2025, 8, 1);
        $totalAmount = 2750000;
        $monthlyAmount = $totalAmount / 12;
        
        // Get the list of students and their class IDs
        $students = DB::table('students')->get();
    
        // Insert payment records for each student for each month
        foreach ($students as $student) {
            $currentDate = clone $startDate; // Clone the start date for each student
            while ($currentDate <= $endDate) {
                DB::table('monthly_payments')->insert([
                    'student_id' => $student->id,
                    'class_id' => $student->class_id,
                    'status' => 0, // default status, adjust as needed
                    'month' => $currentDate->toDateString(),
                    'type' => 'cash', // or other payment type as needed
                    'indebtedness' => $totalAmount, // Correct this to monthly amount
                    'paid' => 0, // default paid amount, adjust as needed
                    'cashier_id' => null, // set if necessary
                    'date' => null, // set if necessary
                    'comment' => '', // set if necessary
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
    
                // Move to the next month
                $currentDate->addMonth();
            }
        }
        return "ok";
    }


    //    Auth
    public function auth(LoginRequest $request){
        $admin = $this->adminRepository->getAdmin($request->username);
        if (!$admin){
            return back()->with('login_error', 1);
        }
        if (Hash::check($request->input('password'), $admin->password)) {
            session()->flush();
            session()->put('admin',1);
            session()->put('name',$admin->name);
            session()->put('id',$admin->id);
            session()->put('photo',$admin->photo);
            session()->put('username',$admin->username);
            return redirect()->route('admin.home');
        }
        else{
            return back()->with('login_error', 1);
        }
    }

    public function profile(){
        $admin = $this->adminRepository->getAdmin(session('username'));
        return view('admin.profile', ['user' => $admin]);
    }

    public function update(Request $request){
        $request->validate([
            'password1' => 'required|string',
            'password2' => 'required|string',
        ]);
        if ($request->input('password1') != $request->input('password2')) return back()->with('password_error',1);
        $this->adminRepository->update_password($request->password1);
        return back()->with('success',1);
    }

    public function update_avatar(Request $request){
        $request->validate([
            'photo' => 'required|image|max:2048',
        ]);
        $admin = $this->adminRepository->getAdmin(session('username'));
        if ($admin->photo != 'no_photo.jpg') unlink('img/avatars/'.$admin->photo);
        $file = $request->file('photo')->extension();
        $name = md5(microtime());
        $photo_name = $name.".".$file;
        session()->put('photo', $photo_name);
        $path = $request->file('photo')->move('img/avatars/',$photo_name);
        $this->adminRepository->update_photo($photo_name);
        return back()->with('success_photo',1);
    }

    public function logout(){
        session()->flush();
        return redirect()->route('admin.login');
    }

    public function home(){
        $payments_arr = $this->monthlyPaymentRepository->monthPaymentsByDateOrderType(date('Y-m-d'));
        $outlay = $this->outlayRepository->getOutlayByDate(date('Y-m-d'));
        $payments = $this->monthlyPaymentRepository->getPayments7();
        $cash = 0;
        $click = 0;
        $transfer = 0;
        $credit_card = 0;
        if (count($payments_arr) > 0){
            foreach ($payments_arr as $item){
                if ($item->type == 'cash') $cash = $item->total;
                else if ($item->type == 'transfer') $transfer = $item->total;
                else if ($item->type == 'click') $click = $item->total;
                else $credit_card = $item->total;
            }
        }
        return view('admin.home', ['payments' => $payments,'outlay' => $outlay,'click' => $click,'cash' => $cash, 'credit_card' => $credit_card, 'transfer' => $transfer]);
//        return view('admin.home');
    }



    public function cashiers(){
        $cashiers = $this->cashierRepository->getCashiers();
        return view('admin.cashiers', ['cashiers' => $cashiers]);
    }

    public function add_cashier(Request $request){
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string',
            'phone' => 'required|numeric|digits:9',
        ]);
        $teacher = $this->cashierRepository->getCashier($request->username);
        if (!empty($teacher)) return back()->with('username_error',1);
        if ($request->hasFile('photo')){
            if ($request->file('photo')->getSize() > 2000000) return back()->with('size_error',1);
            $file = $request->file('photo')->extension();
            $name = md5(microtime());
            $photo_name = $name.".".$file;
            $path = $request->file('photo')->move('img/avatars/',$photo_name);
            $this->cashierRepository->addCashier($request->name, $request->phone, $request->username, $request->password, $photo_name);
            return back()->with('success',1);
        }
        else{
            $this->cashierRepository->addCashier($request->name, $request->phone, $request->username, $request->password, 'no_photo.jpg');
            return back()->with('success',1);
        }
    }

    public function update_cashier(Request $request){
        $request->validate([
            'password1' => 'required|string',
            'password2' => 'required|string',
        ]);
        if ($request->input('password1') != $request->input('password2')) return back()->with('password_error',1);
        $this->cashierRepository->update_password($request->password1, $request->username);
        return back()->with('change',2);
    }

    public function system_lock(){
        $newTimestamp = Carbon::tomorrow()->setTime(0, 0, 0); // Set time to midnight

        DB::table('status_system')->where('id',1)->update(['close_timestamp' => $newTimestamp]);

        return back()->with('system_locked',1);
    }



    //    Teachers manage

    public function teachers(){
        $teachers = $this->teacherRepository->getTeachers();
        return view('admin.teachers', ['teachers' => $teachers]);
    }

    public function getTeacher($username){
        return $this->teacherRepository->getTeacher($username);
    }

    public function add_teacher(Request $request){
        $request->validate([
            'name' => 'required|string',
            'subject' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string',
            'phone' => 'required|numeric|digits:9',
        ]);
        $teacher = $this->teacherRepository->getTeacher($request->username);
        if (!empty($teacher)) return back()->with('username_error',1);
        if ($request->hasFile('photo')){
            $file = $request->file('photo')->extension();
            $name = md5(microtime());
            $photo_name = $name.".".$file;
            $path = $request->file('photo')->move('img/avatars/',$photo_name);
            $this->teacherRepository->addTeacher($request->name,$request->subject, $request->phone, $request->username, $request->password, $photo_name);
            return back()->with('success',1);
        }
        else{
            $this->teacherRepository->addTeacher($request->name,$request->subject, $request->phone, $request->username, $request->password, 'no_photo.jpg');
            return back()->with('success',1);
        }
    }

    public function update_teacher(Request $request){
        $request->validate([
            'password1' => 'required|string',
            'password2' => 'required|string',
        ]);
        if ($request->input('password1') != $request->input('password2')) return back()->with('password_error',1);
        $this->teacherRepository->update_password($request->password1, $request->username);
        return back()->with('change',2);
    }


    //    Payment control
    public function payments(){
        $payments = $this->monthlyPaymentRepository->getPayments();
        return view('admin.payments',['payments' => $payments]);
    }

    //    Student control
    public function students(){
        $students = $this->studentRepository->getStudents();
        return view('admin.students',['students' =>$students]);
    }

    //    subjects control
    public function classes(){
        $subs = $this->classesRepository->getAllClasses();
        return view('admin.classes', ['classes' => $subs]);
    }

    public function classStudents($class_id){
        $classes = $this->classesRepository->getClassWithStudents($class_id);
        $payments = $this->monthlyPaymentRepository->monthPaymentsBySubjectId($class_id);
        $payments_success = $this->monthlyPaymentRepository->getPaidPaymentsByMonth($class_id);
        return view('admin.subject_students',['class_id'=>$class_id,'classes' => $classes, 'payments' => $payments,'payments_success' => $payments_success]);
    }

    public function attendances(){
        $subjects = $this->classesRepository->getAllClasses();
        return view('admin.attendance', ['subjects' => $subjects]);
    }

    public function attendance($subject_id){
        $attendances = $this->attendanceRepository->getAttendanceBySubjectId($subject_id, '09');
        $absentDay = $this->notComeDaysRepository->getTotalAbsentDays($subject_id,'09');
//        return ['attendances' => $attendances, 'attachs' => $attachs, 'subject_id' => $subject_id];
        return view('admin.attendances', ['absentDay'=> $absentDay,'attendances' => $attendances, 'subject_id' => $subject_id]);
    }

    public function outlays(){
        $outlays = $this->outlayRepository->get_outlays100();
        return view('admin.outlays', ['outlays' => $outlays]);
    }

    public function outlays_filtr($date){
        $outlays = $this->outlayRepository->filtr($date);
        return $outlays;
    }


    public function payment_filter(Request $request){
        $startDate = $request->input('start');
        $endDate = $request->input('end');
        return Excel::download(new PaymentFilter($startDate,$endDate), 'tolovlar.xlsx');
    }

    public function outlay_filter(Request $request){
        $startDate = $request->input('start');
        $endDate = $request->input('end');
        return Excel::download(new OutlayExport($startDate,$endDate), 'xarajatlar.xlsx');
    }

    public function salary_filter(Request $request){
        $startDate = $request->input('start');
        $endDate = $request->input('end');
        return Excel::download(new SalaryExport($startDate,$endDate), 'oyliklar.xlsx');
    }

    public function filter(Request $request){
        $request->validate([
            'start' => 'required',
            'end' => 'required',
        ]);
        $payments_cash = $this->monthlyPaymentRepository->filterByTwoDateSumCash($request->start, $request->end);
        $payments_card = $this->monthlyPaymentRepository->filterByTwoDateSumCard($request->start, $request->end);
        $payments_bank = $this->monthlyPaymentRepository->filterByTwoDateSumBank($request->start, $request->end);
        $payments_click = $this->monthlyPaymentRepository->filterByTwoDateSumClick($request->start, $request->end);

        $outlay = $this->outlayRepository->filterByTwoDateSum($request->start, $request->end);
        $salary = $this->salariesRepository->filterByTwoDateSum($request->start, $request->end);

        return view('admin.filter', ['payments_click' => $payments_click,'end'=> $request->end,'start'=> $request->start, 'payments_bank' => $payments_bank,'payments_cash' => $payments_cash,'payments_card' => $payments_card, 'outlay' => $outlay, 'salary' => $salary]);
    }


    public function salaries(){
        return view('admin.salary',['salaries' => $this->salariesRepository->getSalaries(), 'teachers' => $this->teacherRepository->getTeachers()]);
    }

    public function sms(){
        $subjects = $this->classesRepository->getAllClasses();
        return view('admin.sms',['subjects' => $subjects]);
    }

    public function sms_to_teachers(Request $request){
        $request->validate([
            'message' => 'required|string'
        ]);
        $teachers = $this->teacherRepository->getTeachers();
        $res = $this->smsService->sendSMS($teachers, $request->message);
        if($res['status'] == 'success') return back()->with('success',1);
        else return back()->with('error',1);
    }

    public function sms_to_parents(Request $request){
        $request->validate([
            'message' => 'required|string'
        ]);
        $students = $this->studentRepository->getStudentsAll();
        $res = $this->smsService->sendSMSparents($students, $request->message);
        if($res['status'] == 'success') return back()->with('success',1);
        else return back()->with('error',1);
    }

    public function smsBySubject(Request $request){
        $request->validate([
            'message' => 'required|string',
            'subject_id' => 'required|numeric',
        ]);
        $students = $this->studentRepository->getClassStudents($request->subject_id);
        $res = $this->smsService->sendSMSparents($students, $request->message);

        if($res['status'] == 'success') return back()->with('success',1);
        else return back()->with('error',1);
    }

    public function admin_outlay(){
        $outlay = $this->adminOutlayRepository->getOutlays();
        return view('admin.adminOutlay', ['outlays' => $outlay]);
    }

    public function admin_new_outlay(Request $request){
        $this->adminOutlayRepository->add($request->amount, $request->description,$request->date);
        return back()->with('success',1);
    }

    public function admin_delete_outlay($id){
        $this->adminOutlayRepository->delete_outlay($id);
        return back()->with('delete',1);
    }

}
