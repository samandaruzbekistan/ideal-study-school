<?php

namespace App\Repositories;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminRepository
{
    public function getAdmin($username){
        return Admin::where('username', $username)->first();
    }

    public function update_password($password){
        Admin::where('id', session('id'))->update(['password' => Hash::make($password)]);
    }

    public function update_photo($photo){
        Admin::where('id', session('id'))->update(['photo' => $photo]);
    }
}
