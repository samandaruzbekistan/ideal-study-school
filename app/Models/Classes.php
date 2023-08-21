<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }


    public function monthlyPayments()
    {
        return $this->hasMany(MonthlyPayment::class, 'class_id');
    }

    public function notComeDays()
    {
        return $this->hasMany(NotComeDays::class, 'class_id');
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'class_id');
    }
}
