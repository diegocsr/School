<?php

use Illuminate\Database\Seeder;
use App\Models\Program;

class ProgramTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list = ['sekolah gratis', 'sekolah gratissekolah gratis', 'sekolah gratis sekolah gratis sekolah gratis'];
        
        $i = 0;
        foreach ($list as $key => $value) {
            $program = new Program();
            $program->description = $value;
            $program->save();
            $i++;
        }
    }
}
