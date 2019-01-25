<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Profil;
use App\Models\Teacher;
use App\Models\Category;
use App\Models\Event;
use App\Models\Position;
use App\Models\Achievement;
use App\Models\Gallery;
use App\Models\Album;
use App\Helpers\Helper;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('backend.dashboard.index');
    }

    public function profile()
    {
        return view('backend.profile.index');
    }

    public function teacher()
    {
        return view('backend.teacher.index');
    }
    public function program()
    {
        return view('backend.program.index');
    }
    public function student()
    {
        return view('backend.student.index');
    }

    public function achievement()
    {
        return view('backend.achievement.index');
    }
    
    public function addAchievement()
    {
        return view('backend.achievement.create');
    }
    
    public function updateAchievement($slug)
    {
        $achievement = Achievement::where('slug', $slug)->first();

        $achievement->image_thumbnail = Helper::getThumbnailAchievement($achievement);
        $achievement->image = Helper::getImageAchievement($achievement);

        return view('backend.achievement.update')->with('data', $achievement);
    }

    public function event()
    {
        return view('backend.event.index');
    }

    public function addEvent()
    {
        return view('backend.event.create');
    }

    public function updateEvent($slug)
    {
        $event = Event::where('slug', $slug)->with(['Category' => function($q) {
            $q->select('categories.*');
        }])->first();

        $event->photo_thumbnail = Helper::getThumbnailEvent($event);
        $event->photo = Helper::getImageEvent($event);
        
        return view('backend.event.update')->with('event', $event);
    }

    public function showEvent($slug)
    {
        $event = Event::where('slug', $slug)->with(['Category' => function($q) {
            $q->select('categories.*');
        }])->first();

        $event->photo_thumbnail = Helper::getThumbnailEvent($event);
        $event->photo = Helper::getImageEvent($event);
        
        return view('backend.event.show')->with('event', $event);
    }

    public function account()
    {
        return view('backend.account.index');
    }

    public function category()
    {
        return view('backend.category.index');
    }

    public function albums() {
        return view('backend.gallery.album');
    }

    public function detailGallery($id) {
        $galleries = Gallery::where('album_id', $id)->with('album')->get();

        foreach ($galleries as $content) {
            $content->image_thumbnail = Helper::getThumbnailGallery($content);
            $content->image = Helper::getImageGallery($content);
        }
        
        return view('backend.gallery.gallery', compact('id', 'galleries'));
    }
}
