<?php

namespace App\Http\Controllers\Admin;


use App\Actions\Role\RoleCreateAction;
use App\Actions\Role\RoleEditAction;
use App\Actions\Role\RoleIndexAction;
use App\Actions\Role\RoleStoreAction;
use App\Actions\Role\RoleUpdateAction;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class RolesController extends Controller
{

    public function __construct()
    {
        config(['auth.defaults.guard' => 'admin']);
        $this->middleware(['can:index-role'])->only(['index']);
        $this->middleware(['can:create-role'])->only(['create', 'store']);
        $this->middleware(['can:show-role'])->only(['show']);
        $this->middleware(['can:edit-role'])->only(['edit', 'update']);
        $this->middleware(['can:delete-role'])->only(['delete']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return App::call(new RoleIndexAction('admin', $request->only(['name'])));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return App::call(new RoleCreateAction($request->forModal ?? false));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'required|exists:permissions,id',
        ]);

        App::call(new RoleStoreAction($request->only(['name', 'permissions']), 'admin'));
        return redirect()->route('roles.index');
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
        return App::call(new RoleEditAction(Role::find($id), $request->forModal ?? false, 'admin'));
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
            'name' => 'required|max:100|unique:roles,name,' . $id,
            'permissions' => 'required|array',
            'permissions.*' => 'required|exists:permissions,id',
        ]);

        App::call(new RoleUpdateAction(Role::find($id), $request->only(['name', 'permissions'])));

        return back();
    }


    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id, Request $request)
    {
        Role::where('id', $id)->delete();
        // if ($request->redirectUrl) {
        //     return redirect($request->redirectUrl);
        // }
        return back();
    }
}
