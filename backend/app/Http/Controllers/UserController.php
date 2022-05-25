<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if (request()->user()->cannot('viewAny', User::class)) {
            abort(403);
        }
        // Start from here ...
        return Inertia::render('Users/Index', [
            'users' => User::filter($request->all())
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
        if (request()->user()->cannot('create', User::class)) {
            abort(403);
        }
        // Start from here ...
        return Inertia::render('Users/Create', [
            'roles' => Role::withoutSuperAdmin()->orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request)
    {
        if (request()->user()->cannot('create', User::class)) {
            abort(403);
        }

        DB::transaction(function () use ($request) {
            $user = User::create(array_merge(
                $request->only('name', 'email'),
                ['password' => bcrypt($request->password)]
            ));

            if ($request->has('role')) {
                $user->syncRoles([$request->role]);
            }
        });

        session()->flash('flash.banner', 'Created successfully.');
        session()->flash('flash.bannerStyle', 'success');

        if ($request->saveAndContinue) {
            return back();
        }
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        if (request()->user()->cannot('view', $user)) {
            abort(403);
        }

        // Start from here ...
        return Inertia::render('Users/Show', [
            'user' => $user,

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(User $user)
    {
        if (request()->user()->cannot('update', $user)) {
            abort(403);
        }

        // Start from here ...
        return Inertia::render('Users/Edit', [
            'user'  => $user,
            'roles' => Role::withoutSuperAdmin()->orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request, User $user)
    {
        if (request()->user()->cannot('update', $user)) {
            abort(403);
        }

        // Start from here ...
        DB::transaction(function () use ($request, $user) {
            $user->update(array_merge(
                $request->only('name', 'email'),
                ['password' => !empty($request->password) ? bcrypt($request->password) : $user->password]
            ));

            if ($request->has('role')) {
                $user->syncRoles([$request->role]);
            }
        });

        session()->flash('flash.banner', 'Updated successfully.');
        session()->flash('flash.bannerStyle', 'success');

        if ($request->updateAndContinue) {
            return back();
        }
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        if (request()->user()->cannot('delete', $user)) {
            abort(403);
        }

        // Start from here ...
    }
}
