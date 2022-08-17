<?php

namespace App\Actions\Category;

use App\Actions\Action;
use App\Models\Category;

class CategoryUpdateSelectLevelsAction extends Action
{


    private $forEditForm;

    private $levels = [];

    private $category;

    private $editCategoryId;

    public function __construct($id, $forEditForm = false, $editCategoryId = null)
    {
        $this->category = Category::find($id);

        $this->forEditForm = $forEditForm;

        $this->editCategoryId = $editCategoryId;
    }

    public function __invoke()
    {
        if (!count($this->category->ancestors)) {
            $rootLevel = [
                'options' => $this->category->siblingsAndSelf->map(function ($val) {
                    return [
                        'value' => $val['id'],
                        'label' => $val['name'],
                    ];
                }),
                'selected' => $this->category->id
            ];

            $nextLevel = [
                'options' => $this->category->children->map(function ($val) {
                    return [
                        'value' => $val['id'],
                        'label' => $val['name'],
                    ];
                }),
                'selected' => null,

            ];

            $this->levels[] = $rootLevel;
            if (count($this->category->children)) {
                $this->levels[] = $nextLevel;
            }
        } else {
            // if the $this->category has ancestors

            if (!$this->forEditForm) {

                $this->updateLevelsForCreating();

            } else {

                $this->updateLevelsForUpdating();

            }


        }


        return $this->levels;
    }


    /**
     * @return void
     */
    private function updateLevelsForCreating()
    {
        $ancestors = $this->category->ancestorsAndSelf()->with('siblingsAndSelf')->orderBy('id', 'ASC')->get();
        foreach ($ancestors as $ancestor) {
            $level = [
                'options' => $ancestor->siblingsAndSelf->map(function ($val) {
                    return [
                        'value' => $val['id'],
                        'label' => $val['name'],
                    ];
                }),
                'selected' => $ancestor->id,
            ];
            $this->levels[] = $level;
        }

        $nextLevel = [
            'options' => $this->category->children->map(function ($val) {
                return [
                    'value' => $val['id'],
                    'label' => $val['name'],
                ];
            }),
            'selected' => null,

        ];
        if (count($this->category->children)) {
            $this->levels[] = $nextLevel;
        }
    }

    /**
     * @return void
     */
    public function updateLevelsForUpdating()
    {
        if ($this->editCategoryId == $this->category->id) {
            $scope = $this->category->ancestors();
        } else {

            $scope = $this->category->ancestorsAndSelf();
        }

        $ancestors = $scope->with('siblingsAndSelf')->orderBy('id', 'ASC')->get();

        foreach ($ancestors as $ancestor) {
            $level = [
                'options' => array_filter($ancestor->siblingsAndSelf->map(function ($val) {

                    if ($val['id'] != $this->category->id) {
                        return [
                            'value' => $val['id'],
                            'label' => $val['name'],
                        ];
                    }


                })->toArray()),
                'selected' => $ancestor->id,
            ];
            $this->levels[] = $level;
        }

    }

}
