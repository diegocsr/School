<?php

use Illuminate\Database\Seeder;
use App\Models\Contact;

class ContactTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contact = new Contact();
        $contact->name = 'SDN 1 Karangkobar Banjarnegara';
        $contact->address = 'Jl Wanayasa-Karangkobar, Karangkobar, Wetan, Karangkobar, Banjarnegara, Jawa Tengah 53453';
        $contact->phone = '(024) 7576575';
        $contact->accreditation = 'A';
        $contact->email = 'sdn1-karangkobar@gmail.com';
        $contact->fax = '(024) 123565';
        $contact->nisn = '131231232154';
        $contact->save();
    }
}
