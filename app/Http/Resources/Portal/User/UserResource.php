<?php

namespace App\Http\Resources\Portal\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'first_name' => ['value'=>$this->first_name, 'type'=>'text'],
            'last_name' => ['value'=>$this->last_name, 'type'=>'text'],
            'username' => ['value'=>$this->username, 'type'=>'text'],
            'email' => ['value'=>$this->email, 'type'=>'text'],
            'phone_country_id' => ['value'=>$this->phone_country_id, 'type'=>'select'],
            'phone' => ['value'=>$this->phone, 'type'=>'text'],
            'user_role_id' => ['value'=>$this->user_role_id, 'type'=>'select'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'route' => route('portal.user.update', $this->id),
        ];
    }
}
