<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Login extends JsonResource
{
    public function toArray($request)
    {
        return [
            'token' => $this->createToken('token')->plainTextToken
        ];
    }
}
