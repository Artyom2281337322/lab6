<?php
// app/Models/Department.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';
    protected $primaryKey = 'id_department';
    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    // Связь с сотрудниками
    public function employees()
    {
        return $this->hasMany(Employee::class, 'id_department');
    }
}