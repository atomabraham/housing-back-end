<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'picture' => $this->picture,
            'name' => $this->name,
            'userName' => $this->userName,
            'secondname' => $this->secondname,
            'phone' => $this->phone,
            'birthday' => $this->birthday,
            'country' => $this->country,
            'city' => $this->city,
            'postalcode' => $this->postalcode,
            'email' => $this->email,
            'role' => $this->role,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
