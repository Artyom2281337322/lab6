<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Dismissal;
use Illuminate\Support\Carbon;
use App\Models\Department;
use App\Models\PositionHistory;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    //1 запрос
    public function index()
    {
        $employees = Employee::select(
                'employees.id_employee',
                'employees.last_name',
                'employees.first_name', 
                'employees.middle_name',
                'positions.name as position_name'
            )
            ->join('position_history', 'employees.id_employee', '=', 'position_history.id_employee')
            ->join('positions', 'position_history.id_position', '=', 'positions.id_position')
            ->whereNull('position_history.end_date') 
            ->orderBy('positions.name') 
            ->orderBy('employees.last_name') 
            ->orderBy('employees.first_name') 
            ->orderBy('employees.middle_name') 
            ->get();

        return view('employees.index', compact('employees'));
    }
//2 запрос
    public function index1()
    {
        
        $employees = Employee::getWithSalaries();
        
        return view('employees.salaries', compact('employees'));
    }

    
    public function indexWithFormatting()
    {
        $employees = Employee::getWithSalaries()
            ->map(function($employee) {
               
                $employee->formatted_salary = number_format($employee->salary, 0, '', ' ') . ' руб.';
                return $employee;
            });
        
        return view('employees.salaries', compact('employees'));
    }

    //3 запрос
     public function dismissed()
    {
        
        $threeYearsAgo = Carbon::now()->subYears(3);

        $dismissedEmployees = Employee::select(
                'employees.id_employee',
                'employees.last_name',
                'employees.first_name', 
                'employees.middle_name',
                'dismissals.date as dismissal_date',
                'dismissals.reason as dismissal_reason'
            )
            ->join('dismissals', 'employees.id_employee', '=', 'dismissals.id_employee')
            ->where('dismissals.date', '>=', $threeYearsAgo)
            ->orderBy('dismissals.date', 'DESC')
            ->get();

        return view('employees.dismissed', compact('dismissedEmployees'));
    }

    //4 запрос
    public function departments()
    {
        $employeesWithDepartments = Employee::select(
                'employees.id_employee',
                'employees.last_name',
                'employees.first_name', 
                'employees.middle_name',
                'departments.name as department_name'
            )
            ->join('departments', 'employees.id_department', '=', 'departments.id_department')
            ->orderBy('departments.name')
            ->orderBy('employees.last_name')
            ->orderBy('employees.first_name')
            ->orderBy('employees.middle_name')
            ->get();

        return view('employees.departments', compact('employeesWithDepartments'));
    }

    //5 запрос
    public function departmentsStats()
    {
        $departmentsWithCount = Department::select(
                'departments.id_department',
                'departments.name as department_name',
                \DB::raw('COUNT(employees.id_employee) as employees_count')
            )
            ->leftJoin('employees', 'departments.id_department', '=', 'employees.id_department')
            ->groupBy('departments.id_department', 'departments.name')
            ->orderBy('employees_count', 'DESC')
            ->orderBy('departments.name')
            ->get();

        return view('employees.departments-stats', compact('departmentsWithCount'));
    }

    //6 запрос
     public function highPaidProgrammers()
    {
        $programmers = Employee::select(
                'employees.id_employee',
                'employees.last_name',
                'employees.first_name', 
                'employees.middle_name',
                'positions.name as position_name',
                'positions.salary'
            )
            ->join('position_history', 'employees.id_employee', '=', 'position_history.id_employee')
            ->join('positions', 'position_history.id_position', '=', 'positions.id_position')
            ->where('positions.salary', '>', 100000)
            ->where('employees.last_name', 'LIKE', 'П%')
            ->where(function($query) {
                $query->where('positions.name', 'LIKE', '%программист%')
                      ->orWhere('positions.name', 'LIKE', '%разработчик%');
            })
            ->whereNull('position_history.end_date') // только текущие должности
            ->orderBy('positions.salary', 'DESC')
            ->orderBy('employees.last_name')
            ->get();

        return view('employees.high-paid-programmers', compact('programmers'));
    }

     //7 запрос
      public function longTermEmployees()
    {
        $longTermEmployees = DB::table('position_history')
            ->select(
                'employees.id_employee',
                'employees.last_name',
                'employees.first_name', 
                'employees.middle_name',
                'positions.name as position_name',
                'position_history.start_date',
                'position_history.end_date',
                DB::raw('DATEDIFF(COALESCE(position_history.end_date, CURDATE()), position_history.start_date) as days_worked'),
                DB::raw('TIMESTAMPDIFF(YEAR, position_history.start_date, COALESCE(position_history.end_date, CURDATE())) as years_worked')
            )
            ->join('employees', 'position_history.id_employee', '=', 'employees.id_employee')
            ->join('positions', 'position_history.id_position', '=', 'positions.id_position')
            ->having('years_worked', '>=', 5)
            ->orderBy('years_worked', 'DESC')
            ->orderBy('employees.last_name')
            ->get();

        return view('employees.long-term', compact('longTermEmployees'));
    }

    //8 запрос
   public function selectEmployee()
    {
        $employees = Employee::select('id_employee', 'last_name', 'first_name', 'middle_name')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('employees.select-employee', compact('employees'));
    }

  
    public function employeePositionHistory(Request $request)
    {
        $employeeId = $request->input('employee_id');
        
        if (!$employeeId) {
            return redirect()->route('employees.select-employee')
                ->with('error', 'Выберите сотрудника');
        }

        $employee = Employee::findOrFail($employeeId);
        
 
        $positionHistory = DB::table('position_history')
            ->select(
                'positions.name as position_name',
                'position_history.start_date',
                'position_history.end_date',
                DB::raw('CASE 
                    WHEN position_history.end_date IS NULL THEN 
                        TIMESTAMPDIFF(YEAR, position_history.start_date, CURDATE())
                    ELSE 
                        TIMESTAMPDIFF(YEAR, position_history.start_date, position_history.end_date)
                END as years_worked'),
                DB::raw('CASE 
                    WHEN position_history.end_date IS NULL THEN 
                        TIMESTAMPDIFF(MONTH, position_history.start_date, CURDATE()) % 12
                    ELSE 
                        TIMESTAMPDIFF(MONTH, position_history.start_date, position_history.end_date) % 12
                END as months_worked'),
                DB::raw('CASE 
                    WHEN position_history.end_date IS NULL THEN 
                        DATEDIFF(CURDATE(), position_history.start_date)
                    ELSE 
                        DATEDIFF(position_history.end_date, position_history.start_date)
                END as days_worked')
            )
            ->join('positions', 'position_history.id_position', '=', 'positions.id_position')
            ->where('position_history.id_employee', $employeeId)
            ->orderBy('position_history.start_date', 'DESC')
            ->get();

        $totalExperience = $this->calculateTotalExperience($positionHistory);

        return view('employees.position-history', compact('employee', 'positionHistory', 'totalExperience'));
    }

    
    private function calculateTotalExperience($positionHistory)
    {
        $totalDays = 0;
        
        foreach ($positionHistory as $position) {
            $totalDays += $position->days_worked;
        }

        $totalYears = floor($totalDays / 365);
        $remainingDays = $totalDays % 365;
        $totalMonths = floor($remainingDays / 30);
        $remainingDays = $remainingDays % 30;

        return [
            'years' => $totalYears,
            'months' => $totalMonths,
            'days' => $remainingDays,
            'total_days' => $totalDays
        ];
    }

    //9-10 запрос
    public function dismissalStats()
    {
        $dismissalStats = DB::table('dismissals')
            ->select(
                DB::raw('YEAR(date) as dismissal_year'),
                DB::raw('COUNT(id_employee) as employees_count')
            )
            ->groupBy('dismissal_year')
            ->orderBy('dismissal_year', 'DESC')
            ->get();

        return view('employees.dismissal-stats', compact('dismissalStats'));
    }

    public function dismissalStatsWithTotal()
    {
        $dismissalStats = DB::table('dismissals')
            ->select(
                DB::raw('YEAR(date) as dismissal_year'),
                DB::raw('COUNT(id_employee) as employees_count')
            )
            ->groupBy('dismissal_year')
            ->orderBy('dismissal_year', 'DESC')
            ->get();

        $totalDismissed = $dismissalStats->sum('employees_count');
        $yearsCount = $dismissalStats->count();
        $averagePerYear = $yearsCount > 0 ? round($totalDismissed / $yearsCount, 1) : 0;

        return view('employees.dismissal-stats', compact('dismissalStats', 'totalDismissed', 'yearsCount', 'averagePerYear'));
    }

    //11 запрос
    public function employeesCities()
    {
        $employeesWithCities = Employee::select(
                'employees.id_employee',
                'employees.last_name',
                'employees.first_name', 
                'employees.middle_name',
                'cities.name as city_name'
            )
            ->join('cities', 'employees.id_city', '=', 'cities.id_city')
            ->orderBy('cities.name')
            ->orderBy('employees.last_name')
            ->orderBy('employees.first_name')
            ->get();

        return view('employees.employees-cities', compact('employeesWithCities'));
    }

    //12 запрос
    public function moscowProgrammers()
    {
        $moscowProgrammers = DB::table('employees as e')
            ->select(
                'e.id_employee',
                'e.last_name',
                'e.first_name', 
                'e.middle_name',
                'p.name as position_name',
                'c.name as city_name',
                'ph.start_date',
                'ph.end_date',
                DB::raw('CASE 
                    WHEN ph.end_date IS NULL THEN 
                        TIMESTAMPDIFF(YEAR, ph.start_date, CURDATE())
                    ELSE 
                        TIMESTAMPDIFF(YEAR, ph.start_date, ph.end_date)
                END as years_worked'),
                DB::raw('CASE 
                    WHEN ph.end_date IS NULL THEN 
                        DATEDIFF(CURDATE(), ph.start_date)
                    ELSE 
                        DATEDIFF(ph.end_date, ph.start_date)
                END as days_worked')
            )
            ->join('cities as c', 'e.id_city', '=', 'c.id_city')
            ->join('position_history as ph', 'e.id_employee', '=', 'ph.id_employee')
            ->join('positions as p', 'ph.id_position', '=', 'p.id_position')
            ->where('c.name', 'Москва')
            ->where(function($query) {
                $query->where('p.name', 'LIKE', '%программист%')
                      ->orWhere('p.name', 'LIKE', '%разработчик%')
                      ->orWhere('p.name', 'LIKE', '%developer%');
            })
            ->having('years_worked', '>=', 10)
            ->orderBy('years_worked', 'DESC')
            ->orderBy('e.last_name')
            ->get();

        return view('employees.moscow-programmers', compact('moscowProgrammers'));
    }

    //13 запрос
    public function citiesWithManyEmployees()
    {
        $citiesWithEmployees = DB::table('cities as c')
            ->select(
                'c.id_city',
                'c.name as city_name',
                DB::raw('COUNT(e.id_employee) as employees_count')
            )
            ->join('employees as e', 'c.id_city', '=', 'e.id_city')
            ->groupBy('c.id_city', 'c.name')
            ->having('employees_count', '>', 4)
            ->orderBy('employees_count', 'DESC')
            ->orderBy('c.name')
            ->get();

        return view('employees.cities-many-employees', compact('citiesWithEmployees'));
    }

    //14 запрос
    public function averageAgeDismissed()
    {
        
        $averageAgeData = DB::table('employees as e')
            ->select(
                DB::raw('AVG(TIMESTAMPDIFF(YEAR, e.birth_date, d.date)) as average_age'),
                DB::raw('COUNT(e.id_employee) as total_dismissed'),
                DB::raw('MIN(TIMESTAMPDIFF(YEAR, e.birth_date, d.date)) as min_age'),
                DB::raw('MAX(TIMESTAMPDIFF(YEAR, e.birth_date, d.date)) as max_age')
            )
            ->join('dismissals as d', 'e.id_employee', '=', 'd.id_employee')
            ->first();

    
        $dismissedEmployees = DB::table('employees as e')
            ->select(
                'e.id_employee',
                'e.last_name',
                'e.first_name', 
                'e.middle_name',
                'e.birth_date',
                'd.date as dismissal_date',
                'd.reason as dismissal_reason',
                DB::raw('TIMESTAMPDIFF(YEAR, e.birth_date, d.date) as age_at_dismissal')
            )
            ->join('dismissals as d', 'e.id_employee', '=', 'd.id_employee')
            ->orderBy('age_at_dismissal', 'DESC')
            ->get();

        return view('employees.average-age-dismissed', compact('averageAgeData', 'dismissedEmployees'));
    }

    //15 запрос
    public function lastDismissedEmployee()
    {
        
        $lastDismissed = DB::table('employees as e')
            ->select(
                'e.id_employee',
                'e.last_name',
                'e.first_name', 
                'e.middle_name',
                'e.gender',
                'e.birth_date',
                'd.date as dismissal_date',
                'd.reason as dismissal_reason',
                DB::raw('TIMESTAMPDIFF(YEAR, e.birth_date, CURDATE()) as current_age'),
                DB::raw('TIMESTAMPDIFF(YEAR, e.birth_date, d.date) as age_at_dismissal')
            )
            ->join('dismissals as d', 'e.id_employee', '=', 'd.id_employee')
            ->orderBy('d.date', 'DESC')
            ->first();

        if (!$lastDismissed) {
            return view('employees.last-dismissed', ['lastDismissed' => null]);
        }

        
        $totalExperience = DB::table('position_history')
            ->select(
                DB::raw('SUM(DATEDIFF(COALESCE(end_date, CURDATE()), start_date)) as total_days')
            )
            ->where('id_employee', $lastDismissed->id_employee)
            ->first();

   
        $experience = $this->formatExperience($totalExperience->total_days ?? 0);

       
        $fullNameFormatted = $this->formatFullName($lastDismissed->last_name, $lastDismissed->first_name, $lastDismissed->middle_name);

        return view('employees.last-dismissed', compact('lastDismissed', 'experience', 'fullNameFormatted'));
    }

   
    private function formatExperience($totalDays)
    {
        $years = floor($totalDays / 365);
        $remainingDays = $totalDays % 365;
        $months = floor($remainingDays / 30);
        $days = $remainingDays % 30;

        return [
            'years' => $years,
            'months' => $months,
            'days' => $days,
            'total_days' => $totalDays
        ];
    }

    private function formatFullName($lastName, $firstName, $middleName)
    {
        $firstInitial = mb_substr($firstName, 0, 1) . '.';
        $middleInitial = $middleName ? mb_substr($middleName, 0, 1) . '.' : '';
        
        return $lastName . ' ' . $firstInitial . $middleInitial;
    }
}