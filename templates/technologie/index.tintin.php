%extends('layouts.app', ['active' => 'tutorial'])

%block('title', 'Technology - '.$technologie->title)

%block('description')
  <meta name="description" content="{{ $technologie->title }}">
  <meta name="author" content="Franck DAKIA">
%endblock

%block('seo')
  %include('partials.seo', ['title' => $technologie->title, 'description' => $technologie->description, 'image' => $technologie->cover])
%endblock

%block('style')
  %auth
    %if(auth()->user()->theme)
      <style type="text/css">
        .navbar-default .navbar-nav > .active > a {
          color: #fff !important;
          background-color: #282828 !important;
          font-weight: bold;
        }
      </style>
    %else
      <style type="text/css">
        .navbar-default .navbar-nav > .active > a {
          color: #151515;
          background-color: #eee;
          font-weight: bold;
        }
      </style>
    %endif
  %else
    <style type="text/css">
      .navbar-default .navbar-nav > .active > a {
        color: #151515;
        background-color: #eee;
        font-weight: bold;
      }
    </style>
  %endauth
%endblock

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
        %loop($technologie->tutorials as $tutorial)
          %include('tutorial.partials.thumb', [
            'size' => 6,
            'tutorial' => $tutorial
          ])
        %endloop
        %if(count($technologie->tutorials) > 0)
          %include('partials.no-data', ['message' => __('tutorial.no_data')])
        %endif
      </div>
    </section>
    <aside class="col-sm-3 visible-xs" style="margin-top: 10px;">
      %include('layouts.content-sidebar', ['class' => 'nav-pills', 'sidebar_active' => $technologie->slug])
    </aside>
  </div>
</section>
%endblock
