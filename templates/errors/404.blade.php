@extends('errors.layout', ['code' => 404])

@section('error')
  <h1>404</h1>
  <p>{!! __('error.404') !!}</p>
@endsection
