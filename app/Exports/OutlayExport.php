<?php

namespace App\Exports;

use App\Models\MonthlyPayment;
use App\Models\Outlay;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class OutlayExport implements FromView
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
        $payments = Outlay::with('types')->whereBetween('date', [$this->startDate, $this->endDate])->get();

        return view('exports.outlay', [
            'outlays' => $payments,
        ]);
    }
}
