<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admins\AdminsCreateAction;
use App\Actions\Admins\AdminsEditAction;
use App\Actions\Admins\AdminsIndexAction;
use App\Actions\Admins\AdminStoreAction;
use App\Actions\Admins\AdminsUpdateAction;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class AdminsController extends Controller
{


    public function __construct()
    {
        config(['auth.defaults.guard' => 'admin']);
        $this->middleware(['can:index-admin'])->only(['index']);
        $this->middleware(['can:create-admin'])->only(['create', 'store']);
        $this->middleware(['can:show-admin'])->only(['show']);
        $this->middleware(['can:edit-admin'])->only(['edit', 'update']);
        $this->middleware(['can:delete-admin'])->only(['delete']);
    }

    /**
     * @return AdminsIndexAction
     */
    public function index(Request $request)
    {

        return App::call(new AdminsIndexAction($request->only(['name', 'email'])));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return AdminsCreateAction
     */
    public function create(Request $request)
    {
        return App::call(new AdminsCreateAction($request->forModal ?? false));
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
            'email' => 'required|email|max:150|unique:admins,email',
            'password' => 'required|min:6|max:100|confirmed',
        ]);
        App::call(new AdminStoreAction($request->only(['name', 'email', 'password', 'roles'])));
        return redirect()->route('admins.index');
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
     * @return AdminsEditAction
     */
    public function edit($id, Request $request)
    {
        return App::call(new AdminsEditAction(Admin::find($id), $request->forModal ?? false));
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
            'email' => 'required|email|max:150|unique:admins,email,' . $id,
            'password' => 'nullable|min:6|max:100|confirmed',
        ]);
        App::call(new AdminsUpdateAction(Admin::find($id), $request->only(['name', 'email', 'password', 'roles'])));
        return back();
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id, Request $request)
    {
        Admin::where('id', $id)->delete();
        // if ($request->redirectUrl) {
        //     return redirect($request->redirectUrl);
        // }
        return back();
    }
}
