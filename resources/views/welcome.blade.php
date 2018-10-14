@extends('layouts.app')

@section('content')
  <div class="container text-center">
    <p>
      <a href="{{ route('login') }}" title="Login">Login</a> |
      <a href="{{ route('register') }}" title="Register">Register</a>
    </p>
    <h2>Contribute to the Cheshire Maverick's Dinner</h2>
    <h5 class="mb-5">Upload your favourite Mav images!</h5>
    <file-upload-component api-url="{{ url('api') }}"></file-upload-component>
    <p>Images will be stored and used at the event. By uploading, you are giving consent for the images to be used.</p>
    <p>Powered by <a href="https://purplemountmedia.com" tile="Purple Mountain">Purple Mountain</a>, Wilmslow based Web Design & Build.</p>
  </div>
@endsection
