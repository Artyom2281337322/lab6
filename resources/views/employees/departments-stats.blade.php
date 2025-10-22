<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @extends('layouts.app')

@section('title', 'Отделы и сотрудники')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">Отделы и сотрудники</h1>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Количество сотрудников по отделам</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Название отдела</th>
                                    <th>Количество сотрудников</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($departmentsWithCount as $index => $department)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $department->department_name ?? $department->name }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $department->employees_count > 0 ? 'success' : 'secondary' }}">
                                            {{ $department->employees_count ?? $department->employees_count }} сотрудников
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Нет данных об отделах</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($departmentsWithCount->count())
                    <div class="mt-3">
                        @php
                            $totalEmployees = $departmentsWithCount->sum('employees_count');
                            $totalDepartments = $departmentsWithCount->count();
                            $averageEmployees = $totalDepartments > 0 ? round($totalEmployees / $totalDepartments, 1) : 0;
                        @endphp
                    </div>
                    @endif

                    <!-- Дополнительная кнопка внизу -->
                    <div class="mt-4 text-center">
                        <a href="{{ route('employees.departments') }}" class="btn btn-info btn-lg">
                            Подробнее о сотрудниках
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