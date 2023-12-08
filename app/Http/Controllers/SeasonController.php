<?php

namespace App\Http\Controllers;

use App\Models\Season;
use Illuminate\Http\Request;

class SeasonController extends Controller
{
    public function index(int $seriesId)
    { 
        $seasonModel = Season::where('series_id', $seriesId)->with('episodes')->get();

        if ($seasonModel->isEmpty()) return response()->json(['message'=> "Season not found for Series id = {$seriesId}"], 404);
        
        return $seasonModel;
    }
}
