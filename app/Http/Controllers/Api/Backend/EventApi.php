<?php

namespace App\Http\Controllers\Api\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use Carbon\Carbon;
use App\Rules\base64;
use File;
use App\Helpers\Helper;
use Image;

class EventApi extends Controller
{
    public function getEvent()
    {
        $categories = Category::get();
        $events = Event::with(['Category' => function ($q) {
            $q->select('categories.*');
        }])->orderBy('events.title')->get();

        foreach ($events as $content) {
            $content->photo_thumbnail = Helper::getThumbnailEvent($content);
            $content->photo = Helper::getImageEvent($content);
        }

        if ($events) {
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'results' => $events,
                'data_category' => $categories
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'event still empty',
                'data_category' => $categorys
            ], 200);    
        }
    }

    public function storeData(Request $request) {


        $validator = Validator::make($request->all(), [
            'image' => 'required|image64:jpeg,jpg,png',
            'title' => 'required|string',
            'category' => 'required|exists:categories,id',
            'status' => 'required|boolean',
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
            
            $real_path = public_path('uploads' .DIRECTORY_SEPARATOR. 'events' .DIRECTORY_SEPARATOR. $fileName);
            $thumnbails_path = public_path('uploads' .DIRECTORY_SEPARATOR. 'events' .DIRECTORY_SEPARATOR.'thumbnails' .DIRECTORY_SEPARATOR. $fileName);

            Image::make($request->image)->save($real_path);
            Image::make($request->image)->resize(100, 100)->save($thumnbails_path);
            
            $event = new Event;
            $event->title = $request->title;
            $event->body = $request->description;
            $event->slug = str_slug($request->title);
            $event->status = $request->status;
            $event->category_id = $request->category;
            $event->photo = $fileName;
            $event->photo_thumbnail = $fileName;
            $event->save();

            return response()->json([
                'status' => true,
                'message' => 'Success',
                'results' => $event
            ], 200);
        }
    }

    public function publishData($id) {
        $event = Event::findOrFail($id);
        $event->status = true;
        $event->save();

        if ($event) {
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'results' => $event
            ], 200);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Failed update status'
            ], 200);
        }
    }

    public function unpublishData($id) {
        $event = Event::findOrFail($id);
        $event->status = false;
        $event->save();

        if ($event) {
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'results' => $event
            ], 200);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Failed update status'
            ], 200);
        }
    }

    public function updateData(Request $request) {
        
        $content = Event::find($request->id);

        $old_real_path = Helper::getImageEvent($content);
        // $old_real_path = public_path('uploads' .DIRECTORY_SEPARATOR. 'events' .DIRECTORY_SEPARATOR. $content->photo);

        if ($request->photo !== $old_real_path) {

            $validator = Validator::make($request->all(), [
                'photo' => 'required|image64:jpeg,jpg,png',
                'title' => 'required|string',
                'category_id' => 'required|exists:categories,id',
                'status' => 'required|boolean',
                'body' => 'required|string'
            ]);
        
        } else {
            
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'category_id' => 'required|exists:categories,id',
                'status' => 'required|boolean',
                'body' => 'required|string'
            ]);

        }
        
        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'error' => 'validation',
                'message'=> $validator->errors()
            ]); 
            
        } else {

            if ($request->photo !== $old_real_path) {
                
                $data = Event::find($request->id);

                $old_real_path = public_path('uploads' .DIRECTORY_SEPARATOR. 'events' .DIRECTORY_SEPARATOR. $data->photo);
                $old_thumbnails_path = public_path('uploads' .DIRECTORY_SEPARATOR. 'events' .DIRECTORY_SEPARATOR.'thumbnails' .DIRECTORY_SEPARATOR. $data->photo_thumbnail); 

                if (File::exists($old_real_path) && File::exists($old_thumbnails_path)) {
                    File::delete($old_real_path);
                    File::delete($old_thumbnails_path);
                }

                $imageData = $request->photo;
                $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                
                $real_path = public_path('uploads' .DIRECTORY_SEPARATOR. 'events' .DIRECTORY_SEPARATOR. $fileName);
                $thumnbails_path = public_path('uploads' .DIRECTORY_SEPARATOR. 'events' .DIRECTORY_SEPARATOR.'thumbnails' .DIRECTORY_SEPARATOR. $fileName);

                Image::make($request->photo)->save($real_path);
                Image::make($request->photo)->resize(100, 100)->save($thumnbails_path);
                
                $data->title = $request->title;
                $data->body = $request->body;
                $data->slug = str_slug($request->title);
                $data->status = $request->status;
                $data->category_id = $request->category_id;
                $data->photo = $fileName;
                $data->photo_thumbnail = $fileName;
                $data->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Success',
                    'results' => $data
                ], 200);

            } else {

                $data = Event::find($request->id);
                $data->title = $request->title;
                $data->body = $request->body;
                $data->slug = str_slug($request->title);
                $data->status = $request->status;
                $data->category_id = $request->category_id;
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
        $event = Event::findOrFail($id);
        
        $real_path = public_path('uploads' .DIRECTORY_SEPARATOR. 'events' .DIRECTORY_SEPARATOR. $event->photo);
        $thumnbails_path = public_path('uploads' .DIRECTORY_SEPARATOR. 'events' .DIRECTORY_SEPARATOR.'thumbnails' .DIRECTORY_SEPARATOR. $event->photo);
        
        if(File::exists($real_path)) {
            File::delete($real_path);
        }
        
        if(File::exists($thumnbails_path)) {
            File::delete($thumnbails_path);
        }
        
        $event->delete();

        return response()->json([
            'status' => true,
            'message'=> 'Berhail'
        ], 200);
        
    }
}

