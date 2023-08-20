<?php

namespace App\Repositories;

use App\Models\District;
use App\Models\Quarter;

class DistrictRepository
{
    public function districts($id){
        return District::where('region_id', $id)->get();
    }

    public function quarters($id){
        return Quarter::where('district_id', $id)->get();
    }
}
