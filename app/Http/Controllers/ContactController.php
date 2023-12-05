<?php

namespace App\Http\Controllers;

use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    protected $company;

    public function __construct(CompanyRepository $company)
    {
        $this->company = $company;
    }

    public function index()
    {
        $companies = $this->company->pluck();
        $contacts = Contact::latest()->paginate(10);
        return view('contacts.index', compact('contacts', 'companies'));
    }

    public function create() 
    {
        return view('contacts.create');
    }

    public function show($id) 
    {
        $contact = Contact::findOrFail($id);
        return view('contacts.show')->with('contact', $contact);
    }
}
