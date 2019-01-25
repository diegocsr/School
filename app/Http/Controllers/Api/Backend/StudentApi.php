<?php

namespace App\Http\Controllers\Api\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class StudentApi extends Controller
{
    public function getStudent(){
        $students = Student::orderBy('students.name')->get();
        if ($students) {
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'results' => $students
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'student still empty'
            ], 200);
        }
    }

    public function storeData(Request $request){
        $validator = Validator::make($request->all(), [
            'data.name' => 'required|string',
            'data.nis' => 'required|integer',
            'data.kelas' => 'required|string'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'error' => 'validation',
                'message'=>$validator->errors()
            ]);

        } else {
            $students = new Student;
            $students->name = $request->data['name'];
            $students->nis = $request->data['nis'];
            $students->kelas = $request->data['kelas'];
            $students->save();
        };
          
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'results' => $students
            ], 200);
        }
    
    public function updateData(Request $request) {

            $validator = Validator::make($request->all(), [
                'data.nis' => 'required|string',
                'data.name' => 'required|string',
                'data.kelas' => 'required|string'
            ]);    
            if ($validator->fails()) {

                return response()->json([
                    'status' => false,
                    'error' => 'validation',
                    'message'=>$validator->errors()
                ]);
    
            } else {
                $data = Student::find($request->data['id']);
                $data->name = $request->data['name'];
                $data->nis = $request->data['nis'];
                $data->kelas = $request->data['kelas'];
                $data->save();
            };           
                return response()->json([
                    'status' => true,
                    'message' => 'Success',
                    'results' => $data
                ], 200);
            }
    
    public function deleteData($id) {
        $student = student::findOrFail($id);
       
        $student->delete();

        return response()->json([
            'status' => true,
            'message'=> 'Berhail'
        ], 200);
        
    }
}
