<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @extends('layouts.app')

@section('title', 'Сотрудники с долгим стажем')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">Сотрудники с долгим стажем</h1>
            </div>

            <div class="alert alert-info">
                <h5 class="alert-heading">Критерии отбора</h5>
                <p class="mb-0">
                    • Проработали 5 лет и более на одной должности
                  
                </p>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Сотрудники со стажем 5+ лет</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Фамилия</th>
                                    <th>Имя</th>
                                    <th>Отчество</th>
                                    <th>Должность</th>
                                    <th>Начало работы</th>
                                    <th>Окончание</th>
                                    <th>Стаж (лет)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($longTermEmployees as $index => $employee)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $employee->last_name }}</strong>
                                    </td>
                                    <td>{{ $employee->first_name }}</td>
                                    <td>{{ $employee->middle_name ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $employee->position_name }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ \Carbon\Carbon::parse($employee->start_date)->format('d.m.Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $employee->end_date ? 'warning' : 'success' }}">
                                            {{ $employee->end_date ? \Carbon\Carbon::parse($employee->end_date)->format('d.m.Y') : 'по настоящее время' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $employee->years_worked }} лет
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        Нет сотрудников, проработавших 5+ лет на одной должности
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($longTermEmployees->count())
                    <div class="mt-3">
                        @php
                            $totalEmployees = $longTermEmployees->count();
                            $averageYears = $longTermEmployees->avg('years_worked');
                            $maxYears = $longTermEmployees->max('years_worked');
                            $currentPositions = $longTermEmployees->where('end_date', null)->count();
                        @endphp
                    </div>

                    <!-- Дополнительная статистика -->
                    
                    @endif

                    <!-- Дополнительная кнопка внизу -->
                    <div class="mt-4 text-center">
                        <a href="{{ route('employees.index') }}" class="btn btn-primary btn-lg">
                            Вернуться к общему списку
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
</body>
</html>