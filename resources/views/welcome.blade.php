@extends('layouts.app')

@section('content')
  <div class="container text-center">
    <h2>Contribute to the Cheshire Maverick's Dinner</h2>
    <h5 class="mb-5">Upload your favourite Mav images!</h5>
    <file-upload-button api-url="{{ url('api') }}"
                        :button="{text: 'Upload Images'}">
    </file-upload-button>
  </div>
@endsection
