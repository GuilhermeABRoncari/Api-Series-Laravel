<?php 

namespace App\Repositories;

use App\Models\Season;
use App\Models\Series;
use App\Models\Episode;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SeriesRequest;
use App\Repositories\SeriesRepository;

class EloquentSeriesRepository implements SeriesRepository
{
    public function add(SeriesRequest $request): Series
    {
        return DB::transaction(function () use ($request, &$series) {
            $series = Series::create([
                'name'=> $request->name,
            ]);
            $seasons = [];
            for ($i = 1; $i <= $request->seasonsQty; $i++) {
                $seasons[] = [
                    'series_id' => $series->id,
                    'number' => $i
                ];
            }
            $season = Season::insert($seasons);
    
            $episodes = [];
            foreach ($series->seasons as $season) {
                for ($j = 1; $j <= $request->episodesPerSeason; $j++) {
                    $episodes[] = [
                        'season_id' => $season->id,
                        'number' => $j
                    ];
                }
            }
            Episode::insert($episodes);

            return $series;
        });
    }
}