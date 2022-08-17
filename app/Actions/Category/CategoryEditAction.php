<?php

namespace App\Actions\Category;

use App\Actions\Action;
use App\Models\Category;
use Illuminate\Support\Facades\App;
use Inertia\Inertia;


class CategoryEditAction extends Action
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
            'heading' => 'الأقسام',
            'headingUrl' => route('categories.index'),
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
        return route('categories.update', $this->model->id);
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
                    'label' => __('trans.name'),
                    'type' => 'text',
                    'name' => 'name',
                    'value' => $this->model->name
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
                    'label' => __('trans.parent category'),
                    'type' => 'select_levels',
                    'name' => 'parent_id',
                    'levels' => App::call(new CategoryUpdateSelectLevelsAction($this->model->id, true, $this->model->id)),
                    'value' => $this->model->parent_id,
                    'editModelId' => $this->model->id,
                    'onChangeUrl' => route('categories.update-select-levels') . '?forEditForm=1'
                ],
                // END INPUT

            ],
            // END ROW

        ];
    }
}
