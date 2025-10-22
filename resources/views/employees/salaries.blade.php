<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оклады сотрудников</title>
</head>
<body>
    @extends('layouts.app')

@section('title', 'Оклады сотрудников')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">Оклады сотрудников</h1>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Сотрудники и оклады</h5>
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
                                    <th>Оклад</th>
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
                                        <span class="badge bg-success">{{ number_format($employee->salary, 0, '', ' ') }} руб.</span>
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
                    
                    @if($employees->count())
                    <div class="mt-3">
                        <small class="text-muted">Всего сотрудников: {{ $employees->count() }}</small>
                    </div>
                    @endif

                    <!-- Дополнительная кнопка внизу -->
                    <div class="mt-4 text-center">
                        <a href="{{ route('employees.index') }}" class="btn btn-primary btn-lg">
                            Перейти к списку должностей
                        </a>
                        <a href="{{ route('employees.dismissed') }}" class="btn btn-warning">
            🚪 Уволенные
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