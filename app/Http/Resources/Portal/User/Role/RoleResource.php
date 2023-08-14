<?php

namespace App\Http\Resources\Portal\User\Role;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'title' => ['value'=>$this->title, 'type'=>'text'],
            'routes' => ['value'=>$this->routes, 'type'=>'checkbox'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'route' => route('portal.user-role.update', $this->id),
        ];
    }
}
