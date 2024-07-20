<?php

namespace App\Http\Controllers;

use App\Http\Resources\PackageDataCollection;
use App\Http\Resources\PackageDataResource;
use App\Models\PackageData;
use App\Http\Requests\StorePackageDataRequest;
use App\Http\Requests\UpdatePackageDataRequest;
use Illuminate\Http\JsonResponse;

class PackageDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try{
        $eventId = request()->query('event_id');

        $packageData = PackageData::when($eventId, function ($query) use ($eventId) {
            return $query->where('event_id', $eventId);
        })->get();

        return $this->successResponse(PackageDataResource::collection($packageData), 'Package Data fetched successfully', 200);

        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePackageDataRequest $request): JsonResponse
    {
        try{
        $validated = $request->validated();

        $alreadyCreated = PackageData::where('name', $validated['name'])->where('event_id', $validated['event_id'])->first();
        if($alreadyCreated){
            throw new \Exception('Package Data with same name already created for this event', 409);
        }

        $packageData = PackageData::create($validated);


        return $this->successResponse(new PackageDataResource($packageData), 'Package Data created successfully', 201);
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PackageData $packageData)
    {
        return $this->successResponse($packageData, 'Package Data fetched successfully', 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PackageData $packageData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePackageDataRequest $request, PackageData $packageData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PackageData $packageData)
    {
        //
    }
}
