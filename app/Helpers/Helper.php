<?php

namespace App\Helpers;
use File;

class Helper {
  /**
   * Helper for embed thumbnail url for teacher
   */
  public static function getThumbnailTeacher($content)
  {
    $display_path = '/uploads/teachers/thumbnails/';
    if ($content) {
      $path = public_path().$display_path;
      if(!File::exists($path.$content->photo_thumbnail)) {
          return '/uploads/teachers/defaults/default-avatar-min.jpg';
      }
      return $display_path.$content->photo_thumbnail;
    } else {
      if(File::exists(public_path().'/uploads/teachers/defaults/default-avatar-min.jpg')) {
        return '/uploads/teachers/defaults/default-avatar-min.jpg';
      } else {
        return '/uploads/teachers/defaults/default-avatar-min.jpg'; 
      }
    }
  }

  /**
   * Helper for embed real photo url for teacher
   */
  public static function getPhotoTeacher($content)
  {
    $display_path = '/uploads/teachers/';
    if ($content->photo) {
      $path = public_path().$display_path;
      if(!File::exists($path.$content->photo)) {
          return '/uploads/teachers/defaults/default-avatar.jpg';
      }
      return $display_path.$content->photo;
    } else {
      if(File::exists(public_path().'/uploads/teachers/defaults/default-avatar.jpg')) {
        return '/uploads/teachers/defaults/default-avatar.jpg';
      } else {
        return '/uploads/teachers/defaults/default-avatar.jpg'; 
      }
    }
  }

  /**
   * Helper for embed thumbnail url for achievement
   */
  public static function getThumbnailAchievement($content)
  {
    $display_path = '/uploads/achievements/thumbnails/';
    if ($content) {
      $path = public_path().$display_path;
      if(!File::exists($path.$content->image_thumbnail)) {
          return '/uploads/teachers/defaults/default-achievement-min.jpg';
      }
      return $display_path.$content->image_thumbnail;
    } else {
      if(File::exists(public_path().'/uploads/achievements/defaults/default-achievement-min.jpg')) {
        return '/uploads/achievements/defaults/default-achievement-min.jpg';
      } else {
        return '/uploads/achievements/defaults/default-achievement-min.jpg'; 
      }
    }
  }

  /**
   * Helper for embed real image url for achievement
   */
  public static function getImageAchievement($content)
  {
    $display_path = '/uploads/achievements/';
    if ($content) {
      $path = public_path().$display_path;
      if(!File::exists($path.$content->image)) {
          return '/uploads/achievements/defaults/default-achievement.jpg';
      }
      return $display_path.$content->image;
    } else {
      if(File::exists(public_path().'/uploads/achievements/defaults/default-achievement.jpg')) {
        return '/uploads/achievements/defaults/default-achievement.jpg';
      } else {
        return '/uploads/achievements/defaults/default-achievement.jpg'; 
      }
    }
  }

  public static function getThumbnailEvent($content)
  {
    $display_path = '/uploads/events/thumbnails/';
    if ($content) {
      $path = public_path().$display_path;
      if(!File::exists($path.$content->photo_thumbnail)) {
          return $path;
      }
      return $display_path.$content->photo_thumbnail;
    } else {
      if(File::exists(public_path().'/uploads/events/defaults/default-event-min.jpg')) {
        return '/uploads/events/defaults/default-event-min.jpg';
      } else {
        return '/uploads/events/defaults/default-event-min.jpg'; 
      }
    }
  }

  public static function getImageEvent($content)
  {
    $display_path = '/uploads/events/';
    if ($content) {
      $path = public_path().$display_path;
      if(!File::exists($path.$content->photo)) {
          return '/uploads/achievements/defaults/default-achievement.jpg';
      }
      return $display_path.$content->photo;
    } else {
      if(File::exists(public_path().'/uploads/events/defaults/default-event.jpg')) {
        return '/uploads/events/defaults/default-event.jpg';
      } else {
        return '/uploads/events/defaults/default-event.jpg'; 
      }
    }
  }

  public static function getThumbnailGallery($content)
  {
    $display_path = '/uploads/galleries/thumbnails/';
    if ($content) {
      $path = public_path().$display_path;
      if(!File::exists($path.$content->image_thumbnail)) {
          return '/uploads/achievements/defaults/default-gallery.jpg';
      }
      return $display_path.$content->image_thumbnail;
    } else {
      if(File::exists(public_path().'/uploads/galleries/defaults/default-gallery-min.jpg')) {
        return '/uploads/galleries/defaults/default-gallery-min.jpg';
      } else {
        return '/uploads/galleries/defaults/default-gallery-min.jpg'; 
      }
    }
  }

  public static function getImageGallery($content)
  {
    $display_path = '/uploads/galleries/';
    if ($content) {
      $path = public_path().$display_path;
      if(!File::exists($path.$content->image)) {
          return '/uploads/galleries/defaults/default-gallery.jpg';
      }
      return $display_path.$content->image;
    } else {
      if(File::exists(public_path().'/uploads/galleries/defaults/default-gallery.jpg')) {
        return '/uploads/galleries/defaults/default-gallery.jpg';
      } else {
        return '/uploads/galleries/defaults/default-gallery.jpg'; 
      }
    }
  }

}