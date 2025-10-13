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
            <h1 class="mb-4">Список сотрудников и их должностей</h1>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Сотрудники</h5>
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
                    
                    @if($employees->count())
                    <div class="mt-3">
                        <small class="text-muted">Всего сотрудников: {{ $employees->count() }}</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
</body>
</html>