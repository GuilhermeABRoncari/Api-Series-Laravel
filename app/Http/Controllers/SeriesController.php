<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;
use App\Http\Requests\SeriesRequest;
use App\Repositories\SeriesRepository;

class SeriesController extends Controller
{
    private SeriesRepository $repository;

    public function __construct(SeriesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $query = Series::query();
        if ($request->has('name')) $query->where('name', $request->name);

        return $query->paginate(3);
    }

    public function store(SeriesRequest $request)
    {
        return response()->json($this->repository->add($request), 201);
    }

    public function show(int $seriesId)
    {
        $seriesModel = Series::with('seasons.episodes')->find($seriesId);

        if (!$seriesModel) return response()->json(['message'=> 'Series not found.'],404);

        return $seriesModel;;
    }

    public function update(SeriesRequest $request, int $seriesId)
    {
        Series::where('id', $seriesId)->update($request->all());
        return response()->noContent();
    }

    public function destroy(int $seriesId)
    {
        Series::destroy($seriesId);
        return response()->noContent();
    }
}
