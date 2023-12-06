<?php

namespace App\Providers;

use App\Repositories\SeriesRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\EloquentSeriesRepository;

class RepositoriesProvider extends ServiceProvider
{
    public array $bindings = [
        SeriesRepository::class => EloquentSeriesRepository::class,
    ];
}
