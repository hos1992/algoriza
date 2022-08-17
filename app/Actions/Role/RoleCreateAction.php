<?php

namespace App\Actions\Role;

use App\Actions\Action;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;

class RoleCreateAction extends Action
{

    private $forModal;
    private $guard;

    public function __construct($forModal, $guard = 'admin')
    {
        $this->forModal = $forModal;
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
                    'text' => __("trans.add new"),
                ],
            ],
        ];
    }

    private function getFormAction()
    {
        return route('roles.store');
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
                    'label' => __('trans.permissions'),
                    'type' => 'checkbox_groups',
                    'name' => 'permissions',
                    'options' => Permission::where([
                        ['guard_name', '=', $this->guard]
                    ])->get()->groupBy('module')->toArray(),
                    'value' => []
                ],
                // END INPUT

            ],
            // END ROW


        ];
    }

}
