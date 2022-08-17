<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $guarded = [];

    protected $appends = ['actions_urls'];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function getActionsUrlsAttribute()
    {
        return [
            'index' => route('admins.index'),
            'edit' => route('admins.edit', $this->id),
            'delete' => route('admins.destroy', $this->id),
        ];
    }

    public function setPasswordAttribute($value)
    {
        if ($value != "") {
            $this->attributes['password'] = bcrypt($value);
        }
    }
}
