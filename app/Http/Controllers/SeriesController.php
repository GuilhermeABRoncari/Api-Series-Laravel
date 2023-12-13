<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;
use App\Enums\HttpStatusCode;
use App\Http\Requests\SeriesRequest;
use App\Repositories\SeriesRepository;
use App\Http\Requests\SeriesUpdateRequest;
use App\Exceptions\DomainExceptions\EntityNotFoundException;

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

        return $query->paginate(5);
    }

    public function store(SeriesRequest $request)
    {
        return response()->json($this->repository->add($request), 201);
    }

    public function show(int $seriesId)
    {
        $seriesModel = Series::with('seasons.episodes')->find($seriesId);

        throw_if (!$seriesModel, new EntityNotFoundException($seriesId));

        return $seriesModel;
    }

    public function update(SeriesUpdateRequest $request, int $seriesId)
    {
        throw_if (!Series::find($seriesId), new EntityNotFoundException($seriesId));
        Series::where('id', $seriesId)->update($request->all());
        return response()->noContent();
    }

    public function destroy(int $seriesId)
    {
        Series::destroy($seriesId);
        return response()->noContent();
    }
}
