<?php

namespace App\Http\Controllers\Api\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Achievement;
use Carbon\Carbon;
use App\Rules\base64;
use App\Helpers\Helper;
use File;
use Image;

class AchievementApi extends Controller
{
    public function getAchievement() {
        $achievements = Achievement::get();

        foreach ($achievements as $content) {
            $content->image_thumbnail = Helper::getThumbnailAchievement($content);
            $content->image = Helper::getImageAchievement($content);
        }

        if ($achievements) {
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'results' => $achievements
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Achievement still empty'
            ], 200);
        }
    }

    public function storeData(Request $request) {

        // return response()->json([
        //     'status' => true,
        //     'message' => 'Success',
        //     'results' => $request->name
        // ], 200);

        $validator = Validator::make($request->all(), [
            'image' => 'required|image64:jpeg,jpg,png',
            'title' => 'required|string',
            'name' => 'required',
            'status' => 'required|string',
            'description' => 'required|string'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'error' => 'validation',
                'message'=>$validator->errors()
            ]); 
            
        } else {

            $imageData = $request->image;
            $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            
            $real_path = public_path('uploads' .DIRECTORY_SEPARATOR. 'achievements' .DIRECTORY_SEPARATOR. $fileName);
            $thumnbails_path = public_path('uploads' .DIRECTORY_SEPARATOR. 'achievements' .DIRECTORY_SEPARATOR.'thumbnails' .DIRECTORY_SEPARATOR. $fileName);

            Image::make($request->image)->save($real_path);
            Image::make($request->image)->resize(100, 100)->save($thumnbails_path);
            
            $achievement = new Achievement;
            $achievement->title = $request->title;
            $achievement->description = $request->description;
            $achievement->rank = 'Juara';
            $achievement->slug = str_slug($request->title);
            $achievement->status = $request->status;
            $achievement->name = $request->name;
            $achievement->image = $fileName;
            $achievement->image_thumbnail = $fileName;
            $achievement->save();

            return response()->json([
                'status' => true,
                'message' => 'Success',
                'results' => $achievement
            ], 200);

        }
    }

    public function publishData($id) {
        $achievement = Achievement::findOrFail($id);
        $achievement->status = true;
        $achievement->save();

        if ($achievement) {
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'results' => $achievement
            ], 200);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Failed update status'
            ], 200);
        }
    }

    public function unpublishData($id) {
        $achievement = Achievement::findOrFail($id);
        $achievement->status = false;
        $achievement->save();

        if ($achievement) {
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'results' => $achievement
            ], 200);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Failed update status'
            ], 200);
        }
    }

    public function updateData(Request $request) {


        $data = Achievement::find($request->id);

        $old_real_path = Helper::getImageAchievement($data);

        if ($request->image !== $old_real_path) {
        
            $validator = Validator::make($request->all(), [
                'image' => 'image64:jpeg,jpg,png',
                'title' => 'required|string',
                'name' => 'required|string',
                'status' => 'required|integer',
                'description' => 'required|string'
                ]);            
                
        } else {
                
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'name' => 'required|string',
                'status' => 'required|integer',
                'description' => 'required|string'
                ]);
                
        }


        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'error' => 'validation',
                'message'=>$validator->errors()
            ]); 
            
        } else {

            if ($request->image !== $old_real_path) {
            
                $data = Achievement::find($request->id);

                $old_real_path = public_path('uploads' .DIRECTORY_SEPARATOR. 'achievements' .DIRECTORY_SEPARATOR. $data->image);
                $old_thumbnails_path = public_path('uploads' .DIRECTORY_SEPARATOR. 'achievements' .DIRECTORY_SEPARATOR.'thumbnails' .DIRECTORY_SEPARATOR. $data->image_thumbnail); 

                if(File::exists($old_real_path) && File::exists($old_thumbnails_path)) {
                    File::delete($old_real_path);
                    File::delete($old_thumbnails_path);
                }

                $imageData = $request->image;
                $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                
                $real_path = public_path('uploads' .DIRECTORY_SEPARATOR. 'achievements' .DIRECTORY_SEPARATOR. $fileName);
                $thumnbails_path = public_path('uploads' .DIRECTORY_SEPARATOR. 'achievements' .DIRECTORY_SEPARATOR.'thumbnails' .DIRECTORY_SEPARATOR. $fileName);

                Image::make($request->image)->save($real_path);
                Image::make($request->image)->resize(100, 100)->save($thumnbails_path);
                
                $data->title = $request->title;
                $data->description = $request->description;
                $data->rank = 'Juara';
                $data->slug = str_slug($request->title);
                $data->status = $request->status;
                $data->name = $request->name;
                $data->image = $fileName;
                $data->image_thumbnail = $fileName;
                $data->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Success',
                    'results' => $data
                ], 200);

            } else {

                $data = Achievement::find($request->id);

                $data->title = $request->title;
                $data->description = $request->description;
                $data->rank = 'Juara';
                $data->slug = str_slug($request->title);
                $data->status = $request->status;
                $data->name = $request->name;
                $data->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Success',
                    'results' => $data
                ], 200);

            }

            

        }
    }

    public function deleteData($id) {
        $achievement = Achievement::findOrFail($id);
        
        if ($achievement) {

            $real_path = public_path('uploads' .DIRECTORY_SEPARATOR. 'achievements' .DIRECTORY_SEPARATOR. $achievement->image);
            $thumnbails_path = public_path('uploads' .DIRECTORY_SEPARATOR. 'achievements' .DIRECTORY_SEPARATOR.'thumbnails' .DIRECTORY_SEPARATOR. $achievement->image);
            
            if(File::exists($real_path)) {
                File::delete($real_path);
            }
            
            if(File::exists($thumnbails_path)) {
                File::delete($thumnbails_path);
            }
            
            $achievement->delete();
            
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'results' => $achievement
            ], 200);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Failed delete achievement'
            ], 200);
        }
    }

    public function showData($id) {
        
    }
}
