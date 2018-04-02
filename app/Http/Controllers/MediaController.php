<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;

class MediaController extends Controller
{
    public function delete(Request $request, Media $media)
    {
        $media->delete();
        if ($request->wantsJson()) {
            return 'ok';
        }
        else {
            return back()->with('status', 'Media deleted');
        }
    }
}