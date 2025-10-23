<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @extends('layouts.app')

@section('title', 'Города с большим количеством сотрудников')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">Города с большим количеством сотрудников</h1>
            </div>

            <div class="alert alert-info">
                <h5 class="alert-heading">Критерии отбора</h5>
                <p class="mb-0">
                    • Количество сотрудников в городе: больше 4<br>
                    • Сортировка: по убыванию количества сотрудников
                </p>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Города с 5+ сотрудниками</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Город</th>
                                    <th>Количество сотрудников</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalEmployees = $citiesWithEmployees->sum('employees_count');
                                    $maxEmployees = $citiesWithEmployees->max('employees_count');
                                @endphp
                                @forelse($citiesWithEmployees as $index => $city)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $city->city_name ?? $city->name }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">
                                            {{ $city->employees_count }} сотрудников
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        Нет городов с количеством сотрудников больше 4
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
            
                    <div class="mt-3">
                        @php
                            $totalCities = $citiesWithEmployees->count();
                            $totalEmployees = $citiesWithEmployees->sum('employees_count');
                            $averagePerCity = $totalCities > 0 ? round($totalEmployees / $totalCities, 1) : 0;
                            $maxEmployees = $citiesWithEmployees->max('employees_count');
                            $minEmployees = $citiesWithEmployees->min('employees_count');
                        @endphp
                    </div>

                   

                  
                    <div class="mt-4 text-center">
                        <a href="{{ route('employees.cities') }}" class="btn btn-info btn-lg">
                            Посмотреть все города
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