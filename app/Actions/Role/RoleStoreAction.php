<?php

namespace App\Actions\Role;

use App\Actions\Action;
use App\Models\Role;

class RoleStoreAction extends Action
{
    private $guard;
    private $data;

    public function __construct($data, $guard = 'admin')
    {
        $this->data = $data;
    }


    public function __invoke()
    {
        $role = Role::create([
            'name' => $this->data['name'],
            'guard_name' => $this->guard,
        ]);

        $role->syncPermissions($this->data['permissions']);

        return $role;
    }
}
