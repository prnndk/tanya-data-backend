<?php

namespace App\Http\Controllers;

use App\Enums\EventType;
use App\Models\Event;
use Illuminate\Support\Str;

abstract class Controller
{
    public function successWithoutData($message,$code): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success'=>true,
            'message' => $message,
        ],$code);
    }
    public function successResponse($data,$message,$code): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success'=>true,
            'message' => $message,
            'data' => $data,
        ],$code);
    }
//    error handler
    public function errorResponse($message,$code): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success'=>false,
            'message' => $message,
        ],$code);
    }

    public function handlePaymentsImage($file): string
    {
        $imageName = time() . Str::random(15) . '.' . $file->extension();
        $file->move(public_path('payments'), $imageName);
        return 'payments/'.$imageName;
    }

    /**
     * @throws \Exception
     */
    public function checkForEvent(string $eventId, EventType $eventType ): bool
    {
        $checkIsEventTypeTrue = Event::where('id', $eventId)->where('event_type', $eventType)->first();
        if (!$checkIsEventTypeTrue) {
            throw new \Exception('Event Type is Mismatch', 422);
        }
        if ($checkIsEventTypeTrue->start_regist_time > now()) {
            throw new \Exception('Event registration time has not started yet', 400);
        }elseif ($checkIsEventTypeTrue->end_regist_time < now()) {
            throw new \Exception('Event registration time has ended', 400);
        }elseif (!$checkIsEventTypeTrue->is_active) {
            throw new \Exception('Event is not active', 400);
        }
        return true;
    }


}
