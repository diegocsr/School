<?php

namespace App\Http\Controllers\Api\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Teacher;
use App\Models\Position;
use Carbon\Carbon;
use App\Rules\base64;
use File;
use App\Helpers\Helper;
use Image;

class TeacherApi extends Controller
{
    public function getTeacher() {
        $positions = Position::get();
        $teachers = Teacher::with(['position' => function ($q) {
            $q->select('positions.*');
        }])->orderBy('teachers.name')->get();

        foreach ($teachers as $content) {
            if ($content->photo && $content->photo_thumbnail) {
                $content->photo_thumbnail = Helper::getThumbnailTeacher($content);
                $content->photo = Helper::getPhotoTeacher($content);
            }
        }

        if ($teachers) {
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'results' => $teachers,
                'data_position' => $positions
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Teacher still empty',
                'data_position' => $positions
            ], 200);
        }
    }

    public function storeData(Request $request) {
        
        if ($request->image) {
            
            $a = ['image' => $request->image];

            $validatorImage = Validator::make($a, [
                'image' => 'required|image64:jpeg,jpg,png',
            ]);

            $validatorData = Validator::make($request->data, [
                'name' => 'required|string',
                'position' => 'required',
                'course' => 'required|string',
                'nip' => 'required|string'
            ]);

            if ($validatorImage->fails() || $validatorData->fails()) {
    
                if ($validatorImage->fails()) {
                    return response()->json([
                        'status' => false,
                        'error' => 'validation',
                        'info' => 'image',
                        'message'=>$validatorImage->errors()
                    ]);
                } 
                
                if ($validatorData->fails()) {
                    return response()->json([
                        'status' => false,
                        'error' => 'validation',
                        'info' => 'data',
                        'message'=>$validatorData->errors()
                    ]);
                } 

                if ($validatorData->fails() && $validatorImage->fails()) {
                    return response()->json([
                        'status' => false,
                        'error' => 'validation-both',
                        'messageData'=>$validatorData->errors(),
                        'messageImage'=>$validatorImage->errors()
                    ]);
                }


            } else {

                $imageData = $request->image;
                $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                
                $real_path = public_path('uploads' .DIRECTORY_SEPARATOR. 'teachers' .DIRECTORY_SEPARATOR. $fileName);
                $thumnbails_path = public_path('uploads' .DIRECTORY_SEPARATOR. 'teachers' .DIRECTORY_SEPARATOR.'thumbnails' .DIRECTORY_SEPARATOR. $fileName);

                Image::make($request->get('image'))->save($real_path);
                Image::make($request->get('image'))->resize(100, 100)->save($thumnbails_path);
                
                $teacher = new Teacher;
                $teacher->name = $request->data['name'];
                $teacher->nip = $request->data['nip'];
                $teacher->position_id = $request->data['position'];
                $teacher->photo = $fileName;
                $teacher->photo_thumbnail = $fileName;
                $teacher->course = $request->data['course'];
                $teacher->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Success',
                    'results' => $teacher
                ], 200);

            }

        } else {

            $validator = Validator::make($request->get('data'), [
                'name' => 'required|string',
                'position' => 'required',
                'course' => 'required|string',
                'nip' => 'required|string'
            ]);

            if ($validator->fails()) {
    
                return response()->json([
                    'status' => false,
                    'error' => 'validation',
                    'info' => 'data',
                    'message'=> $validator->errors()
                ]);

            } else {

                $default_thumbnail = 'default-avatar-min.jpg';
                $default_real = 'default-avatar.jpg';
    
                $teacher = new Teacher;
                $teacher->name = $request->data['name'];
                $teacher->nip = $request->data['nip'];
                $teacher->position_id = $request->data['position'];
                $teacher->photo = null;
                $teacher->photo_thumbnail = null;
                $teacher->course = $request->data['course'];
                $teacher->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Success',
                    'results' => $teacher
                ], 200);

            }

        }

    }

    public function updateData(Request $request) {
        
        if ($request->image) {
            $validator = Validator::make($request->all(), [
                'image' => 'image64:jpeg,jpg,png',
                'data.name' => 'string',
                'data.course' => 'string',
                'data.nip' => 'string'
            ]);    
        } else {
            $validator = Validator::make($request->all(),[
                'data.name' => 'string',
                'data.course' => 'string',
                'data.nip' => 'string'
            ]);
        }


        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'error' => 'validation',
                'message'=>$validator->errors()
            ]);

        } else {

            if ($request->get('image')) {
                
                $data = Teacher::find($request->data['id']);
                $data_request = $request->get('data');
                
                // $real_image = explode('/',$data_request['photo']);
                // $thumbnail_image = explode('/',$data_request['photo_thumbnail']);
                
                $data = Teacher::find($data_request['id']);

                $old_real_path = public_path('uploads' .DIRECTORY_SEPARATOR. 'teachers' .DIRECTORY_SEPARATOR. $data->photo);
                $old_thumbnails_path = public_path('uploads' .DIRECTORY_SEPARATOR. 'teachers' .DIRECTORY_SEPARATOR.'thumbnails' .DIRECTORY_SEPARATOR. $data->photo_thumbnail); 

                if(File::exists($old_real_path) && File::exists($old_thumbnails_path)) {
                    File::delete($old_real_path);
                    File::delete($old_thumbnails_path);
                }

                $imageData = $request->get('image');
                $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];

                $real_path = public_path('uploads' .DIRECTORY_SEPARATOR. 'teachers' .DIRECTORY_SEPARATOR. $fileName);
                $thumnbails_path = public_path('uploads' .DIRECTORY_SEPARATOR. 'teachers' .DIRECTORY_SEPARATOR.'thumbnails' .DIRECTORY_SEPARATOR. $fileName);
                
                Image::make($request->get('image'))->save($real_path);
                Image::make($request->get('image'))->resize(100, 100)->save($thumnbails_path);
                
                $pos_request = $request['position'];
                $pos_request['id'];

                if ( $pos_request['id'] ) {
                    $data->name = $data_request['name'];
                    $data->nip = $data_request['nip'];
                    $data->position_id = $pos_request['id'];
                    $data->photo = $fileName;
                    $data->photo_thumbnail = $fileName;
                    $data->course = $data_request['course'];
                    $data->save();
                } else {
                    $data->name = $data_request['name'];
                    $data->nip = $data_request['nip'];
                    $data->photo = $fileName;
                    $data->photo_thumbnail = $fileName;
                    $data->course = $data_request['course'];
                    $data->save();
                }


            } else {

                $data = Teacher::find($request->id);
                
                $data_request = $request['position'];

                if ( $data_request['id'] ) {
                    $data->name = $request['name'];
                    $data->nip = $request['nip'];
                    $data->position_id = $data_request['id'];
                    $data->course = $request['course'];
                    $data->save();
                } else {
                    $data->name = $request['name'];
                    $data->nip = $request['nip'];
                    $data->position_id = $request['position'];
                    $data->course = $request['course'];
                    $data->save();
                }


            }

            return response()->json([
                'status' => true,
                'message' => 'Success',
                'results' => $data
            ]);

        }

    }

    public function deleteData($id) {
        $teacher = Teacher::findOrFail($id);
        
        $real_path = public_path('uploads' .DIRECTORY_SEPARATOR. 'teachers' .DIRECTORY_SEPARATOR. $teacher->photo);
        $thumnbails_path = public_path('uploads' .DIRECTORY_SEPARATOR. 'teachers' .DIRECTORY_SEPARATOR.'thumbnails' .DIRECTORY_SEPARATOR. $teacher->photo);
        
        if(File::exists($real_path)) {
            File::delete($real_path);
        }
        
        if(File::exists($thumnbails_path)) {
            File::delete($thumnbails_path);
        }
        
        $teacher->delete();

        return response()->json([
            'status' => true,
            'message'=> 'Berhail',
            'results' => $thumnbails_path
        ], 200);
        
    }
}
