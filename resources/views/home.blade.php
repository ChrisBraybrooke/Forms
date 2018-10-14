@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                  Welcome, {{ auth()->user()->name }}

                  <a class="account_logout" href="{{ route('logout') }}"
                     onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">Logout
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                  </form>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>See images that have been uploaded below, they are loaded in batches of 15. Please click "Load More" to load the next set of images.</p>

                    <p>You can press <i class="text-primary far fa-star"></i> to save as a favourite.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <gallery-index api-url="{{ url('api') }}">
        </gallery-index>
      </div>
    </div>
</div>
@endsection
