<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactsController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderBy('id', 'desc')->paginate(20);
        return view('home', compact('contacts'));
    }

    public function create()
    {
        if (!Auth::check()) {
            return redirect()->back()->with(['error'=>'You must be logged in to view this page']);
        }
        return view('contacts.create');
    }

    public function store(StoreContactRequest $request)
    {
        if (!Contact::create($request->validated())) {
            return redirect()->back()->with(['error'=>'Error to create contact, check the form and try again.']);
        }
        return redirect()->route('home')->with(['success'=>'Contact saved successfully']);
    }

    public function show(Contact $contact)
    {
        if (!Auth::check()) {
            return redirect()->back()->with(['error'=>'You must be logged in to view this page']);
        }
        return view('contacts.details', compact('contact'));
    }

    public function edit(Contact $contact)
    {
        if (!Auth::check()) {
            return redirect()->back()->with(['error'=>'You must be logged in to view this page']);
        }

        return view('contacts.edit', compact('contact'));
    }

    public function update(UpdateContactRequest $request, Contact $contact)
    {
        if (!$contact->fill($request->validated())->save()) {
            return redirect()->back()->with(['error'=>'Error to update contact, check the form and try again.']);
        }
        return redirect()->route('home')->with(['success'=>'Contact updated successfully']);
    }


}
