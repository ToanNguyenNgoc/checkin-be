<?php

namespace App\Http\Requests\Api\Event;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class AssignCompanyRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id'            => ['required', 'numeric', Rule::exists('events', 'id')],
            'company_id'    => ['required', 'numeric', Rule::exists('companys', 'id')],
        ];
    }
}
