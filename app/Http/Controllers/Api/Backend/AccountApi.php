<?php

namespace App\Http\Controllers\Api\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\Achievement;
use App\Models\Event;
use App\Models\Teacher;
use App\Models\Program;


class AccountApi extends Controller
{
    public function getAccount(){
        $accounts = User::all();
        if ($accounts) {
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'results' => $accounts
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'account still empty'
            ], 200);
        }
    }
    public function resetAccount($id){
        $accounts = User::find($id);
        $accounts->password = bcrypt('password');
        $accounts->save();

        if ($accounts) {
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'results' => $accounts
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'account still empty'
            ], 200);
        }
    }
    public function storeData(Request $request){
        $validator = Validator::make($request->all(), [
            'data.name' => 'required|string',
            'data.email' => 'required|email',
            'data.password' => 'required|string'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'error' => 'validation',
                'message'=>$validator->errors()
            ]);

        } else {
            $accounts = new User;
            $accounts->name = $request->data['name'];
            $accounts->email = $request->data['email'];
            $accounts->password = bcrypt($request->data['password']);
            $accounts->save();
        };
          
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'results' => $accounts
            ], 200);
        }
    
    public function updateData(Request $request) {

            $validator = Validator::make($request->all(), [
                'data.name' => 'required|string',
                'data.email' => 'required|email',
                // 'data.password' => 'required|string'
            ]);    
            if ($validator->fails()) {

                return response()->json([
                    'status' => false,
                    'error' => 'validation',
                    'message'=>$validator->errors()
                ]);
    
            } else {
                $accounts = User::find($request->data['id']);
                $accounts->name = $request->data['name'];
                $accounts->email = $request->data['email'];
                // $accounts->password = bcrypt($request->data['password']);
                $accounts->save();
            };           
                return response()->json([
                    'status' => true,
                    'message' => 'Success',
                    'results' => $accounts
                ], 200);
            }
    
    public function deleteData($id) {
        $account = User::findOrFail($id);
       
        $account->delete();

        return response()->json([
            'status' => true,
            'message'=> 'Berhail'
        ], 200);
        
    }

    public function getTotal() {
        $achievements = Achievement::get()->count();
        $events = Event::get()->count();
        $teachers = Teacher::get()->count();
        $programs = Program::get()->count();

        return response()->json([
            'status' => true,
            'message'=> 'Success',
            'achievements' => $achievements,
            'events' => $events,
            'teachers' => $teachers,
            'programs' => $programs,
        ], 200);
    }
}
