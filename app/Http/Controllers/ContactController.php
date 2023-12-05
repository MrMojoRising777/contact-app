<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
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
        // $contacts = Contact::latest()->paginate(10);
        $contactsCollection = Contact::latest()->get();
        $perPage = 10;
        $currentPage = request()->query('page', 1);
        $items = $contactsCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->values();
        $total = $contactsCollection->count();
        $contacts = new LengthAwarePaginator($items, $total, $perPage, $currentPage, [
            'path' => request()->url(),
            'query' => request()->query()
        ]);
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
