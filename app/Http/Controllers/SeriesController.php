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

    public function index()
    {
        return Series::all();
    }

    public function store(SeriesRequest $request)
    {
        return response()->json($this->repository->add($request), 201);
    }

    public function upload(Request $request)
    {
        $coverPath = null;

        if ($request->hasFile('cover')) {
        $coverPath = $request->file('cover')->store('series_cover', 'public');
        } else {
        return response()->json(['error' => 'Nenhum arquivo foi enviado.'], 400);
        }

        $request->merge(['coverPath' => $coverPath]);

        return response()->json(['file_path' => $coverPath]);
    }

    public function show(int $seriesId)
    {
        return Series::find($seriesId);
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
