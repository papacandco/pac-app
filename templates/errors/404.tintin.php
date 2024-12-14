%extends('errors.layout', ['code' => 404])

%block('error')
  <h1>404</h1>
  <p>{{{ __('error.404') }}}</p>
%endsection
