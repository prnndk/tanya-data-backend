<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentBankResource;
use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\PaymentBank;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getReceiverBank(): JsonResponse
    {
        $data = PaymentBank::where('is_active', true)->get();

        return $this->successResponse(PaymentBankResource::collection($data), 'Receiver Bank fetched successfully', 200);

    }

    public function storeReceiverBank(Request $request): JsonResponse
    {
            $validated = $request->validate([
                'bank_name' => 'required|string',
                'bank_number' => 'required|numeric|unique:payment_banks,bank_number',
                'owner_name' => 'required|string',
            ]);

            $validated['is_active'] = true;

            $paymentBank = PaymentBank::create($validated);

            return $this->successResponse(new PaymentBankResource($paymentBank), 'Receiver Bank created successfully', 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
