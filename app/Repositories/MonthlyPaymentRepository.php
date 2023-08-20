<?php

namespace App\Repositories;

use App\Models\MonthlyPayment;
use Illuminate\Support\Facades\DB;

class MonthlyPaymentRepository
{
    public function add($data){
        MonthlyPayment::insert($data);
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
}
