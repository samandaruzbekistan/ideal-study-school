<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutlayType extends Model
{
    use HasFactory;

    public function outlays()
    {
        return $this->hasMany(Outlay::class, 'type_id');
    }
}
