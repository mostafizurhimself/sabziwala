<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Unit;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Enums\PublishStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Zone;
use Illuminate\Database\Eloquent\Builder;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if (request()->user()->cannot('viewAny', Product::class)) {
            abort(403);
        }
        // Start from here ...
        return Inertia::render('Products/Index', [
            'products' => Product::with(['category', 'tags', 'unit', 'zone'])
                ->filter($request->all())
                ->sorted()
                ->paginate()
                ->withQueryString(),
            'status' => PublishStatus::toSelectOptions(),
            'zones' => Zone::all(),
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
        if (request()->user()->cannot('create', Product::class)) {
            abort(403);
        }

        // Start from here ...
        return Inertia::render('Products/Create', [
            'categories' => Category::orderBy('name')->get(),
            'tags'       => Tag::orderBy('name')->pluck('name')->toArray(),
            'units'      => Unit::orderBy('name')->get(),
            'zones'      => Zone::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProductRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProductRequest $request)
    {
        if (request()->user()->cannot('create', Product::class)) {
            abort(403);
        }

        // Start from here ...

        DB::transaction(function () use ($request) {
            $product = Product::create($request->only('categoryId', 'zoneId', 'name', 'code', 'description', 'actualPrice', 'salePrice', 'unitId'));

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $product->addMedia($file)->toMediaCollection('collection');
                }
            }

            if ($request->hasFile('thumbnail')) {
                $product->addMedia($request->thumbnail)->toMediaCollection('thumbnail');
            }

            if ($request->has('tags')) {
                $tagIds = [];
                foreach ($request->tags as $tag) {
                    $tag = Tag::firstOrCreate(
                        ['name' => Str::title($tag)]
                    );
                    array_push($tagIds, $tag->id);
                }
                $product->tags()->sync($tagIds);
            }
        });

        session()->flash('flash.banner', 'Created successfully.');
        session()->flash('flash.bannerStyle', 'success');

        if ($request->saveAndContinue) {
            return back();
        }
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product)
    {
        if (request()->user()->cannot('view', $product)) {
            abort(403);
        }

        // Start from here ...

        return Inertia::render('Products/Show', [
            'product' => $product->load('tags', 'unit', 'category', 'zone'),
            'tags' => Tag::orderBy('name')->pluck('name')->toArray(),
            'units' => Unit::orderBy('name')->get(),


        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Product $product)
    {
        if (request()->user()->cannot('update', $product)) {
            abort(403);
        }

        // Start from here ...

        return Inertia::render('Products/Edit', [
            'product' => $product->load('tags', 'zone'),
            'categories' => Category::orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->pluck('name')->toArray(),
            'units' => Unit::orderBy('name')->get(),
            'zones'      => Zone::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     *@param  \App\Http\Requests\ProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProductRequest $request, Product $product)
    {
        if (request()->user()->cannot('update', $product)) {
            abort(403);
        }

        // Start from here ...
        DB::transaction(function () use ($request, $product) {

            $product->update($request->only('categoryId', 'zoneId', 'name', 'code', 'description', 'actualPrice', 'salePrice', 'unitId'));

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $product->addMedia($file)->toMediaCollection('collection');
                }
            }

            if ($request->hasFile('thumbnail')) {
                $product->addMedia($request->thumbnail)->toMediaCollection('thumbnail');
            }


            if ($request->has('tags')) {
                $tagIds = [];
                foreach ($request->tags as $tag) {
                    $tag = Tag::firstOrCreate(
                        ['name' => Str::title($tag)]
                    );
                    array_push($tagIds, $tag->id);
                }
                $product->tags()->sync($tagIds);
            }
        });

        session()->flash('flash.banner', 'Updated successfully.');
        session()->flash('flash.bannerStyle', 'success');

        if ($request->updateAndContinue) {
            return back();
        }
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        if (request()->user()->cannot('delete', $product)) {
            abort(403);
        }

        // Start from here ...
        if ($product->delete()) {
            session()->flash('flash.banner', 'Deleted successfully.');
            session()->flash('flash.bannerStyle', 'success');

            return back()->with('status', 'Deleted successfully.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function published(Product $product)
    {

        if (request()->user()->cannot('update', $product)) {
            abort(403);
        }

        if ($product->status == PublishStatus::UNPUBLISHED()) {
            $product->update(['status' => PublishStatus::PUBLISHED()]);
            session()->flash('flash.banner', 'Product published successful.');
            session()->flash('flash.bannerStyle', 'success');
        } else {
            session()->flash('flash.banner', 'Product Unpublished successful.');
            session()->flash('flash.bannerStyle', 'success');
            $product->update(['status' => PublishStatus::UNPUBLISHED()]);
        }
        return back();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function isFeatured(Product $product)
    {
        if (request()->user()->cannot('update', $product)) {
            abort(403);
        }
        if ($product->isFeatured) {
            $product->update(['isFeatured' => false]);
            session()->flash('flash.banner', 'Product featured Active successful.');
            session()->flash('flash.bannerStyle', 'success');
        } else {
            session()->flash('flash.banner', 'Product featured Inactive successful.');
            session()->flash('flash.bannerStyle', 'success');
            $product->update(['isFeatured' => true]);
        }

        return back();
    }
}
