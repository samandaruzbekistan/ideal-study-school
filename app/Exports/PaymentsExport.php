<?php

namespace App\Exports;

use App\Models\MonthlyPayment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class PaymentsExport implements FromView, WithTitle
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

    public function title(): string
    {
        $date = date('d.m.Y');
        return 'To\'lovlar '.$date;
    }
}
