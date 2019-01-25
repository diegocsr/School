<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ContactTableSeeder::class);
        $this->call(ProfileTableSeeder::class);
        $this->call(TeacherTableSeeder::class);
        $this->call(AchievementTableSeeder::class);
        $this->call(ProgramTableSeeder::class);
        $this->call(StudentTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(EventTableSeeder::class);
        $this->call(AlbumTableSeeder::class);
        $this->call(GalleryTableSeeder::class);
    }
}
