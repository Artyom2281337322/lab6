<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @extends('layouts.app')

@section('title', 'История должностей')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">История должностей</h1>
                <div>
                    <a href="{{ route('employees.select-employee') }}" class="btn btn-primary">
                        🔄 Выбрать другого сотрудника
                    </a>
                    <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                        👥 Все сотрудники
                    </a>
                </div>
            </div>

            <!-- Информация о сотруднике -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">Информация о сотруднике</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>ФИО:</strong> {{ $employee->last_name }} {{ $employee->first_name }} {{ $employee->middle_name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Общий стаж в компании:</strong> 
                                {{ $totalExperience['years'] }} лет, 
                                {{ $totalExperience['months'] }} месяцев, 
                                {{ $totalExperience['days'] }} дней
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">История должностей</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Должность</th>
                                    <th>Дата начала</th>
                                    <th>Дата окончания</th>
                                    <th>Стаж на должности</th>
                                    <th>Статус</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($positionHistory as $index => $position)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $position->position_name }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ \Carbon\Carbon::parse($position->start_date)->format('d.m.Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($position->end_date)
                                            <span class="badge bg-warning text-dark">
                                                {{ \Carbon\Carbon::parse($position->end_date)->format('d.m.Y') }}
                                            </span>
                                        @else
                                            <span class="badge bg-success">по настоящее время</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $position->years_worked }} л. {{ $position->months_worked }} мес.
                                        </span>
                                    </td>
                                    <td>
                                        @if($position->end_date)
                                            <span class="badge bg-secondary">Прошлая</span>
                                        @else
                                            <span class="badge bg-success">Текущая</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        Нет данных о должностях сотрудника
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($positionHistory->count())
                    <div class="mt-3">
                        @php
                            $totalPositions = $positionHistory->count();
                            $currentPositions = $positionHistory->where('end_date', null)->count();
                            $pastPositions = $totalPositions - $currentPositions;
                            $averageYears = $positionHistory->avg('years_worked');
                        @endphp
                        <small class="text-muted">
                            Всего должностей: {{ $totalPositions }} | 
                            Текущих: {{ $currentPositions }} | 
                            Прошлых: {{ $pastPositions }} |
                        </small>
                    </div>

                    <!-- График стажа -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Статистика по должностям</h6>
                                    @foreach($positionHistory as $position)
                                    <div class="mb-2">
                                        <small>{{ $position->position_name }}</small>
                                        <div class="progress" style="height: 20px;">
                                            @php
                                                $percentage = min(100, ($position->years_worked / 20) * 100);
                                            @endphp
                                            <div class="progress-bar 
                                                @if($position->end_date) bg-warning @else bg-success @endif" 
                                                role="progressbar" 
                                                style="width: {{ $percentage }}%" 
                                                aria-valuenow="{{ $percentage }}" 
                                                aria-valuemin="0" 
                                                aria-valuemax="100">
                                                {{ $position->years_worked }} лет
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Дополнительная кнопка внизу -->
                    <div class="mt-4 text-center">
                        <a href="{{ route('employees.select-employee') }}" class="btn btn-primary btn-lg">
                            Выбрать другого сотрудника
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