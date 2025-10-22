<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @extends('layouts.app')

@section('title', 'Московские программисты')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">Московские программисты</h1>
            </div>

            <div class="alert alert-info">
                <h5 class="alert-heading">Критерии отбора</h5>
                <p class="mb-0">
                    • Город: Москва<br>
                    • Должность: программист/разработчик<br>
                    • Стаж на должности: 10+ лет
                </p>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Программисты из Москвы со стажем 10+ лет</h5>
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
                                    <th>Город</th>
                                    <th>Начало работы</th>
                                    <th>Окончание</th>
                                    <th>Стаж (лет)</th>
                                    <th>Статус</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($moscowProgrammers as $index => $programmer)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $programmer->last_name }}</strong>
                                    </td>
                                    <td>{{ $programmer->first_name }}</td>
                                    <td>{{ $programmer->middle_name ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $programmer->position_name }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $programmer->city_name }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ \Carbon\Carbon::parse($programmer->start_date)->format('d.m.Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($programmer->end_date)
                                            <span class="badge bg-warning text-dark">
                                                {{ \Carbon\Carbon::parse($programmer->end_date)->format('d.m.Y') }}
                                            </span>
                                        @else
                                            <span class="badge bg-success">по настоящее время</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-success">
                                            {{ $programmer->years_worked }} лет
                                        </span>
                                    </td>
                                    <td>
                                        @if($programmer->end_date)
                                            <span class="badge bg-secondary">Уволен</span>
                                        @else
                                            <span class="badge bg-success">Работает</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted">
                                        Нет программистов из Москвы со стажем 10+ лет
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                   
                    <div class="mt-3">
                        @php
                            $totalProgrammers = count($moscowProgrammers);
                            $averageExperience = collect($moscowProgrammers)->avg('years_worked');
                            $maxExperience = collect($moscowProgrammers)->max('years_worked');
                            $currentEmployees = collect($moscowProgrammers)->where('end_date', null)->count();
                        @endphp
                    </div>
                    
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