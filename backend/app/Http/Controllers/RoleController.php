<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\PermissionGroup;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if (request()->user()->cannot('viewAny', Role::class)) {
            abort(403);
        }
        return Inertia::render('Roles/Index', [
            'roles' => Role::filter($request->all())
                ->withoutSuperAdmin()
                ->sorted()
                ->paginate()
                ->withQueryString(),
            'query'  => $request->all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        if (request()->user()->cannot('create', Role::class)) {
            abort(403);
        }
        return Inertia::render('Roles/Create', [
            'permissions' => PermissionGroup::orderBy('order', 'asc')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RoleRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RoleRequest $request)
    {
        if (request()->user()->cannot('create', Role::class)) {
            abort(403);
        }

        DB::transaction(function () use ($request) {
            $role = Role::create($request->only('name', 'description'));

            if ($request->has('permissions')) {
                $role->syncPermissions($request->permissions);
            }
        });
        session()->flash('flash.banner', 'Created successfully.');
        session()->flash('flash.bannerStyle', 'success');

        if ($request->saveAndContinue) {
            return back();
        }
        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Role $role)
    {
        if (request()->user()->cannot('view', $role)) {
            abort(403);
        }

        // Start from here ...

        return Inertia::render('Roles/Show', [
            'role' => $role->load('permissions'),
            'permissions' => PermissionGroup::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Role $role)
    {
        if (request()->user()->cannot('update', $role)) {
            abort(403);
        }
        return Inertia::render('Roles/Edit', [
            'permissions' => PermissionGroup::orderBy('order', 'asc')->get(),
            'role'        => $role->append('permissions')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\RoleRequest  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(RoleRequest $request, Role $role)
    {
        if (request()->user()->cannot('update', $role)) {
            abort(403);
        }
        DB::transaction(function () use ($request, $role) {
            $role->update($request->only('name', 'description'));

            if ($request->has('permissions')) {
                $role->syncPermissions($request->permissions);
            }
        });

        session()->flash('flash.banner', 'Updated successfully.');
        session()->flash('flash.bannerStyle', 'success');

        if ($request->updateAndContinue) {
            return back();
        }

        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Role $role)
    {
        if (request()->user()->cannot('delete', $role)) {
            abort(403);
        }
        if ($role->delete()) {
            session()->flash('flash.banner', 'Deleted successfully.');
            session()->flash('flash.bannerStyle', 'success');
        }

        return back();
    }
}
