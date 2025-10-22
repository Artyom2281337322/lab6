<?php
// app/Models/Dismissal.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dismissal extends Model
{
    use HasFactory;

    protected $table = 'dismissals';
    protected $primaryKey = 'id_employee'; // Первичный ключ - employee_id
    public $incrementing = false; // Важно! Так как первичный ключ не автоинкрементный
    public $timestamps = false;

    protected $fillable = [
        'employee_id',
        'date',
        'reason'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Связь с сотрудником
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'id_employee', 'id_employee');
    }
}