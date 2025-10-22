<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @extends('layouts.app')

@section('title', 'Уволенные сотрудники')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">Уволенные сотрудники</h1>
                <a href="{{ route('employees.index') }}" class="btn btn-primary">
                    👥 Вернуться к сотрудникам
                </a>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Уволенные сотрудники за последние 3 года</h5>
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
                                    <th>Дата увольнения</th>
                                    <th>Причина увольнения</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dismissedEmployees as $index => $employee)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $employee->last_name }}</td>
                                    <td>{{ $employee->first_name }}</td>
                                    <td>{{ $employee->middle_name ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-danger">
                                            {{ \Carbon\Carbon::parse($employee->dismissal_date ?? $employee->dismissal->date)->format('d.m.Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning text-dark">
                                            {{ $employee->dismissal_reason ?? $employee->dismissal->reason }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Нет данных об уволенных сотрудниках</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($dismissedEmployees->count())
                    <div class="mt-3">
                        <small class="text-muted">Всего уволенных за последние 3 года: {{ $dismissedEmployees->count() }}</small>
                    </div>
                    @endif

                    
                    <div class="mt-4 text-center">
                        <a href="{{ route('employees.index') }}" class="btn btn-primary btn-lg">
                            👨‍💼 Вернуться к списку сотрудников
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