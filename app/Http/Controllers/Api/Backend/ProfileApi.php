<?php

namespace App\Http\Controllers\Api\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Profile;

class ProfileApi extends Controller
{
    public function getProfile()
    {
        $profile = Profile::first();

        if ($profile) {
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'results' => $profile
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Profile still empty'
            ], 200);
        }
    }

    public function updateProfile(Request $request) {
        $profile = Profile::first();
        $profile->body = $request->body;
        $profile->save();

        if ($profile) {
            return response()->json([
                'status' => true,
                'message' => 'Success'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Profile still empty'
            ], 200);
        }
    }

    public function submitProfile(Request $request) {
        $profile = new Profile;
        $profile->body = $request;
        $profile->save();

        if ($profile) {
            return response()->json([
                'status' => true,
                'message' => 'Success'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Profile still empty'
            ], 200);
        }
    }

    public function getIntro()
    {
        $intro = Profile::find(2);

        if ($intro) {
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'results' => $intro
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Profile still empty'
            ], 200);
        }
    }

    public function updateIntro(Request $request) {
        $intro = Profile::find(2);
        
        $intro->body = $request->intro;
        $intro->save();
        
        if ($intro) {
            return response()->json([
                'status' => true,
                'message' => 'Success'
            ], 200);
        }
    }
}
