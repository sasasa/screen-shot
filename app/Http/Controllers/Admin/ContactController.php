<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        return view('admin.contact.index');
    }

    public function show(Contact $contact)
    {
        return view('admin.contact.show', [
            'contact' => $contact,
        ]);
    }

    public function update(Contact $contact, Request $request)
    {
        $contact->is_done = !$contact->is_done;
        $contact->save();
        return redirect()->route('system_admin.contacts.show', [
            'contact' => $contact,
        ]);
    }
}
