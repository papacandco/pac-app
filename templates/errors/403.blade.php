@extends('errors.layout', ['code' => 403])

@section('error')
  <h1>403</h1>
  <p>{!! __('error.403') !!}</p>
@endsection
