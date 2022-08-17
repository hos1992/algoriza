<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admins\AdminStoreAction;
use App\Actions\Category\CategoryCreateAction;
use App\Actions\Category\CategoryEditAction;
use App\Actions\Category\CategoryIndexAction;
use App\Actions\Category\CategoryStoreAction;
use App\Actions\Category\CategoryUpdateAction;
use App\Actions\Category\CategoryUpdateSelectLevelsAction;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CategoriesController extends Controller
{


    public function __construct()
    {
        config(['auth.defaults.guard' => 'admin']);
        $this->middleware(['can:index-category'])->only(['index']);
        $this->middleware(['can:create-category'])->only(['create', 'store']);
        $this->middleware(['can:show-category'])->only(['show']);
        $this->middleware(['can:edit-category'])->only(['edit', 'update']);
        $this->middleware(['can:delete-category'])->only(['delete']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return App::call(new CategoryIndexAction($request->only(['name', 'is_active'])));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return CategoryCreateAction
     */
    public function create(Request $request)
    {
        return App::call(new CategoryCreateAction($request->forModal ?? false));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        App::call(new CategoryStoreAction($request->only(['name', 'parent_id'])));

        return redirect()->route('categories.index');
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
     * @return CategoryEditAction
     */
    public function edit($id, Request $request)
    {
        return App::call(new CategoryEditAction(Category::find($id), $request->forModal ?? false));
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
            'name' => 'required|max:100',
            'parent_id' => 'nullable|exists:categories,id|not_in:' . $id,
        ]);

        $category = Category::find($id);
        $parent = Category::find($request->parent_id);
        if ($parent->parent_id == $category->id) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'parent_id' => ['Parent id is invalid !'],
            ]);
            throw $error;
        }

        App::call(new CategoryUpdateAction($category, $request->only(['name', 'parent_id'])));

        return back();

    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Category::where('id', $id)->delete();
        return back();
    }


    /**
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleActiveState(Category $category)
    {
        $category->update([
            'is_active' => !$category->is_active,
        ]);

        return back();
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function updateSelectLevels(Request $request)
    {
        return App::call(new CategoryUpdateSelectLevelsAction($request->id, $request->forEditForm, $request->editCategoryId));
    }
}
