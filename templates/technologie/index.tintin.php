%extends('layouts.app', ['active' => 'tutorial'])

%block('title', 'Technologie - '.$technologie->title)

%block('description')
<meta name="description" content="{{ $technologie->title }}">
<meta name="author" content="Franck DAKIA">
%endsection

%block('seo')
  %include('partials.seo', [
    'title'         => $technologie->title,
    'description'   => $technologie->description,
    'image'         => $technologie->cover
  ])
%endsection

%block('style')
  <style type="text/css">
    %auth
      %if (auth()->user()->theme)
      .navbar-default .navbar-nav > .active > a {
        color: #fff !important;
        background-color: #282828 !important;
        font-weight: bold;
      }
      %else
      .navbar-default .navbar-nav > .active > a {
        color: #151515;
        background-color: #eee;
        font-weight: bold;
      }
      %endif
    %else
      .navbar-default .navbar-nav > .active > a {
        color: #151515;
        background-color: #eee;
        font-weight: bold;
      }
    %endauth
  </style>
%endsection

%block('content')
%include('partials.ads')
%include('technologie.partials.header')
<section class="container">
  <div class="row">
    <aside class="col-sm-3 hidden-xs" style="margin-top: 10px;">
      %include('layouts.content-sidebar', ['sidebar_active' => $technologie->slug])
    </aside>
    <section class="col-sm-9" style="margin-top: 10px;">
      <ul class="breadcrumb">
        <li><a href="{{ route('index') }}">Home</a></li>
        <li class="active">{{ $technologie->title }}</li>
      </ul>
      <div class="row">
        %forelse($technologie->tutorials as $tutorial)
          %include('tutorial.partials.thumb', [
            'size' => 6,
            'tutorial' => $tutorial
          ])
        %empty
          %include('partials.no-data', ['message' => __('tutorial.no_data')])
        %endforelse
      </div>
    </section>
    <aside class="col-sm-3 visible-xs" style="margin-top: 10px;">
      %include('layouts.content-sidebar', ['class' => 'nav-pills', 'sidebar_active' => $technologie->slug])
    </aside>
  </div>
</section>
%endsection
