<?php

namespace App\Http\Resources\Portal\User\Role;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRoleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'title' => ['value'=>$this->title, 'type'=>'text'],
            'access_scopes' => ['value'=>$this->access_scopes, 'type'=>'checkbox'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'route' => route('portal.user-role.update', $this->id),
        ];
    }
}
