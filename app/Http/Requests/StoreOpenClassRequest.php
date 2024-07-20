<?php

namespace App\Http\Requests;

use App\Enums\InformationSourceType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOpenClassRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'event_id' => 'required|exists:events,id',
            'information_source' => ['required', 'string', 'max:255', Rule::enum(InformationSourceType::class)],
            'package_id' => 'required|exists:package_data,id',
            'sender_name' => 'required|string|max:255',
            'sender_bank' => 'required|string|max:255',
            'payment_bank_id' => 'required|exists:payment_banks,id',
            'nominal' => 'required|integer',
            'payment_proof'=>'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
