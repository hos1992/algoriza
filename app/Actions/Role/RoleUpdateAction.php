<?php

namespace App\Actions\Role;

use App\Actions\Action;

class RoleUpdateAction extends Action
{
    private $model;
    private $data;

    public function __construct($model, $data)
    {
        $this->model = $model;
        $this->data = $data;
    }

    public function __invoke()
    {
        $this->model->update(['name' => $this->data['name']]);
        $this->model->syncPermissions($this->data['permissions']);
        return $this->model;
    }
}
