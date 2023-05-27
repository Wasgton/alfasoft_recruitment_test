<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactsController extends Controller
{
    public function index()
    {
        $contacts = Contact::paginate(20);
        return view('home', compact('contacts'));
    }

    public function store(StoreContactRequest $request)
    {
        if (!Contact::create($request->validated())) {
            return redirect()->back();
        }
        return redirect()->route('home')->with(['message'=>'Contact saved successfully']);
    }

    public function show(Contact $contact)
    {
        if (!Auth::check()) {
            return redirect()->back()->with(['error'=>'You must be logged in to view this page']);
        }
        return view('contacts.details', compact('contact'));
    }

}
