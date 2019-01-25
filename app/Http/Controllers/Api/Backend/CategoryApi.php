<?php

namespace App\Http\Controllers\Api\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryApi extends Controller
{
    public function getCategory(){
        $categorys = Category::all();
        if ($categorys) {
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'results' => $categorys
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'category still empty'
            ], 200);
        }
    }

    public function storeData(Request $request){
        $validator = Validator::make($request->all(), [
            'data.name' => 'required|string'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'error' => 'validation',
                'message'=>$validator->errors()
            ]);

        } else {
            $categorys = new Category;
            $categorys->name = $request->data['name'];
            $categorys->save();
        };
          
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'results' => $categorys
            ], 200);
        }
    
    public function updateData(Request $request) {

        $validator = Validator::make($request->all(), [
            'data.name' => 'required|string'
        ]);    
        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'error' => 'validation',
                'message'=>$validator->errors()
            ]);

        } else {
            $data = Category::find($request->data['id']);
            $data->name = $request->data['name'];
            $data->save();
        };           
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'results' => $data
            ], 200);
    }
    
    public function deleteData($id) {
        $category = Category::findOrFail($id);
       
        $category->delete();

        return response()->json([
            'status' => true,
            'message'=> 'Success'
        ], 200);
        
    }
}
