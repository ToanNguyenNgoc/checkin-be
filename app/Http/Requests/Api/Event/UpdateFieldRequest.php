<?php

namespace App\Http\Requests\Api\Event;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class UpdateFieldRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'event_id'         => ['required', 'numeric', Rule::exists('events', 'id')],
            // 'main_fields'   => ['required', 'array'],
            // 'custom_fields' => ['required', 'array'],
        ];
    }
}
