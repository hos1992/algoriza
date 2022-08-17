<?php

namespace App\Actions\Admins;

use App\Actions\Action;
use App\Http\Resources\Admin\AdminsResource;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class AdminsIndexAction extends Action
{

    private $filter;

    public function __construct($filter = null)
    {
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
        $data = Admin::where([
            ['id', '!=', Auth::guard('admin')->user()->id],
            ['super', '!=', 1],
        ])->when(isset($this->filter['name']) && !empty($this->filter['name']), function ($q) {
            $q->where('name', 'LIKE', '%' . $this->filter['name'] . '%');
        })->when(isset($this->filter['email']) && !empty($this->filter['email']), function ($q) {
            $q->where('email', 'LIKE', '%' . $this->filter['email'] . '%');
        })->orderBy('id', 'DESC')->paginate(20)->withQueryString();
        return AdminsResource::collection($data);
    }

    /**
     * @return array
     */
    private function getBreadcrumb()
    {
        // return false;
        return [
            'heading' => 'الأدارة',
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

            'email' => [
                'displayName' => __('trans.email'),
                'type' => 'text',
            ],

            'roles' => [
                'displayName' => __('trans.roles'),
                'type' => 'badge',
            ],

            // 'is_published' => [
            //     'displayName' => __('trans.publish state ?'),
            //     'type' => 'toggle',
            //     'toggleUrlAttr' => 'toggle-publish-state-url' // change for each model
            //     'toggleModalTitle' => __('trans.confirm change publish state !') // confirm modal title
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
            'action' => route('admins.index'),
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

                    // input
                    [
                        'label' => __('trans.email'),
                        'type' => 'text',
                        'name' => 'email',
                        'value' => request()->email
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
            'add_button_id' => 'add_new_admin_id',
            'add_button_text' => __('trans.add new'),
            'add_modal_title' => __('trans.add new admin'),
            'add_modal_submit_and_close_option' => false,
            'edit_modal_submit_and_close_option' => false,
            'links' => [
                'modal_add_new_url' => route('admins.create') . '?forModal=1',
                'page_add_new_url' => route('admins.create'),
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
            'canIndex' => Auth::guard('admin')->user()->can('index-admin'),
            'canShow' => Auth::guard('admin')->user()->can('show-admin'),
            'canAdd' => Auth::guard('admin')->user()->can('create-admin'),
            'canEdit' => Auth::guard('admin')->user()->can('edit-admin'),
            'canDelete' => Auth::guard('admin')->user()->can('delete-admin'),
        ];
    }
}
