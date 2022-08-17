<?php

namespace App\Actions\Category;

use App\Actions\Action;
use App\Models\Category;

class CategoryStoreAction extends Action
{

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function __invoke()
    {

        $category = Category::create([
            'name' => $this->data['name'],
            'parent_id' => $this->data['parent_id'] ?? null
        ]);
        return $category;
    }

}
