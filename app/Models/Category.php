<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Category extends Model
{
    use HasFactory, HasRecursiveRelationships;

    protected $guarded = [];

    protected $appends = ['toggle-active-state-url'];


    public function getActionsUrlsAttribute()
    {
        return [
            'index' => route('categories.index'),
            'edit' => route('categories.edit', $this->id),
            'delete' => route('categories.destroy', $this->id),
        ];
    }


    public function getToggleActiveStateUrlAttribute()
    {
        return route('categories.toggle-active-state', $this->id);
    }
}
