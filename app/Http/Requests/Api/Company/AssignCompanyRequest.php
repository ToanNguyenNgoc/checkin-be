<?php

namespace App\Http\Requests\Api\Company;

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
            'id'            => ['required', 'numeric', Rule::exists('companys', 'id')],
            'company_id'    => ['nullable', 'numeric', Rule::exists('companys', 'id')],
        ];
    }
}
