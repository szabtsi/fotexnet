<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Movie;
use Illuminate\Support\Facades\Gate;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->success(Movie::paginate(15));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovieRequest $request)
    {
        $movie = Movie::create($request->safe()->except('image'));

        return $this->success($movie);
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {
        return $this->success($movie);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Movie $movie, UpdateMovieRequest $request)
    {
        $movie->update($request->safe()->except('image'));

        return $this->success($movie);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        Gate::authorize('delete', $movie);

        $movie->delete();

        return $this->success();
    }
}
