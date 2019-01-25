<?php

use Illuminate\Database\Seeder;
use App\Models\Profile;

class ProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profile = new Profile();
        $profile->body = '<h1>Hello</h1>';
        $profile->save();

        $profile = new Profile();
        $profile->body = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ac congue mi, nec ultrices ipsum. Ut nec feugiat lectus, ac finibus erat. Aliquam volutpat nunc hendrerit velit tristique luctus quis ut diam. Donec tempus mauris quis dui consequat laoreet. Vestibulum arcu sem, semper nec magna ut, dictum ultrices sapien.';
        $profile->save();
    }
}
