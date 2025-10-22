<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @extends('layouts.app')

@section('title', 'Сотрудники и должности')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">Список сотрудников и их должностей</h1>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Сотрудники</h5>
                    </div>
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
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($employees as $index => $employee)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $employee->last_name }}</td>
                                    <td>{{ $employee->first_name }}</td>
                                    <td>{{ $employee->middle_name ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $employee->position_name }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Нет данных о сотрудниках</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    

                    <!-- Дополнительная кнопка внизу -->
                    <div class="mt-4 text-center">
                        <a href="{{ route('salaries.index') }}" class="btn btn-success">
                            <i class="fas fa-chart-line"></i> Перейти к просмотру окладов сотрудников
                        </a>
                        <a href="{{ route('employees.departments') }}" class="btn btn-info">
            Отделы
        </a>
                        <a href="{{ route('employees.dismissed') }}" class="btn btn-warning">
            Уволенные
        </a>
         <a href="{{ route('employees.departments-stats') }}" class="btn btn-secondary">
            Статистика
        </a>
         <a href="{{ route('employees.high-paid-programmers') }}" class="btn btn-warning">
            Программисты
        </a>
        <a href="{{ route('employees.long-term') }}" class="btn btn-info">
            Долгий стаж
        </a>
        <a href="{{ route('employees.select-employee') }}" class="btn btn-info">
            История должностей
        </a>
        <a href="{{ route('employees.dismissal-stats') }}" class="btn btn-info" style = "margin-top: 10px;">
            Увольнения по годам
        </a>
        <a href="{{ route('employees.cities') }}" class="btn btn-info" style = "margin-top: 10px;">
            Города
        </a>
        <a href="{{ route('employees.moscow-programmers') }}" class="btn btn-warning" style = "margin-top: 10px;">
            Московские программисты
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