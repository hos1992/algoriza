<?php

namespace App\Actions\Product;

use App\Actions\Action;
use App\Http\Resources\Admin\ProductsResource;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductIndexAction extends Action
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
        $data = Product::when(isset($this->filter['name']) && !empty($this->filter['name']), function ($q) {
            $q->where('name', 'LIKE', '%' . $this->filter['name'] . '%')
                ->orWhere('description', 'LIKE', '%' . $this->filter['name'] . '%');
        })->when(isset($this->filter['category']) && !empty($this->filter['category']), function ($q) {
            $q->whereHas('category', function ($q) {
                $q->where('name', 'LIKE', '%' . $this->filter['category'] . '%');
            });
        })->with(['tags', 'category'])->orderBy('id', 'DESC')->paginate(20)->withQueryString();
        return ProductsResource::collection($data);
    }

    /**
     * @return array
     */
    private function getBreadcrumb()
    {
        // return false;
        return [
            'heading' => 'المنتجات',
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

            'image' => [
                'displayName' => __('trans.image'),
                'type' => 'image',
            ],

            'name' => [
                'displayName' => __('trans.name'),
                'type' => 'text',
            ],

            'category' => [
                'displayName' => __('trans.category'),
                'type' => 'text',
            ],

            'tags' => [
                'displayName' => __('trans.tags'),
                'type' => 'text',
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
            'action' => route('products.index'),
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
                        'label' => __('trans.category'),
                        'type' => 'text',
                        'name' => 'category',
                        'value' => request()->category
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
            'add_button_id' => 'add_new_product_id',
            'add_button_text' => __('trans.add new'),
            'add_modal_title' => __('trans.add new product'),
            'add_modal_submit_and_close_option' => false,
            'edit_modal_submit_and_close_option' => false,
            'links' => [
                'modal_add_new_url' => route('products.create') . '?forModal=1',
                'page_add_new_url' => route('products.create'),
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
            'canIndex' => Auth::guard('admin')->user()->can('index-product'),
            'canShow' => Auth::guard('admin')->user()->can('show-product'),
            'canAdd' => Auth::guard('admin')->user()->can('create-product'),
            'canEdit' => Auth::guard('admin')->user()->can('edit-product'),
            'canDelete' => Auth::guard('admin')->user()->can('delete-product'),
        ];
    }
}
