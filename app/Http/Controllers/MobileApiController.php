<?php

namespace App\Http\Controllers;

use App\Repositories\StudentRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\MonthlyPayment;
use App\Models\Classes;
use Carbon\Carbon;

class MobileApiController extends Controller
{
    public function __construct(
        protected StudentRepository $studentRepository,
    )
    {
    }

    public function getUsers(){
        $users = DB::table('students')->where('status',1)->pluck('phone')->toArray();
        return response()->json($users, 200);
    }

    public function getDebtMonths(){
        return MonthlyPayment::query()
            ->where('status', 0)
            ->groupBy('month')
            ->get();
    }

    public function getDebtByMonth($month) {
        $users = MonthlyPayment::query()
            ->with(['student' => function ($query) {
                $query->select('id', 'name', 'phone');
            }])->where('month', $month)->where('status', 0)->get();;
        return response()->json($users, 200);
    }
}
