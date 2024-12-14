%extends('errors.layout', ['code' => 500])

%block('error')
  <h2>{{ ucfirst($provider) }}</h2>
  <p>{{{ __('error.oauth', ['url' => route('login')]) }}}</p>
%endsection
