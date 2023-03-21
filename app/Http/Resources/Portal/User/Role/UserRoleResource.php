<?php

namespace App\Http\Resources\Portal\User\Role;

use Illuminate\Http\Resources\Json\JsonResource;

class UserRoleResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'title' => ['value'=>$this->title, 'type'=>'text'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'access_scopes' => ['value'=>$this->access_scopes, 'type'=>'checkbox'],
            'route' => route('portal.user-role.update', $this->id),
        ];
    }
}
