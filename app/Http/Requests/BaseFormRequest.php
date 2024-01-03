<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use App\Traits\ApiResponser;

class BaseFormRequest extends FormRequest
{
    use ApiResponser;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        if($this->expectsJson()){
            $msgErrors = (new ValidationException($validator))->errors();

            throw new HttpResponseException(
                $this->responseError($msgErrors, 422),
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        parent::failedValidation($validator);
    }
}
