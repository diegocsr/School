<?php

use Illuminate\Database\Seeder;
use App\Models\Event;
class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $event = new Event();
        $event->title = 'Judul event sekolah';
        $event->slug = str_slug('Judul event sekolah');
        $event->body = '<h1>Content event</h1>';
        $event->photo = 'default-event.jpg';
        $event->photo_thumbnail = 'default-event-min.jpg';
        $event->status = false;
        $event->category_id = 1;
        $event->save();
    }
}
