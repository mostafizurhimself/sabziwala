<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if (request()->user()->cannot('viewAny', Category::class)) {
            abort(403);
        }

        // Start from here ...

        return Inertia::render('Categories/Index', [
            'categories' => Category::filter($request->all())
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
        if (request()->user()->cannot('create', Category::class)) {
            abort(403);
        }

        // Start from here ...

        return Inertia::render('Categories/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryRequest $request)
    {
        if (request()->user()->cannot('create', Category::class)) {
            abort(403);
        }

        // Start from here ...
        DB::transaction(function () use ($request) {
            $category = Category::create($request->only('name', 'description'));

            if ($request->hasFile('image')) {
                $category->addMedia($request->image)->toMediaCollection('primary');
            }
        });

        session()->flash('flash.banner', 'Created successfully.');
        session()->flash('flash.bannerStyle', 'success');

        if ($request->saveAndContinue) {
            return back();
        }
        return redirect()->route('categories.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Category $category)
    {
        if (request()->user()->cannot('update', $category)) {
            abort(403);
        }

        // Start from here ...
        return Inertia::render('Categories/Edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CategoryRequest $request, Category $category)
    {
        if (request()->user()->cannot('update', $category)) {
            abort(403);
        }


        // Start from here ...
        $category->update($request->only('name', 'description'));

        if ($request->hasFile('image')) {
            $category->addMedia($request->image)->toMediaCollection('primary');
        }

        session()->flash('flash.banner', 'Updated successfully.');
        session()->flash('flash.bannerStyle', 'success');

        if ($request->updateAndContinue) {
            return back();
        }
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category)
    {
        if (request()->user()->cannot('delete', $category)) {
            abort(403);
        }

        // Start from here ...
        if ($category->products()->exists()) {
            $products = $category->products()->count();
            session()->flash('flash.banner', "There are {$products} products related to it. You can not delete it now.");
            session()->flash('flash.bannerStyle', 'danger');
        } else {
            if ($category->delete()) {
                session()->flash('flash.banner', 'Deleted successfully.');
                session()->flash('flash.bannerStyle', 'success');
            }
        }
        return back();
    }
}