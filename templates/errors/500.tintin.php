%extends('errors.layout', ['code' => 500])

%block('error')
  <h1>500</h1>
  <p>{{{ __('error.500') }}}</p>
%endsection
