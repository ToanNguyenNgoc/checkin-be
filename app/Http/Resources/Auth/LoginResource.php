<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class LoginResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->attrOnly = [
            'id'            => $this->id,
            'username'      => $this->username,
            'name'          => $this->name,
            'email'         => $this->email,
            'type'          => $this->type,
            'gate'          => $this->gate,
            'access_token'  => $this->createToken($this->username)->plainTextToken,
            'token_type'    => 'Bearer'
        ];

        return $this->finalizeResult($request);
    }
}
