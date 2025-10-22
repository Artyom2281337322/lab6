<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_position';
    
    protected $fillable = [
        'name',
        'salary'
    ];

    // Отношение к истории должностей
    public function positionHistories()
    {
        return $this->hasMany(PositionHistory::class, 'id_position');
    }

    // Текущие сотрудники на этой должности
    public function currentEmployees()
    {
        return $this->hasManyThrough(
            Employee::class,
            PositionHistory::class,
            'id_position', // Внешний ключ в таблице position_history
            'id_employee', // Внешний ключ в таблице employees  
            'id_position', // Локальный ключ в таблице positions
            'id_employee'  // Локальный ключ в таблице position_history
        )->whereNull('position_history.end_date');
    }

    

    use HasFactory;

    protected $table = 'positions';
   
    public $timestamps = false;

  

    protected $casts = [
        'salary' => 'integer'
    ];

    // Связь с историей должностей
    

    // Связь с сотрудниками через историю должностей
    public function employees()
    {
        return $this->hasManyThrough(
            Employee::class,
            PositionHistory::class,
            'id_position', // Внешний ключ в position_histories
            'id_employee', // Внешний ключ в employees
            'id_position', // Локальный ключ в positions
            'id_employee'  // Локальный ключ в position_histories
        );
    }
     protected $guarded = [];
}

   
