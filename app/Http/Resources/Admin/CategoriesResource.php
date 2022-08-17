<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this['name'],
            'is_active' => $this['is_active'],
            'toggle-active-state-url' => $this['toggle-active-state-url'],
            'actions_urls' => $this->actions_urls,
        ];
    }
}
