<?php

namespace App\Actions\Category;

use App\Actions\Action;

class CategoryUpdateAction extends Action
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
        $this->model->update([
            'name' => $this->data['name'],
            'parent_id' => $this->data['parent_id'] ?? null,
        ]);
        return $this->model;
    }
}
