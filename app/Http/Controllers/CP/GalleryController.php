<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function editGallery(Request $request, $id)
    {
        $gallery = Gallery::where('id', $id)->first();

        if ($request->ajax()) {
            $gallery->file_type = $request->position;
            $gallery->save();

            return response()->json(['success' => 1]);
        }

        return view('cp.gallery.edit', compact('gallery'));
    }
}
