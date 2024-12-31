%extends('errors.layout', ['code' => 403])

%block('error')
  <h1>403</h1>
  <p>{{{ __('error.403') }}}</p>
%endblock
