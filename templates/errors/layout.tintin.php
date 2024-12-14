%extends('layouts.app', ['active' => '#', 'isolate' => true, 'body_class' => 'bg-image', 'without_footer' => true])

%block('title', $code ?? 'Error')

%block('content')
  <div class="container" style="padding: 70px;">
    <div class="row">
      <div class="text-center col-sm-offset-3 col-sm-6 col-xs-12" style="padding-top: 10px; padding: 50px">
        %yield('error')
        <br/>
        <a href="/"><i class="fa fa-arrow-left text-blue"></i></a>
      </div>
    </div>
  </div>
%endsection
