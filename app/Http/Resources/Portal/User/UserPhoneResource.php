<?php

namespace App\Http\Resources\Portal\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserPhoneResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'phone_country_id' => ['value' => $this->phone_country_id, 'type' => 'select'],
            'phone' => ['value' => $this->phone, 'type' => 'number'],
            'route' => route('portal.phone.update'),
        ];
    }
}
