<?php

namespace App\Repositories;

use App\Models\Manager;
use Illuminate\Support\Facades\Hash;

class ManagerRepository
{
    public function getManager($username){
        return Manager::where('username', $username)->first();
    }

    public function update_password($password){
        Manager::where('id', session('id'))->update(['password' => Hash::make($password)]);
    }

    public function update_photo($photo){
        Manager::where('id', session('id'))->update(['photo' => $photo]);
    }
}
