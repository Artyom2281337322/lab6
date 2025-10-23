<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @extends('layouts.app')

@section('title', 'Последний уволенный сотрудник')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">Последний уволенный сотрудник</h1>
            </div>

            @if($lastDismissed)
            <!-- Основная информация -->
            <div class="card mb-4">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-title mb-0">Информация о последнем уволенном сотруднике</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h2 class="text-primary">{{ $fullNameFormatted }}</h2>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <p><strong>Пол:</strong> 
                                        <span class="badge bg-info">
                                            {{ $lastDismissed->gender == 'М' ? 'Мужской' : 'Женский' }}
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Дата увольнения:</strong> 
                                        <span class="badge bg-danger">
                                            {{ \Carbon\Carbon::parse($lastDismissed->dismissal_date)->format('d.m.Y') }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title">Статистика</h5>
                                    <div class="display-4 text-primary">{{ $experience['years'] }}</div>
                                    <p class="card-text">лет общего стажа</p>
                                    <div class="display-6 text-warning">{{ $lastDismissed->age_at_dismissal }}</div>
                                    <p class="card-text">лет на момент увольнения</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Дополнительная информация, если есть -->
            @if(isset($lastDismissed->city_name) || isset($lastDismissed->department_name))
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Дополнительная информация</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if(isset($lastDismissed->city_name))
                        <div class="col-md-6">
                            <p><strong>Родной город:</strong> 
                                <span class="badge bg-primary">🏙️ {{ $lastDismissed->city_name }}</span>
                            </p>
                        </div>
                        @endif
                        @if(isset($lastDismissed->department_name))
                        <div class="col-md-6">
                            <p><strong>Отдел:</strong> 
                                <span class="badge bg-info">🏢 {{ $lastDismissed->department_name }}</span>
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- История должностей, если есть -->
            @if(isset($positionHistory) && $positionHistory->count() > 0)
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
                                    <th>Начало работы</th>
                                    <th>Окончание</th>
                                    <th>Продолжительность</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($positionHistory as $index => $position)
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
                                        @php
                                            $days = $position->days_worked;
                                            $years = floor($days / 365);
                                            $months = floor(($days % 365) / 30);
                                        @endphp
                                        <span class="badge bg-info">
                                            {{ $years }}л. {{ $months }}мес.
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            @else
            <!-- Если нет уволенных сотрудников -->
            <div class="card">
                <div class="card-body text-center py-5">
                    <div class="display-1 text-success mb-3">🎉</div>
                    <h3 class="text-success">Отличные новости!</h3>
                    <p class="text-muted">В компании нет уволенных сотрудников.</p>
                    <a href="{{ route('employees.index') }}" class="btn btn-primary btn-lg mt-3">
                        👥 Перейти к списку сотрудников
                    </a>
                </div>
            </div>
            @endif

            <!-- Дополнительная кнопка внизу -->
            <div class="mt-4 text-center">
                <a href="{{ route('employees.dismissed') }}" class="btn btn-warning btn-lg">
                    Посмотреть всех уволенных
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
</body>
</html>