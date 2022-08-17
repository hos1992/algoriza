<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Product\ProductCreateAction;
use App\Actions\Product\ProductEditAction;
use App\Actions\Product\ProductIndexAction;
use App\Actions\Product\ProductStoreAction;
use App\Actions\Product\ProductUpdateAction;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{


    public function __construct()
    {
        config(['auth.defaults.guard' => 'admin']);
        $this->middleware(['can:index-product'])->only(['index']);
        $this->middleware(['can:create-product'])->only(['create', 'store']);
        $this->middleware(['can:show-product'])->only(['show']);
        $this->middleware(['can:edit-product'])->only(['edit', 'update']);
        $this->middleware(['can:delete-product'])->only(['delete']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return App::call(new ProductIndexAction($request->only(['name', 'category'])));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return ProductCreateAction
     */
    public function create(Request $request)
    {
        return App::call(new ProductCreateAction($request->forModal ?? false));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|max:1024',
            'name' => 'required|max:100',
            'description' => 'required',
            'tags' => 'nullable|max:255',
        ]);

        App::call(new ProductStoreAction($request->only([
            'category_id', 'name', 'description', 'image', 'tags'
        ])));

        return redirect()->route('products.index');


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        return App::call(new ProductEditAction(Product::find($id), $request->forModal ?? false));
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {


        $this->validate($request, [
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:1024',
            'name' => 'required|max:100',
            'description' => 'required',
            'tags' => 'nullable|max:255',
        ]);

        App::call(new ProductUpdateAction(Product::find($id), $request->only([
            'category_id', 'name', 'description', 'image', 'tags'
        ])));

        return back();


    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        Storage::delete($product->image);
        $product->delete();
        return back();
    }
}
