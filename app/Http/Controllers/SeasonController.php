<?php

namespace App\Http\Controllers;

use App\Exceptions\DomainExceptions\EntityNotFoundException;
use App\Models\Season;
use Illuminate\Http\Request;

class SeasonController extends Controller
{
    public function index(int $seriesId)
    { 
        $seasonModel = Season::where('series_id', $seriesId)->with('episodes')->get();

        throw_if ($seasonModel->isEmpty(), new EntityNotFoundException($seriesId));
        
        return $seasonModel;
    }
}
