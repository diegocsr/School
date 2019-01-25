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
use App\Helpers\Helper;
use File;
use Image;

class GalleryApi extends Controller
{
    public function getGallery($album_id) {
        $galleries = Gallery::where('album_id', $album_id)
                            ->with('album')
                            ->orderBy('galleries.created_at', 'desc')->get();

        foreach ($galleries as $content) {
            $content->image_thumbnail = Helper::getThumbnailGallery($content);
            $content->image = Helper::getImageGallery($content);
        }

        if ($galleries) {
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'results' => $galleries,
            ], 200);
        }
    }

    public function submitGallery(Request $request, $album_id) {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image64:jpeg,jpg,png',
            'name' => 'required|string'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'error' => 'validation',
                'message'=> $validator->errors()
            ]); 
            
        } else {

            $imageData = $request->image;
            $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            
            $real_path = public_path('uploads' .DIRECTORY_SEPARATOR. 'galleries' .DIRECTORY_SEPARATOR. $fileName);
            $thumnbails_path = public_path('uploads' .DIRECTORY_SEPARATOR. 'galleries' .DIRECTORY_SEPARATOR.'thumbnails' .DIRECTORY_SEPARATOR. $fileName);

            Image::make($request->image)->save($real_path);
            Image::make($request->image)->resize(250, 250)->save($thumnbails_path);
            
            $gallery = new Gallery;
            $gallery->album_id = $album_id;
            $gallery->name = $request->name;
            $gallery->image = $fileName;
            $gallery->image_thumbnail = $fileName;
            $gallery->save();

            return response()->json([
                'status' => true,
                'message' => 'Success'
            ], 200);

        }
    }

    public function deleteGallery($id) {
        $gallery = Gallery::findOrFail($id);

        $real_path = public_path('uploads' .DIRECTORY_SEPARATOR. 'galleries' .DIRECTORY_SEPARATOR. $gallery->image);
        $thumnbails_path = public_path('uploads' .DIRECTORY_SEPARATOR. 'galleries' .DIRECTORY_SEPARATOR.'thumbnails' .DIRECTORY_SEPARATOR. $gallery->image);
        
        if(File::exists($real_path)) {
            File::delete($real_path);
        }
        
        if(File::exists($thumnbails_path)) {
            File::delete($thumnbails_path);
        }
        
        $gallery->delete();
        
        return response()->json([
            'status' => true,
            'message' => 'Success',
        ], 200);
    }
}
