%extends('layouts.app', ['active' => 'tutorial'])

%block('title', __('tutorial.title'))

%block('style')
  %include('partials.spinner')
%endsection

%block('description')
  <meta name="description" content="{{ __('tutorial.title') }}">
  <meta name="author" content="Franck DAKIA">
%endsection

%block('seo')
  %include('partials.seo', [
    'title'         => __('tutorial.title'),
    'description'   => __('tutorial.description'),
    'image'         => app_env('APP_URL'). "/img/brand/logo.png",
  ])
%endsection

%block('content')
%include('tutorial.partials.header')
%include('partials.ads')
<section class="container">
  <div class="row">
    <section class="col-sm-12" style="margin-top: 10px;">
      <ul class="breadcrumb">
        <li><a href="{{ route('index') }}">Home</a></li>
        <li class="active">Tutoriels</li>
      </ul>
      <div class="row">
        %forelse($tutorials->items() as $tutorial)
          %include('tutorial.partials.thumb', ['size' => 4, 'tutorial' => $tutorial])
        %empty
          %include('partials.no-data', ['message' => __('tutorial.no_data')])
        %endforelse
        %if ($tutorials->hasPages())
          <div id="tutorial-root"></div>
        %endif
      </div>
      {## <div class="row hidden">
        <div class="col-sm-12 text-left">
          {{ $tutorials->links() }}
        </div>
      </div> ##}
    </section>
    <aside class="col-xs-12 visible-xs" style="margin-top: 10px;">
      %include('layouts.content-sidebar', ['class' => 'nav-pills'])
    </aside>
  </div>
</section>
%endsection

%block('script')
  %if ($tutorials->hasPages())
  <script src="/js/react/tutorial.js"></script>
  %endif
%endsection
