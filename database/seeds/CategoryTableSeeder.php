<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list = ['Berita', 'Pengumuman', 'Acara Sekolah'];
        
        $i = 0;
        foreach ($list as $key => $value) {
            $category = new Category();
            $category->name = $value;
            $category->save();
            $i++;
        }
    }
}
