<?php

namespace App\Exports;

use App\Models\Outlay;
use App\Models\Salary;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class SalaryExport implements FromView
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
        $payments = Salary::with('teacher')->whereBetween('date', [$this->startDate, $this->endDate])->get();

        return view('exports.salary', [
            'salaries' => $payments,
        ]);
    }
}
