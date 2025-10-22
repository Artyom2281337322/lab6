<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Employee extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_employee';
    
    protected $fillable = [
        'last_name',
        'first_name', 
        'middle_name',
        'gender',
        'birth_date',
        'id_department',
        'id_city'
    ];

    // Отношение к истории должностей
    public function positionHistories()
    {
        return $this->hasMany(PositionHistory::class, 'id_employee');
    }

    // Текущая должность сотрудника
    public function currentPosition()
    {
        return $this->hasOne(PositionHistory::class, 'id_employee')
                    ->whereNull('end_date')
                    ->with('position');
    }

    // Отношение к отделу
    public function department()
    {
        return $this->belongsTo(Department::class, 'id_department');
    }

    // Отношение к городу
    public function city()
    {
        return $this->belongsTo(City::class, 'id_city');
    }


    public static function getWithSalaries()
    {
        return self::select([
                'employees.id_employee',
                'employees.last_name',
                'employees.first_name', 
                'employees.middle_name',
                'positions.salary'
            ])
            ->join('position_history', function($join) {
                $join->on('employees.id_employee', '=', 'position_history.id_employee')
                     ->whereNull('position_history.end_date'); // Текущая должность
            })
            ->join('positions', 'position_history.id_position', '=', 'positions.id_position')
            ->orderBy('positions.salary', 'DESC')
            ->get();
    }

    // Аксессор для полного имени
    public function getFullNameAttribute()
    {
        return $this->last_name . ' ' . $this->first_name . ' ' . $this->middle_name;
    }

     protected $guarded = [];
}

   
