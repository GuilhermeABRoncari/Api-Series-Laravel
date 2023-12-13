<?php

namespace App\Http\Controllers;

use App\Exceptions\DomainExceptions\EntityNotFoundException;
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

        throw_if (!$episode, new EntityNotFoundException($episodeId));

        $episode->watched = $request->watched;
        $episode->save();
        return $episode; 
    }
}
