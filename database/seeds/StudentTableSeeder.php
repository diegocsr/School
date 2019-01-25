<?php

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $student = Student::create([
            'name' => 'Rini',
            'nis' => 1234,
            'kelas' => 1
        ]);
        $student1 = Student::create([
            'name' => 'Roni',
            'nis' => 5343,
            'kelas' => 2
        ]);
        $student2 = Student::create([
            'name' => 'Rana',
            'nis' => 1421,
            'kelas' => 5
        ]);
    }
}
