<?php

use Illuminate\Database\Seeder;
use App\Models\Gallery;

class GalleryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gallery = new Gallery();
        $gallery->name = 'Foto SD';
        $gallery->image = 'default-gallery.jpg';
        $gallery->image_thumbnail = 'default-gallery-min.jpg';
        $gallery->album_id = 1;
        $gallery->save();

        $gallery1 = new Gallery();
        $gallery1->name = 'Foto Upacara';
        $gallery1->image = 'default-gallery.jpg';
        $gallery1->image_thumbnail = 'default-gallery-min.jpg';
        $gallery1->album_id = 1;
        $gallery1->save();

        $gallery2 = new Gallery();
        $gallery2->name = 'Foto SD';
        $gallery2->image = 'default-gallery.jpg';
        $gallery2->image_thumbnail = 'default-gallery-min.jpg';
        $gallery2->album_id = 1;
        $gallery2->save();

        $gallery3 = new Gallery();
        $gallery3->name = 'Foto Upacara';
        $gallery3->image = 'default-gallery.jpg';
        $gallery3->image_thumbnail = 'default-gallery-min.jpg';
        $gallery3->album_id = 1;
        $gallery3->save();
    }
}
