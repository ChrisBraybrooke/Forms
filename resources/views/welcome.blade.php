@extends('layouts.app')

@section('content')
  <div class="container text-center">
    <file-upload-button api-url="{{ url('api') }}"
                        :button="{text: 'Upload Images'}">
    </file-upload-button>
  </div>
@endsection
