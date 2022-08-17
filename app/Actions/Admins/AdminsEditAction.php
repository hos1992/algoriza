<?php

namespace App\Actions\Admins;

use App\Actions\Action;
use App\Models\Role;
use Inertia\Inertia;


class AdminsEditAction extends Action
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
            'heading' => 'الأدارة',
            'headingUrl' => route('admins.index'),
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
        return route('admins.update', $this->model->id);
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
                    'label' => __('trans.email'),
                    'type' => 'email',
                    'name' => 'email',
                    'value' => $this->model->email,
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
                    'label' => __('trans.password'),
                    'type' => 'password',
                    'name' => 'password',
                    'value' => null
                ],
                // END INPUT

                // input
                [
                    'label' => __('trans.password confirmation'),
                    'type' => 'password',
                    'name' => 'password_confirmation',
                    'value' => null
                ],
                // END INPUT

            ],
            // END ROW


            // ROW
            [

                // input
                [
                    'label' => __('trans.roles'),
                    'type' => 'select',
                    'name' => 'roles',
                    'options' => Role::where([
                        // will add the user_id in the where for users not admins
                        ['guard_name', '=', 'admin'],
                        ['name', '!=', 'super-admin'],
                    ])->get()->map(function ($val) {
                        return [
                            'value' => $val['id'],
                            'label' => $val['name'],
                        ];
                    }),
                    'multiple' => true,
                    'value' => $this->model->roles()->pluck('id') ?? null,
                ],
                // END INPUT


            ],
            // END ROW

        ];
    }
}
