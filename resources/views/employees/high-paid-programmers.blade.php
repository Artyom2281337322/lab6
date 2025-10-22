<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @extends('layouts.app')

@section('title', 'Высокооплачиваемые программисты')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">Высокооплачиваемые программисты</h1>
            </div>

            <div class="alert alert-info">
                <h5 class="alert-heading">Критерии отбора</h5>
                <p class="mb-0">
                    • Должность: программист/разработчик<br>
                    • Оклад: более 100 000 руб.<br>
                    • Фамилия: начинается на букву "П"
                </p>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Программисты с высоким окладом</h5>
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
                                    <th>Оклад</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($programmers as $index => $programmer)
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
                                        <span class="badge bg-success">
                                            {{ number_format($programmer->salary, 0, '', ' ') }} руб.
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        Нет программистов, соответствующих критериям
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($programmers->count())
                    <div class="mt-3">
                        @php
                            $totalSalary = $programmers->sum('salary');
                            $averageSalary = $programmers->avg('salary');
                            $maxSalary = $programmers->max('salary');
                        @endphp
                    </div>
                    @endif

                    <!-- Дополнительная кнопка внизу -->
                    <div class="mt-4 text-center">
                        <a href="{{ route('employees.salaries') }}" class="btn btn-success btn-lg">
                             Посмотреть все оклады
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