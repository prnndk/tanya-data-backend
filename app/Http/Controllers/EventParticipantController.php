<?php

namespace App\Http\Controllers;

use App\Enums\EventType;
use App\Http\Requests\StoreCoachingRequest;
use App\Http\Requests\StoreEventParticipantRequest;
use App\Http\Requests\StoreOpenClassRequest;
use App\Http\Requests\UpdateEventParticipantRequest;
use App\Http\Resources\EventParticipantResource;
use App\Http\Resources\PaymentResource;
use App\Models\Coaching;
use App\Models\EventParticipant;
use App\Models\OpenClass;
use App\Models\PackageData;
use App\Models\Payment;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class EventParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = EventParticipant::where('user_id', auth()->id())->get();

        return $this->successResponse($data, 'Event Participants fetched successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function buySeminar(StoreEventParticipantRequest $request): JsonResponse
    {
        try {

            $validated = $request->validated();

            $this->checkForEvent($validated['event_id'], EventType::TALKS);

            $validateNotDouble = EventParticipant::where('user_id', auth()->id())->where('event_id', $validated['event_id'])->first();
            if ($validateNotDouble) {
                return $this->errorResponse('Already registered for this event', 400);
            }

            DB::beginTransaction();
            try {
                $imageName = $this->handlePaymentsImage($validated['payment_proof']);
                $payment = Payment::create(['sender_name' => $validated['sender_name'], 'sender_bank' => $validated['sender_bank'], 'payment_bank_id' => $validated['payment_bank_id'], 'nominal' => $validated['nominal'], 'payment_proof' => $imageName]);
                $data = EventParticipant::create([
                    'user_id' => auth()->id(),
                    'event_id' => $validated['event_id'],
                    'information_source' => $validated['information_source'],
                    'payment_id' => $payment->id
                ]);

            } catch (Exception $e) {
                DB::rollBack();
                return $this->errorResponse($e->getMessage(), $e->getCode() ?? 500);
            }
            DB::commit();
            $returnData = ['event_participant' => new EventParticipantResource($data), 'payment' => new PaymentResource($payment)];
            return $this->successResponse($returnData, 'Successfully Registered To Seminar', 201);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode() ?? 500);
        }
    }

    public function buyCoachingClass(StoreCoachingRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $this->checkForEvent($validated['event_id'], EventType::COACHING);

            $validateNotDouble = EventParticipant::where('user_id', auth()->id())->where('event_id', $validated['event_id'])->first();
            if ($validateNotDouble) {
                return $this->errorResponse('Already registered for this event', 400);
            }

            $packageData = PackageData::where('id', $validated['package_id'])->firstOrFail();

            if ($packageData->price < $validated['nominal']) {
                return $this->errorResponse('Invalid Nominal', 400);
            }

            DB::beginTransaction();
            try {
                $imageName = $this->handlePaymentsImage($validated['payment_proof']);
                $payment = Payment::create(['sender_name' => $validated['sender_name'], 'sender_bank' => $validated['sender_bank'], 'payment_bank_id' => $validated['payment_bank_id'], 'nominal' => $validated['nominal'], 'payment_proof' => $imageName]);
                $eventParticipant = EventParticipant::create(['user_id' => auth()->id(), 'event_id' => $validated['event_id'], 'information_source' => $validated['information_source'], 'payment_id' => $payment->id]);
                $coaching = Coaching::create(['registrant_id' => $eventParticipant->id, 'competition_name' => $validated['competition_name'], 'deadline_date' => $validated['deadline'], 'idea' => $validated['idea'], 'progress' => $validated['progress'], 'request' => $validated['request'], 'file' => $validated['file'], 'package_id' => $validated['package_id']]);

            } catch (Exception $e) {
                DB::rollBack();
                return $this->errorResponse($e->getMessage(), $e->getCode() ?? 500);
            }
            DB::commit();
            $returnData = ['event_participant' => new EventParticipantResource($eventParticipant), 'payment' => new PaymentResource($payment), 'coaching' => $coaching,];
            return $this->successResponse($returnData, 'Successfully Registered To Coaching Class', 201);

        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode() ?? 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function buyOpenClass(StoreOpenClassRequest $request)
    {
        try {
            $validated = $request->validated();

            $this->checkForEvent($validated['event_id'], EventType::OPENCLASS);

            $validateNotDouble = EventParticipant::where('user_id', auth()->id())->where('event_id', $validated['event_id'])->first();
            if ($validateNotDouble) {
                return $this->errorResponse('Already registered for this event', 400);
            }

            $packageData = PackageData::where('id', $validated['package_id'])->firstOrFail();
            if ($validated['nominal'] < $packageData->price) {
                return $this->errorResponse('Invalid Nominal', 400);
            }

            DB::beginTransaction();
            try {
                $imageName = $this->handlePaymentsImage($validated['payment_proof']);

                $payment = Payment::create(['sender_name' => $validated['sender_name'], 'sender_bank' => $validated['sender_bank'], 'payment_bank_id' => $validated['payment_bank_id'], 'nominal' => $validated['nominal'], 'payment_proof' => $imageName]);
                $eventParticipant = EventParticipant::create(['user_id' => auth()->id(), 'event_id' => $validated['event_id'], 'information_source' => $validated['information_source'], 'payment_id' => $payment->id]);
                $openClass = OpenClass::create(['registrant_id' => $eventParticipant->id, 'package_id' => $validated['package_id']]);
            } catch (Exception $e) {
                DB::rollBack();
                return $this->errorResponse($e->getMessage(), $e->getCode()??500);
            }
            DB::commit();
            $returnData = ['event_participant' => new EventParticipantResource($eventParticipant), 'payment' => new PaymentResource($payment), 'open_class' => $openClass,];
            return $this->successResponse($returnData, 'Successfully Registered To Open Class', 201);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode() ?? 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(EventParticipant $eventParticipant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventParticipantRequest $request, EventParticipant $eventParticipant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventParticipant $eventParticipant)
    {
        //
    }
}
