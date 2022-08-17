<?php

namespace App\Actions\Role;

use App\Actions\Action;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;


class RoleEditAction extends Action
{
    private $model;
    private $forModal;
    private $guard;

    public function __construct($model, $forModal, $guard = 'admin')
    {
        $this->forModal = $forModal;
        $this->model = $model;
        $this->guard = $guard;
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
            'heading' => 'المناصب',
            'headingUrl' => route('roles.index'),
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
        return route('roles.update', $this->model->id);
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
                    'label' => __('trans.method'),
                    'type' => 'hidden',
                    'name' => '_method',
                    'value' => 'put'
                ],
                // END INPUT

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
                    'label' => __('trans.permissions'),
                    'type' => 'checkbox_groups',
                    'name' => 'permissions',
                    'options' => Permission::where([
                        ['guard_name', '=', $this->guard]
                    ])->get()->groupBy('module')->toArray(),
                    'value' => $this->model->permissions->pluck('id'),
                ],
                // END INPUT

            ],
            // END ROW


        ];
    }
}
