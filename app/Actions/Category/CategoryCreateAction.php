<?php

namespace App\Actions\Category;

use App\Actions\Action;
use App\Models\Category;
use Inertia\Inertia;


class CategoryCreateAction extends Action
{
    private $forModal;

    public function __construct($forModal)
    {
        $this->forModal = $forModal;
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
        return Inertia::render('Dashboard/_Base/Create', ['data' => $data]);
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
                    'text' => __("trans.add new"),
                ],
            ],
        ];
    }

    private function getFormAction()
    {
        return route('categories.store');
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
                    'value' => null
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
                    'levels' => [
                        [
                            'options' => Category::where('parent_id', null)->get()->map(function ($val) {
                                return [
                                    'value' => $val['id'],
                                    'label' => $val['name'],
                                ];
                            })
                        ]
                    ],
                    'value' => null,
                    'onChangeUrl' => route('categories.update-select-levels') . '?'
                ],
                // END INPUT


            ],
            // END ROW

        ];
    }
}
