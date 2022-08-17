<?php

namespace App\Actions\Category;

use App\Actions\Action;
use App\Models\Admin;

class CategoryStoreAction extends Action
{

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function __invoke()
    {
        if (isset($this->data['roles']) && !empty($this->data['roles'])) {
            $roles = $this->data['roles'];
        }
        unset($this->data['roles']);
        $admin = Admin::create($this->data);
        if (isset($roles)) {
            $admin->syncRoles($roles);
        }

        return $admin;
    }
}
