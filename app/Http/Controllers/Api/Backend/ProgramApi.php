<?php

namespace App\Http\Controllers\Api\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Support\Facades\Validator;

class ProgramApi extends Controller
{
    public function getProgram(){
        $programs = Program::all();
        if ($programs) {
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'results' => $programs
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'program still empty'
            ], 200);
        }
    }

    public function storeData(Request $request){
        $validator = Validator::make($request->all(), [
            'data.description' => 'required|string'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'error' => 'validation',
                'message'=>$validator->errors()
            ]);

        } else {
            $programs = new program;
            $programs->description = $request->data['description'];
            $programs->save();
        };
          
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'results' => $programs
            ], 200);
        }
    
    public function updateData(Request $request) {

            $validator = Validator::make($request->all(), [
                'data.description' => 'required|string'
            ]);    
            if ($validator->fails()) {

                return response()->json([
                    'status' => false,
                    'error' => 'validation',
                    'message'=>$validator->errors()
                ]);
    
            } else {
                $data = Program::find($request->data['id']);
                $data->description = $request->data['description'];
                $data->save();
            };           
                return response()->json([
                    'status' => true,
                    'message' => 'Success',
                    'results' => $data
                ], 200);
            }
    
    public function deleteData($id) {
        $program = Program::findOrFail($id);
       
        $program->delete();

        return response()->json([
            'status' => true,
            'message'=> 'Berhail'
        ], 200);
        
    }
}
