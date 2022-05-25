<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller
{
    /**
     * Download media from the storage
     */
    public function download(Media $media)
    {
        return response()->download($media->getPath(), $media->file_name);
    }

    /**
     * Remove media from storage
     */
    public function remove(Media $media)
    {
        if ($media->delete()) {
            session()->flash('flash.banner', 'Remove successful.');
            session()->flash('flash.bannerStyle', 'success');
            return back();
        }
    }
}