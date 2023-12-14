<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    protected $company;

    public function usercompanies()
    {
        return Company::forUser(auth()->user())->orderBy('name')->pluck('name', 'id');
    }

    public function index()
    {
        // dd(Auth::user());
        // if (Auth::check()) {
        //     dd('sign in');
        // } else {
        //     dd('guest');
        // }

        $companies = $this->userCompanies();
        // DB::enableQueryLog();                    // enable query debugging
        
        $contacts = Contact::allowedTrash()
            ->allowedSorts(['first_name', 'last_name', 'email'], "-id")
            ->AllowedFilters('company_id')
            ->allowedSearch('first_name', 'last_name', 'email')
            ->forUser(auth()->user())
            ->paginate(10);
        // dump(DB::getQueryLog());                 // for debugging
        return view('contacts.index', compact('contacts', 'companies'));
    }

    public function create() 
    {
        $companies = $this->userCompanies();
        $contact = new Contact();
        return view('contacts.create', compact('companies', 'contact'));
    }

    public function store(ContactRequest $request)
    {
        $request->user()->contacts()->create($request->all());

        return redirect()->route('contacts.index')->with('message', 'Contact has been added successfully');
    }

    public function show(Contact $contact) 
    {
        return view('contacts.show')->with('contact', $contact);
    }

    public function edit(Contact $contact) 
    {
        $companies = $this->userCompanies();
        return view('contacts.edit', compact('companies', 'contact'));
    }

    public function update(ContactRequest $request, Contact $contact)
    {
        $contact->update($request->all());

        return redirect()->route('contacts.index')->with('message', 'Contact has been updated successfully');
    }

    public function destroy(Contact $contact) 
    {
        $contact->delete();
        $redirect = request()->query('redirect');
        return ($redirect ? redirect()->route($redirect) : back())
            ->with('message', 'Contact has been moved to trash')
            ->with('undoRoute', $this->getUndoRoute('contacts.restore', $contact));
    }

    public function restore(Contact $contact) 
    {
        $contact->restore();
        return back()
            ->with('message', 'Contact has been restored from trash')
            ->with('undoRoute', $this->getUndoRoute('contacts.destroy', $contact));
    }

    protected function getUndoRoute($name, $resource)
    {
        return request()->missing('undo') ? route($name, [$resource->id, 'undo' => true]) : null;
    }

    public function forceDelete(Contact $contact) 
    {
        $contact->forceDelete();
        return back()
            ->with('message', 'Contact has been removed permanently');
    }
}
