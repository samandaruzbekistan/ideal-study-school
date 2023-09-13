<?php

namespace App\Repositories;

use App\Models\AdminOutlay;

class AdminOutlayRepository
{
    public function getOutlays(){
        return AdminOutlay::latest()->get();
    }

    public function add($amount, $description,$d){
        $o = new AdminOutlay;
        $o->amount = $amount;
        $o->description = $description;
        $o->date = $d;
        $o->save();
    }

    public function delete_outlay($id){
        AdminOutlay::where('id', $id)->delete();
    }
}
