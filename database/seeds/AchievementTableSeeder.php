<?php

use Illuminate\Database\Seeder;
use App\Models\Achievement;

class AchievementTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $achievement = new Achievement();
        $achievement->title = 'Juara 1 Lomba Cerdas Cermat Kota';
        $achievement->description = '<h1>Tentang lomba</h1>';
        $achievement->rank = 'Juara 1';
        $achievement->slug = str_slug('Juara 1 Lomba Cerdas Cermat Kota');
        $achievement->status = true;
        $achievement->name = 'Armando Bagaskara';
        $achievement->image = 'default-achievement.jpg';
        $achievement->image_thumbnail = 'default-achievement-min.jpg';
        $achievement->save();
    }
}
