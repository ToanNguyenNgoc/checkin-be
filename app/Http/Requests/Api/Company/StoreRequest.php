<?php

namespace App\Http\Requests\Api\Company;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $ruleMores = [];
        $rules = [
            'id'                => ['nullable', 'numeric'],
            'parent_id'         => ['nullable', 'numeric', $this->tableHasId('companys')],
            'is_default'        => ['nullable', 'boolean'],
            'name'              => ['required', 'string', 'max:255'],
            'contact_email'     => ['nullable', 'string', 'max:255'],
            'contact_phone'     => ['nullable', 'string', 'max:255'],
            'website'           => ['nullable', 'string', 'max:255'],
            'address'           => ['nullable', 'string', 'max:255'],
            'city'              => ['nullable', 'string', 'max:255'],
            'limited_users'     => ['nullable', 'numeric', 'min:1'],
            'limited_events'    => ['nullable', 'numeric', 'min:1'],
            'limited_campaigns' => ['nullable', 'numeric', 'min:1'],
        ];

        if (empty($this->id)) {
            $ruleMores = [
                'code'          => ['required', 'string', 'max:200', Rule::unique('companys')->ignore($this->id)],
                // 'code'          => ['required', 'string', 'max:200', 'unique:companys,code'],
            ];
        }

        return array_merge($rules, $ruleMores);
    }
}
