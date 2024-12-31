%extends('errors.layout', ['code' => 419])

%block('error')
  <h1>419</h1>
  <p>{{{ __('error.419') }}}</p>
%endblock
