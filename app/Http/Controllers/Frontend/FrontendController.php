<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Achievement;
use App\Models\Contact;
use App\Models\Event;
use App\Models\Album;
use App\Models\Position;
use App\Models\Gallery;
use App\Models\Profile;
use App\Models\Program;
use App\Models\Student;
use App\Models\Teacher;

class FrontendController extends Controller
{
    public function showTeacher() {
        $teachers = Teacher::orderBy('name', 'asc')->get();
        
        foreach ($teachers as $content) {
            $content->photo_thumbnail = Helper::getThumbnailTeacher($content);
            $content->photo = Helper::getPhotoTeacher($content);
        }

        $achievements = Achievement::orderBy('created_at', 'desc')
                                    ->select('achievements.slug', 'achievements.title', 'achievements.image_thumbnail', 'achievements.created_at')->take(4)->get();
        
        foreach ($achievements as $content) {
            $content->image_thumbnail = Helper::getThumbnailAchievement($content);
        }

        $events = Event::orderBy('created_at', 'desc')
                        ->select('events.slug', 'events.title', 'events.photo_thumbnail', 'events.created_at')->take(4)->get();
        
        foreach ($events as $content) {
            $content->photo_thumbnail = Helper::getThumbnailEvent($content);
        }

        return view('frontend.teachers.index', compact('achievements', 'events', 'teachers'));

    }

    public function schoolProfile() {
        $profile = Profile::first();

        $achievements = Achievement::orderBy('created_at', 'desc')
                                    ->select('achievements.slug', 'achievements.title', 'achievements.image_thumbnail', 'achievements.created_at')->take(4)->get();
        
        foreach ($achievements as $content) {
            $content->image_thumbnail = Helper::getThumbnailAchievement($content);
        }

        $events = Event::orderBy('created_at', 'desc')
                        ->select('events.slug', 'events.title', 'events.photo_thumbnail', 'events.created_at')->take(4)->get();
        
        foreach ($events as $content) {
            $content->photo_thumbnail = Helper::getThumbnailEvent($content);
        }

        return view('frontend.homepage.profile', compact('profile', 'achievements', 'events'));
    }

    public function showStudent() {
        
    }

    public function showAchievement() {
        $achievements = Achievement::get();
        
        foreach ($achievements as $content) {
            $content->image_thumbnail = Helper::getThumbnailAchievement($content);
            $content->image = Helper::getImageAchievement($content);
        }

        return view('frontend.achievement.index', compact('achievements'));
    }

    public function showDetailAchievement($slug) {
        
        $detail = Achievement::where('slug', $slug)->first();

        $detail->image = Helper::getImageAchievement($detail);
        
        $achievements = Achievement::orderBy('created_at', 'desc')
                                    ->select('achievements.slug', 'achievements.title', 'achievements.image_thumbnail', 'achievements.created_at')->take(4)->get();
        
        foreach ($achievements as $content) {
            $content->image_thumbnail = Helper::getThumbnailAchievement($content);
        }

        $events = Event::orderBy('created_at', 'desc')
                        ->select('events.slug', 'events.title', 'events.photo_thumbnail', 'events.created_at')->take(4)->get();
        
        foreach ($events as $content) {
            $content->photo_thumbnail = Helper::getThumbnailEvent($content);
        }

        return view('frontend.achievement.detail', compact('achievements', 'events', 'detail'));
    }

    public function showEvent() {
        $events = Event::get();
        
        foreach ($events as $content) {
            $content->photo_thumbnail = Helper::getThumbnailEvent($content);
            $content->photo = Helper::getImageEvent($content);
        }

        return view('frontend.events.index', compact('events'));
    }

    public function detailEvent($slug) {
        $detail = Event::where('slug', $slug)->first();

        $detail->photo = Helper::getImageEvent($detail);
        
        $achievements = Achievement::orderBy('created_at', 'desc')
                                    ->select('achievements.slug', 'achievements.title', 'achievements.image_thumbnail', 'achievements.created_at')->take(4)->get();
        
        foreach ($achievements as $content) {
            $content->image_thumbnail = Helper::getThumbnailAchievement($content);
        }

        $events = Event::orderBy('created_at', 'desc')
                        ->select('events.slug', 'events.title', 'events.photo_thumbnail', 'events.created_at')->take(4)->get();
        
        foreach ($events as $content) {
            $content->photo_thumbnail = Helper::getThumbnailEvent($content);
        }

        return view('frontend.events.detail', compact('achievements', 'events', 'detail'));
    }

    public function showAlbum() {
        $albums = Album::all();
        $random = Gallery::inRandomOrder()->first();

        $random->image = Helper::getImageGallery($random);

        return view('frontend.galleries.index', compact('albums', 'random'));   
    }

    public function detailAlbum($id) {
        $album_name = Album::find($id);
        $galleries = Gallery::where('album_id', $id)->orderBy('created_at', 'desc')->paginate(6);

        foreach ($galleries as $content) {
            $content->image = Helper::getImageGallery($content);
            $content->image_thumbnail = Helper::getThumbnailGallery($content);
        }

        return view('frontend.galleries.detail', compact('galleries', 'album_name'));
    }
}
