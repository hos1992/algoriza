<?php

namespace App\Actions\Admins;

class AdminsUpdateAction
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

        if (isset($this->data['roles']) && !empty($this->data['roles'])) {
            $roles = $this->data['roles'];
        }
        unset($this->data['roles']);
        $this->model->update($this->data);

        isset($roles) ? $this->model->syncRoles($roles) : $this->model->syncRoles([]);

        return $this->model;
    }
}
