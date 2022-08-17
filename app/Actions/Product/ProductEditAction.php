<?php

namespace App\Actions\Product;

use App\Actions\Action;
use App\Actions\Category\CategoryUpdateSelectLevelsAction;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;


class ProductEditAction extends Action
{
    private $model;
    private $forModal;

    public function __construct($model, $forModal)
    {
        $this->forModal = $forModal;
        $this->model = $model;
    }

    public function __invoke()
    {
        $data['breadcrumb'] = $this->getBreadcrumb();
        $data['formAction'] = $this->getFormAction();
        $data['formMethod'] = 'post';
        $data['formRows'] = $this->getFormRows();
        if ($this->forModal) {
            return $data;
        }
        return Inertia::render('Dashboard/_Base/Edit', ['data' => $data]);
    }


    /**
     *
     * @return array[]
     */
    private function getBreadcrumb()
    {
        // return false;
        return [
            'heading' => 'المنتجات',
            'headingUrl' => route('products.index'),
            'tree' => [
                //    [
                //         'type' => 'url',
                //         'url' => route('admins.index'),
                //         'text' => 'لينك الرئيسية',
                //    ],
                [
                    'type' => 'text',
                    'text' => __("trans.edit"),
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    private function getFormAction()
    {
        return route('products.update', $this->model->id);
    }

    /**
     * @return \array[][]
     */
    private function getFormRows()
    {

        return [

            // ROW
            [
                // input
                [
                    'label' => __('trans.image'),
                    'type' => 'image',
                    'name' => 'image',
                    'value' => Storage::url($this->model->image),
                ],
                // END INPUT

                // input
                [
                    'label' => '_method',
                    'type' => 'hidden',
                    'name' => '_method',
                    'value' => 'put',
                ],
                // END INPUT

            ],
            // END ROW

            // ROW
            [
                // input
                [
                    'label' => __('trans.name'),
                    'type' => 'text',
                    'name' => 'name',
                    'value' => $this->model->name
                ],
                // END INPUT

            ],
            // END ROW

            // ROW
            [
                // input
                [
                    'label' => __('trans.description'),
                    'type' => 'textarea',
                    'name' => 'description',
                    'value' => $this->model->description
                ],
                // END INPUT

            ],
            // END ROW


            // ROW
            [

                // input
                [
                    'label' => __('trans.parent category'),
                    'type' => 'select_levels',
                    'name' => 'category_id',
                    'levels' => App::call(new CategoryUpdateSelectLevelsAction($this->model->category_id)),
                    'value' => $this->model->category_id,
                    'onChangeUrl' => route('categories.update-select-levels') . '?'
                ],
                // END INPUT

            ],
            // END ROW

            // ROW
            [
                // input
                [
                    'label' => __('trans.tags'),
                    'type' => 'text',
                    'name' => 'tags',
                    'placeholder' => 'tag,tag,tag',
                    'value' => implode(',', $this->model->tags->pluck('name')->toArray())
                ],
                // END INPUT

            ],
            // END ROW


        ];
    }
}
