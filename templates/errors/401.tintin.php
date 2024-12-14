%extends('errors.layout', ['code' => 401])

%block('error')
  <h1>401</h1>
  <p>{{{ __('error.401') }}}</p>
%endsection
