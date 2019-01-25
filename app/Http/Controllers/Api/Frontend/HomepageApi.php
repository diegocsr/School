<?php

namespace App\Http\Controllers\Api\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Program;
use App\Models\Event;
use App\Models\Profile;
use App\Models\Contact;
use App\Helpers\Helper;

class HomepageApi extends Controller
{
    public function getProgram() {
        $program = Program::get();

        if ($program) {
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'results' => $program
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Achievement still empty'
            ], 200);
        }
    }

    public function getAchievement() {
        $achievements = Achievement::orderBy('achievements.created_at', 'desc')->take(3)->get();

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

    public function getEvents() {
        $main = Event::with(['Category' => function($q) {
            $q->select('categories.*');
        }])->orderBy('events.created_at', 'desc')->take(1)->first();

        $main->photo_thumbnail = Helper::getThumbnailEvent($main);
        $main->photo = Helper::getImageEvent($main);

        $another = Event::with(['Category' => function($q) {
            $q->select('categories.*');
        }])->orderBy('events.created_at', 'desc')->skip(1)->take(4)->get();

        foreach ($another as $content) {
            $content->photo_thumbnail = Helper::getThumbnailEvent($content);
            $content->photo = Helper::getImageEvent($content);
        }

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'main' => $main,
            'another' => $another
        ], 200);

    }

    public function getIntro() {
        $profile = Profile::find(2);

        if ($profile) {
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'results' => $profile->body
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Achievement still empty'
            ], 200);
        }
    }

    public function getHeader() {
        $main = Event::with(['Category' => function($q) {
            $q->select('categories.*');
        }])->orderBy('events.created_at', 'desc')->take(1)->first();

        $main->photo_thumbnail = Helper::getThumbnailEvent($main);
        $main->photo = Helper::getImageEvent($main);

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'results' => $main
        ], 200);

    }

    public function schoolInfo() {
        $contact = Contact::find(1)->first();

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'title' => $contact->name,
            'address' => $contact->address,
            'phone' => $contact->phone,
            'fax' => $contact->fax,
            'email' => $contact->email
        ], 200);

    }
}
