<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @extends('layouts.app')

@section('title', 'Средний возраст уволенных сотрудников')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">Средний возраст уволенных сотрудников</h1>
            </div>

            <!-- Основная статистика -->
            @if($averageAgeData && $averageAgeData->total_dismissed > 0)
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-white bg-primary">
                        <div class="card-body text-center">
                            <h5 class="card-title">Средний возраст</h5>
                            <p class="card-text display-4">{{ round($averageAgeData->average_age) }}</p>
                            <p class="card-text">лет</p>
                        </div>
                    </div>
                </div>
            </div>

            @if(isset($ageGroups) && $ageGroups->count())
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Распределение по возрастным группам</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($ageGroups as $group)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $group->age_group }}</h6>
                                    <p class="card-text display-6">{{ $group->count }} сотрудников</p>
                                    @php
                                        $percentage = round(($group->count / $averageAgeData->total_dismissed) * 100, 1);
                                    @endphp
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" 
                                             style="width: {{ $percentage }}%" 
                                             aria-valuenow="{{ $percentage }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100">
                                            {{ $percentage }}%
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            @endif
            
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Уволенные сотрудники с возрастом</h5>
                </div>
                <div class="card-body">
                    @if($dismissedEmployees && $dismissedEmployees->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Фамилия</th>
                                    <th>Имя</th>
                                    <th>Отчество</th>
                                    <th>Дата рождения</th>
                                    <th>Дата увольнения</th>
                                    <th>Возраст при увольнении</th>
                                    <th>Причина увольнения</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dismissedEmployees as $index => $employee)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $employee->last_name }}</td>
                                    <td>{{ $employee->first_name }}</td>
                                    <td>{{ $employee->middle_name ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ \Carbon\Carbon::parse($employee->birth_date)->format('d.m.Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning text-dark">
                                            {{ \Carbon\Carbon::parse($employee->dismissal_date)->format('d.m.Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $age = $employee->age_at_dismissal;
                                            $ageClass = $age < 30 ? 'bg-success' : 
                                                       ($age < 40 ? 'bg-info' : 
                                                       ($age < 50 ? 'bg-warning' : 'bg-danger'));
                                        @endphp
                                        <span class="badge {{ $ageClass }}">
                                            {{ $age }} лет
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            {{ $employee->dismissal_reason }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-3">
                        <small class="text-muted">
                            Показано {{ $dismissedEmployees->count() }} уволенных сотрудников
                        </small>
                    </div>
                    @else
                    <div class="text-center text-muted py-4">
                        <h4>Нет данных об уволенных сотрудниках</h4>
                        <p>В базе данных отсутствует информация об уволенных сотрудниках</p>
                    </div>
                    @endif

                    <!-- Дополнительная кнопка внизу -->
                    <div class="mt-4 text-center">
                        <a href="{{ route('employees.dismissed') }}" class="btn btn-warning btn-lg">
                            Подробнее об уволенных
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