<?php

namespace App\Repositories;

use App\Models\MonthlyPayment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MonthlyPaymentRepository
{
    public function add($data){
        MonthlyPayment::insert($data);
    }

    public function getPayment($id){
        return MonthlyPayment::find($id);
    }

    public function monthPaymentsBySubjectId($class_id){
        $payments = MonthlyPayment::where('class_id', $class_id)
            ->select('month','class_id', DB::raw('SUM(paid) as total'),DB::raw('SUM(indebtedness) as debt'))
            ->groupBy('month')
            ->get();

        return $payments;
    }

    public function filterByTwoDateSumCash($start, $end){
        $receiptsData = MonthlyPayment::whereBetween('date', [$start, $end])->where('type', 'cash')->get();

        // Calculate the sum of 'amount' column
        return $receiptsData->sum('paid');
    }

    public function filterByTwoDateSumBank($start, $end){
        $receiptsData = MonthlyPayment::whereBetween('date', [$start, $end])->where('type', 'transfer')->get();

        // Calculate the sum of 'amount' column
        return $receiptsData->sum('paid');
    }

    public function filterByTwoDateSumCard($start, $end){
        $receiptsData = MonthlyPayment::whereBetween('date', [$start, $end])->where('type', 'credit_card')->get();

        // Calculate the sum of 'amount' column
        return $receiptsData->sum('paid');
    }

    public function filterByTwoDate($start, $end){
        $receiptsData = MonthlyPayment::whereBetween('date', [$start, $end])->where('type', 'cash')->get();

        // Calculate the sum of 'amount' column
        return $receiptsData->sum('paid');
    }

    public function getPaidPaymentsByMonth($class_id){
        $payments_success = MonthlyPayment::where('class_id', $class_id)
            ->where('paid','>',0)
            ->select(
                DB::raw('DATE_FORMAT(date, "%Y-%m") as month'),
                DB::raw('SUM(paid) as total')
            )
            ->groupBy(DB::raw('DATE_FORMAT(date, "%Y-%m")'))
            ->orderBy(DB::raw('DATE_FORMAT(date, "%Y-%m")'), 'desc')
            ->get();
        return $payments_success;
    }

    public function getPaymentsByMonth($month, $class_id){
        return MonthlyPayment::query()
            ->with(['student' => function ($query) {
                $query->select('id', 'name');
            },'classes' => function ($query) {
                $query->select('id', 'name');
            }])->where('month', $month)->where('class_id', $class_id)->get();
    }

    public function monthPaymentsByDateOrderType($date){
        $payments = MonthlyPayment::where('date', $date)
            ->select('type', DB::raw('SUM(paid) as total'))
            ->groupBy('type')
            ->get();

        return $payments;
    }

    public function getPayments7(){
        return MonthlyPayment::query()
            ->with(['student' => function ($query) {
                $query->select('id', 'name');
            }, 'classes' => function ($query) {
                $query->select('id', 'name');
            }])->where('date','!=', null)->orderBy('date', 'desc')->paginate(7);
    }

    public function getPaymentsByDate($date){
        return MonthlyPayment::with('student','classes')->where('date', $date)->latest()->get();
    }

    public function getPaymentByStudentId($student_id){
        return MonthlyPayment::where('student_id',$student_id)->get();
    }

    public function payment($id,$indebtedness,$paid,$type,$status){
        $currentDateTime = Carbon::now('Asia/Tashkent');
        MonthlyPayment::where('id', $id)
            ->update([
                'indebtedness' => $indebtedness,
                'paid' => $paid,
                'type' => $type,
                'status' => $status,
                'date' => date('Y-m-d'),
                'cashier_id' => session('id'),
                'created_at' => $currentDateTime
            ]);
    }

    public function addPayment($student_id, $class_id, $indebtedness,$month, $paid){
        $payment = new MonthlyPayment;
        $payment->student_id = $student_id;
        $payment->class_id = $class_id;
        $payment->indebtedness = $indebtedness;
        $payment->month = $month;
        $payment->cashier_id = session('id');
        $payment->status = 1;
        $payment->date = date('Y-m-d');
        $payment->paid = $paid;
        $payment->save();
    }

    public function updatePayment($id, $amount){
        $payment = MonthlyPayment::find($id);
        $payment->indebtedness = $amount;
        $payment->cashier_id  = session('id');
        $payment->save();
        return $payment->id;
    }

    public function getPayments(){
        return MonthlyPayment::query()
            ->with(['student' => function ($query) {
                $query->select('id', 'name');
            }, 'classes' => function ($query) {
                $query->select('id', 'name');
            }])->where('date','!=', null)->orderBy('date', 'desc')->paginate(100);
    }

    public function filtr($date){
        return MonthlyPayment::query()
            ->with(['student' => function ($query) {
                $query->select('id','name');
            },'classes' => function ($query) {
                $query->select('id', 'name');
            }])->where('date', $date)->get();
    }

    public function getDebtStudents($month, $subject_id){
        return MonthlyPayment::query()
            ->with(['student' => function ($query) {
                $query->select('id','phone');
            }])->where('month', $month)->where('class_id', $subject_id)
            ->where('status', 0)->get();
    }

    public function getPaymentByMonth($student_id, $month){
        return MonthlyPayment::where('student_id', $student_id)
            ->where('month', $month)
            ->first();
    }

    public function deleteNowAndNextPayments($monthToDelete,$student_id){
        MonthlyPayment::where('month', '>=', $monthToDelete)
            ->where('student_id',$student_id)
            ->delete();
    }

    public function deleteNextPayments($monthToDelete,$student_id){
        MonthlyPayment::where('month', '>', $monthToDelete)
            ->where('student_id',$student_id)
            ->delete();
    }
}
