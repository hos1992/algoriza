<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory;

    protected $appends = ['actions_urls'];

    public function getActionsUrlsAttribute()
    {
        return [
            'index' => route('roles.index'),
            'edit' => route('roles.edit', $this->id),
            'delete' => route('roles.destroy', $this->id),
        ];
    }

}
