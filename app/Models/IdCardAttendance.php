<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdCardAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'employee_id',
        'id_card',
        'entry_time',
        'exit_time',
        'is_late',
        'late_minutes',
        'working_minutes',
        'position',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
