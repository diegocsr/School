<?php

use Illuminate\Database\Seeder;
use App\Models\Album;

class AlbumTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list = ['Lomba', 'Upacara'];
        
        $i = 0;
        foreach ($list as $value) {
            $album = new Album();
            $album->name = $value;
            $album->save();
            $i++;
        }
    }
}
