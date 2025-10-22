<?php
// app/Models/City.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table = 'cities';
    protected $primaryKey = 'city_id';
    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    // Связь с сотрудниками
    public function employees()
    {
        return $this->hasMany(Employee::class, 'city_id');
    }
}