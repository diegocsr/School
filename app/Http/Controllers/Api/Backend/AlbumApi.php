<?php

namespace App\Http\Controllers\Api\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Gallery;
use App\Models\Album;
use Carbon\Carbon;
use App\Rules\base64;
use File;
use App\Helpers\Helper;
use Image;

class AlbumApi extends Controller
{
    public function getAlbum() {
        $albums = Album::with('galleries')->get();

        if ($albums) {
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'albums' => $albums
            ], 200);
        }
    }

    public function submitAlbum(Request $request) {
        
        $albums = Album::create($request->all());

        if ($albums) {
            return response()->json([
                'status' => true,
                'message' => 'Success'
            ], 200);
        }
    }

    public function deleteAlbum($id) {
        $album = Album::findOrFail($id);
        
        $album->delete();

        if ($album) {
            return response()->json([
                'status' => true,
                'message' => 'Success'
            ], 200);
        }
    }

    public function updateAlbum(Request $request, $id) {
        $album = Album::find($id);
        $album->name = $request->name;
        $album->save();

        if ($album) {
            return response()->json([
                'status' => true,
                'message' => 'Success'
            ], 200);
        }
    }
}
