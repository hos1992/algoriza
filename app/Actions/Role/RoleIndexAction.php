<?php

namespace App\Actions\Role;

use App\Actions\Action;
use App\Http\Resources\Admin\AdminsResource;
use App\Http\Resources\Admin\RolesResource;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class RoleIndexAction extends Action
{

    protected $guard;

    private $filter;

    public function __construct($guard = 'admin', $filter = null)
    {
        $this->guard = $guard;
        $this->filter = $filter;
    }

    public function __invoke()
    {
        $data['collection'] = $this->getCollectionData();
        $data['breadcrumb'] = $this->getBreadcrumb();
        $data['tableHeaders'] = $this->getTableHeaders();
        $data['filterForm'] = $this->viewFilterForm();
        $data['config'] = $this->getConfig();
        $data['rules'] = $this->viewRules();
        return \Inertia\Inertia::render('Dashboard/_Base/Index', ['data' => $data]);
    }


    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    private function getCollectionData()
    {
        $data = Role::when($this->guard == 'admin', function ($q) {
            $q->where([
                ['guard_name', '=', $this->guard],
                ['name', '!=', 'super-admin'],
            ]);
        })->when($this->guard == 'web', function ($q) {
            $q->where([
                ['guard_name', '=', $this->guard],
                ['name', '!=', 'super-user'],
            ]);
        })->when(isset($this->filter['name']) && !empty($this->filter['name']), function ($q) {
            $q->where([
                ['name', 'LIKE', "%{$this->filter['name']}%"],
            ]);
        })->orderBY('id', 'DESC')->paginate(20)->withQueryString();

        return RolesResource::collection($data);
    }

    /**
     * @return array
     */
    private function getBreadcrumb()
    {
        // return false;
        return [
            'heading' => 'المناصب',
            // 'headingUrl' => route('admins.index'),
            'tree' => [
                //    [
                //         'type' => 'url',
                //         'url' => route('admins.index'),
                //         'text' => 'لينك الرئيسية',
                //    ],
                [
                    'type' => 'text',
                    'text' => 'عرض الجميع',
                ],
            ],
        ];
    }

    /**
     * @return array[]
     */
    private function getTableHeaders()
    {
        return [

            'name' => [
                'displayName' => __('trans.name'),
                'type' => 'text',
            ],


            // 'is_published' => [
            //     'displayName' => __('trans.publish state ?'),
            //     'type' => 'toggle',
            //     'toggleUrlAttr' => 'toggle-publish-state-url' // change for each model
            // ],

        ];
    }

    /**
     * @return array
     */
    private function viewFilterForm()
    {
        # return false if no filters

        return [
            'action' => route('roles.index'),
            'method' => 'get',
            'rows' => [
                // ROW
                [
                    // input
                    [
                        'label' => __('trans.name'),
                        'type' => 'text',
                        'name' => 'name',
                        'value' => request()->name
                    ],
                    // END INPUT

                ],
                // END ROW
            ]
        ];
    }

    /**
     * Index page config
     *
     * @return array[]
     */
    private function getConfig()
    {
        return [
            'add_in_modal' => true,
            'edit_in_modal' => true,
            'add_button_id' => 'add_new_role_id',
            'add_button_text' => __('trans.add new'),
            'add_modal_title' => __('trans.add new role'),
            'add_modal_submit_and_close_option' => false,
            'edit_modal_submit_and_close_option' => false,
            'links' => [
                'modal_add_new_url' => route('roles.create') . '?forModal=1',
                'page_add_new_url' => route('roles.create'),
                'table_options' => [
                    // here table options ( export to excel url || print url)
                ]
            ],
        ];
    }


    /**
     * @return array
     */
    private function viewRules()
    {
        return [
            'canIndex' => Auth::guard('admin')->user()->can('index-role'),
            'canShow' => Auth::guard('admin')->user()->can('show-role'),
            'canAdd' => Auth::guard('admin')->user()->can('create-role'),
            'canEdit' => Auth::guard('admin')->user()->can('edit-role'),
            'canDelete' => Auth::guard('admin')->user()->can('delete-role'),
        ];
    }

}
