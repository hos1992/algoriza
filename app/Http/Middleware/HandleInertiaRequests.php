<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
//    protected $rootView = 'admin';

    /**
     * Determine the current asset version.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function share(Request $request)
    {
        $authedUser = Auth::guard('admin')->user() ?? Auth::user();

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $authedUser ? [
                    'id' => $authedUser['id'],
                    'name' => $authedUser['name'],
                    'email' => $authedUser['email'],
                ] : null,
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'menuPermissions' => [
                'admin' => $this->getAdminPermissions(),
                'user' => $this->getUserPermissions(),
            ],
        ]);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function rootView(Request $request): string
    {

        if ($request->route()->getPrefix() === '/system'
            || $request->route()->getPrefix() === 'system'
            || request()->segment(1) == 'system') {
            return 'system';
        }

        if ($request->route()->getPrefix() === '/ad'
            || $request->route()->getPrefix() === 'ad'
            || request()->segment(1) == 'ad') {
            return 'admin';
        }

        return 'admin';
    }


    /**
     * @return array
     */
    private function getAdminPermissions()
    {
        if (Auth::guard('admin')->user()) {
            return [
                'canIndexAdmins' => Auth::guard('admin')->user()->can('index-admin'),
                'canIndexRoles' => Auth::guard('admin')->user()->can('index-role'),
                'canIndexUsers' => Auth::guard('admin')->user()->can('index-user'),
                'canIndexCategories' => Auth::guard('admin')->user()->can('index-category'),
                'canIndexProducts' => Auth::guard('admin')->user()->can('index-product'),
            ];
        }

        return [];
    }


    /**
     * @return array
     */
    private function getUserPermissions()
    {
        if (Auth::user()) {
            return [

            ];
        }

        return [];
    }


}
