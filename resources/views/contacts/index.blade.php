@extends('layouts.main')

@section('title', 'Contact App | All contacts')

@section('content')
  <main class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-title">
              <div class="d-flex align-items-center">
                <h2 class="mb-0">All Contacts</h2>
                <div class="ml-auto">
                  <a href="{{ route('contacts.create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add New</a>
                </div>
              </div>
            </div>
            <div class="card-body">
              @include('contacts._filter')
              @if ($message = session('message'))
                  <div class="alert alert-success">
                    {{ $message }}
                    @if ($undoRoute = session('undoRoute'))
                      <form action="{{ $undoRoute }}" method="POST" style="display: inline">
                        @csrf
                        @method('delete')
                        <button class="btn alert-link">Undo</button>
                      </form>
                    @endif
                  </div>
              @endif
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Company</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody> <!-- if child view requires variables that are available in parent view, use forelse -->
                  @forelse ($contacts as $index => $contact)
                    @include('contacts._contact', ['contact' => $contact, 'index' => $index])
                    @empty
                    @include('contacts._empty')
                  @endforelse
                  {{-- @each('contacts._contact', $contacts, 'contact', 'contacts._empty') <!-- render '_contact' for each 'contact' in $contacts, IF empty show '_empty' --> --}}
                </tbody>
              </table> 

              {{ $contacts->withQueryString()->links() }}  <!--current method allows all queries in browser, to specify which queries are allowed > appends(request()->only('orderBy', 'q')) -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection