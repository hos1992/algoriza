<?php

namespace App\Actions\Category;

use App\Actions\Action;
use App\Http\Resources\Admin\CategoriesResource;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryIndexAction extends Action
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
        $data = Category::when(isset($this->filter['name']) && !empty($this->filter['name']), function ($q) {
            $q->where('name', 'LIKE', '%' . $this->filter['name'] . '%');
        })->when(isset($this->filter['is_active']), function ($q) {
            $q->where('is_active', '=', $this->filter['is_active']);
        })->orderBy('id', 'DESC')->paginate(20)->withQueryString();
        return CategoriesResource::collection($data);
    }

    /**
     * @return array
     */
    private function getBreadcrumb()
    {
        // return false;
        return [
            'heading' => 'الأقسام',
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
            
            'is_active' => [
                'displayName' => __('trans.active state ?'),
                'type' => 'toggle',
                'toggleUrlAttr' => 'toggle-active-state-url', // change for each model
                'toggleModalTitle' => __('trans.confirm change active state !') // confirm modal title
            ],

        ];
    }

    /**
     * @return array
     */
    private function viewFilterForm()
    {
        # return false if no filters
        return [
            'action' => route('categories.index'),
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
                        'label' => __('trans.active state ?'),
                        'type' => 'select',
                        'name' => 'is_active',
                        'options' => [
                            [
                                'value' => "1",
                                'label' => __('trans.active'),
                            ],
                            [
                                'value' => "0",
                                'label' => __('trans.not active'),
                            ],
                        ],
                        'multiple' => false,
                        'value' => request()->is_active
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
            'add_modal_title' => __('trans.add new category'),
            'add_modal_submit_and_close_option' => false,
            'edit_modal_submit_and_close_option' => false,
            'links' => [
                'modal_add_new_url' => route('categories.create') . '?forModal=1',
                'page_add_new_url' => route('categories.create'),
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
            'canIndex' => Auth::guard('admin')->user()->can('index-category'),
            'canShow' => Auth::guard('admin')->user()->can('show-category'),
            'canAdd' => Auth::guard('admin')->user()->can('create-category'),
            'canEdit' => Auth::guard('admin')->user()->can('edit-category'),
            'canDelete' => Auth::guard('admin')->user()->can('delete-category'),
        ];
    }
}
