<?php

namespace App\Http\Controllers;

use App\Enums\EventType;
use App\Http\Requests\StoreEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            $search = $request->query('search');
            $active = $request->query('is_active');
            $limit = $request->query('limit') ?? 10;
            $page = $request->query('page') ?? 1;

            $events = Event::when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%$search%");
            })->when($active, function ($query) use ($active) {
                return $query->where('is_active', $active);
            })->paginate($limit, ['*'], 'page', $page)->withQueryString();

            return $this->successResponse($events, 'Events fetched successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        try {
            $validated = $request->validated();

            $event = Event::create($validated);
            return $this->successResponse(new EventResource($event), 'Successfully Create Event', 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return $this->successResponse($event, 'Event fetched successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'string|max:255|unique:events,name,' . $event->id,
            'event_type' => ['string|max:255', Rule::enum(EventType::class)],
            'start_regist_time' => 'date',
            'end_regist_time' => 'date|after:start_regist_time',
        ]);

        $event->update($validated);

        return $this->successResponse($event, 'Successfully Update Event', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return $this->successWithoutData('Successfully Delete Event', 200);
    }
}
