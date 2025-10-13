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
}