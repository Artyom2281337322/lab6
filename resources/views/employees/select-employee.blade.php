<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @extends('layouts.app')

@section('title', 'Выбор сотрудника')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">Выбор сотрудника</h1>
                <a href="{{ route('employees.index') }}" class="btn btn-primary">
                    👥 Все сотрудники
                </a>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Выберите сотрудника для просмотра истории должностей</h5>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('employees.position-history') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="employee_id" class="form-label">Выберите сотрудника:</label>
                            <select class="form-select" id="employee_id" name="employee_id" required>
                                <option value="">-- Выберите сотрудника --</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id_employee }}">
                                        {{ $employee->last_name }} {{ $employee->first_name }} {{ $employee->middle_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Показать историю должностей</button>
                    </form>

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