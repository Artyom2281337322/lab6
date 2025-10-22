<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @extends('layouts.app')

@section('title', 'Статистика увольнений')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">Статистика увольнений по годам</h1>
            </div>

            <div class="alert alert-info">
                <h5 class="alert-heading">Статистика увольнений</h5>
                <p class="mb-0">Количество уволенных сотрудников по годам. Сортировка по убыванию года.</p>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Увольнения по годам</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Год увольнения</th>
                                    <th>Количество уволенных</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalDismissed = $dismissalStats->sum('employees_count');
                                @endphp
                                @forelse($dismissalStats as $index => $stat)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $stat->dismissal_year }} год</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger">{{ $stat->employees_count }} сотрудников</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        Нет данных об увольнениях
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($dismissalStats->count())
                    <div class="mt-3">
                        @php
                            $totalDismissed = $dismissalStats->sum('employees_count');
                            $yearsCount = $dismissalStats->count();
                            $averagePerYear = $yearsCount > 0 ? round($totalDismissed / $yearsCount, 1) : 0;
                            $maxYear = $dismissalStats->max('employees_count');
                            $minYear = $dismissalStats->min('employees_count');
                        @endphp
                       
                    </div>

                    
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Распределение по годам</h6>
                                    @foreach($dismissalStats->take(5) as $stat)
                                    <p class="mb-1">
                                        {{ $stat->dismissal_year }}: 
                                        <strong>{{ $stat->employees_count }}</strong> уволенных
                                    </p>
                                    @endforeach
                                    @if($dismissalStats->count() > 5)
                                    <p class="mb-0 text-muted">... и еще {{ $dismissalStats->count() - 5 }} лет</p>
                                    @endif
                                </div>
                            </div>
                        </div>
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