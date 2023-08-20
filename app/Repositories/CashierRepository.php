<?php

namespace App\Repositories;

use App\Models\Cashier;
use Illuminate\Support\Facades\Hash;

class CashierRepository
{
    public function getCashiers(){
        return Cashier::orderBy('name', 'asc')->get();
    }

    public function getCashier($username){
        return Cashier::where('username', $username)->first();
    }

    public function addCashier($name, $phone, $username, $password, $photo){
        $teacher = new Cashier;
        $teacher->name = $name;
        $teacher->phone = '998'.$phone;
        $teacher->username = $username;
        $teacher->password = Hash::make($password);
        $teacher->photo = $photo;
        $teacher->save();
    }

    public function update_password($password, $username){
        Cashier::where('username', $username)->update(['password' => Hash::make($password)]);
    }

    public function update_photo($photo){
        Cashier::where('id', session('id'))->update(['photo' => $photo]);
    }
}
