<?php

namespace App\Http\Controllers;

use App\Models\EventAnnouncement;
use App\Http\Requests\StoreEventAnnouncementRequest;
use App\Http\Requests\UpdateEventAnnouncementRequest;
use Illuminate\Http\JsonResponse;

class EventAnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventAnnouncementRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(EventAnnouncement $eventAnnouncement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventAnnouncement $eventAnnouncement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventAnnouncementRequest $request, EventAnnouncement $eventAnnouncement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventAnnouncement $eventAnnouncement)
    {
        //
    }
}
