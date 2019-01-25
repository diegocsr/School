<?php

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\Position;

class TeacherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $pos = ['Guru', 'Kepala Sekolah', 'Karyawan'];

        $i = 0;
        foreach ($pos as $key => $value) {
            $data = new Position();
            $data->position = $value;
            $data->save();
            $i++;
        }

        $teacher = new Teacher();
        $teacher->name = 'Drs. H Literzet Sobri, M. Pd';
        $teacher->nip = '199630046798679';
        $teacher->photo = 'default-avatar.jpg';
        $teacher->photo_thumbnail = 'default-avatar-min.jpg';
        $teacher->course = 'Matematika';
        $teacher->position_id = 1;
        $teacher->save();
    }
}
