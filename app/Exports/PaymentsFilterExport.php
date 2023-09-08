<?php

namespace App\Exports;

use App\Models\MonthlyPayment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class PaymentsFilterExport implements FromView
{
    public function view(): View
    {
        $payments = MonthlyPayment::with(['student', 'classes'])
            ->where('paid','>',0)
            ->get();

        return view('exports.payments', [
            'payments' => $payments,
        ]);
    }

}
