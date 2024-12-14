%extends('errors.layout', ['code' => 401])

%block('error')
  <h1>{{{ $challenge->diffusionIcon() }}} Live</h1>
  <p>
    Désolé, le challenge n'est pas encore commencé. <a href="/" style="text-decoration: underline;">Papac & Co.</a>
  </p>
%endsection
