<?php

namespace App\Exports;

use App\Models\MonthlyPayment;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class PaymentFilter implements FromView
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View
    {
        $payments = MonthlyPayment::whereBetween('date', [$this->startDate, $this->endDate])->where('paid', '>',0)->get();

        return view('exports.paymentFilter', [
            'payments' => $payments,
        ]);
    }

}
