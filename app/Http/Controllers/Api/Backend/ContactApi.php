<?php

namespace App\Http\Controllers\Api\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;

class ContactApi extends Controller
{
    public function getContact() {
        $contact = Contact::first();

        if (!$contact) {
            return response()->json([
                'status' => false,
                'message' => 'Error'
            ], 200);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'results' => $contact
            ], 200);
        }
    }

    public function updateContact(Request $request) {

        $request->validate([
            'name' => 'string',
            'address' => 'string',
            'phone' => 'string',
            'accreditation' => 'string',
            'email' => 'string',
            'nisn' => 'string',
            'fax' => 'string'
        ]);

        $contact = Contact::find($request->id);
        $contact->name = $request->name;
        $contact->address = $request->address;
        $contact->phone = $request->phone;
        $contact->accreditation = $request->accreditation;
        $contact->email = $request->email;
        $contact->nisn = $request->nisn;
        $contact->fax = $request->fax;
        $contact->save();

        if (!$contact) {
            return response()->json([
                'status' => false,
                'message' => 'Error get contact data'
            ], 200);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'results' => $contact
            ], 200);
        }
    }
}
