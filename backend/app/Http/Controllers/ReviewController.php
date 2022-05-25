<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->user()->cannot('viewAny', Review::class)) {
            abort(403);
        }

        // Start from here ...
        return Inertia::render('Reviews/Index',[
            'reviews' => Review::with('reviewrateable', 'author')
            ->filter($request->all())
            ->sorted()
            ->paginate()
            ->withQueryString(),
        'query'  => $request->all(),
        ]);
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        if (request()->user()->cannot('view', $review)) {
            abort(403);
        }

        // Start from here ...
        return Inertia::render('Reviews/Show', [
            'review' => $review->load('author', 'reviewrateable'),

        ]);
    }

        /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function approved(Review $review)
    {
        if (request()->user()->cannot('update', $review)) {
            abort(403);
        }
        if ($review->approved) {
            $review->update(['approved' => false]);
            session()->flash('flash.banner', 'Review unapproved successful.');
            session()->flash('flash.bannerStyle', 'success');
        } else {
            session()->flash('flash.banner', 'Review approved successful.');
            session()->flash('flash.bannerStyle', 'success');
            $review->update(['approved' => true]);
        }

        return back();
    }
}
