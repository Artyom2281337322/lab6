<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionHistory extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_record';
    
    protected $fillable = [
        'id_employee',
        'id_position',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Отношение к сотруднику
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'id_employee');
    }

    // Отношение к должности
    public function position()
    {
        return $this->belongsTo(Position::class, 'id_position');
    }

// app/Models/PositionHistory.php


    use HasFactory;

    protected $table = 'position_histories';
 
    public $timestamps = false;


    // Связь с сотрудником
    
    // Связь с должностью
   

    // Проверка, является ли текущей должностью
    public function getIsCurrentAttribute()
    {
        return $this->end_date === null;
    }
     protected $guarded = [];
}
   
