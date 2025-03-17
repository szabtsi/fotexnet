<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreScreeningRequest;
use App\Http\Requests\UpdateScreeningRequest;
use App\Models\Screening;
use Illuminate\Support\Facades\Gate;

class ScreeningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->success(Screening::paginate(15));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScreeningRequest $request)
    {
        $screening = Screening::create($request->validated());

        return $this->success($screening);
    }

    /**
     * Display the specified resource.
     */
    public function show(Screening $screening)
    {
        return $this->success($screening);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateScreeningRequest $request, Screening $screening)
    {
        $screening->update($request->validated());

        return $this->success($screening);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Screening $screening)
    {
        Gate::authorize('delete', $screening);

        $screening->delete();

        return $this->success();
    }
}
