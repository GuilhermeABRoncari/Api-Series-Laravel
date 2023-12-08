<?php

namespace App\Http\Controllers;

use App\Http\Requests\EpisodeWatchedRequest;
use App\Models\Series;
use App\Models\Episode;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{
    public function EpisodesBySeries(Series $series)
    {
        return $series->episodes;
    }

    public function update(int $episodeId, EpisodeWatchedRequest $request)
    {
        $episode = Episode::find($episodeId);

        if (!$episode) return response()->json(["message"=> "Episode not found for id = {$episodeId}"], 404);

        $episode->watched = $request->watched;
        $episode->save();
        return $episode; 
    }
}
