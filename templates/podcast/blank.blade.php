@extends('layouts.app', ['active' => 'podcast'])

@section('title', __('podcast.title'))

@section('content')
@include('podcast.partials.header')
@include('partials.ads')
<section class="container">
  <div class="row">
    <aside class="col-sm-2 hidden-xs" style="margin-top: 10px;">
      @include('layouts.content-sidebar', ["author_product_route" => "podcast"])
    </aside>
    <section class="col-sm-8" style="margin-top: 5px;">
      <ul class="breadcrumb">
        <li><a href="{{ route('index') }}">Home</a></li>
        <li class="active">Podcosts</li>
      </ul>
      <div class="row text-center">
        @include('partials.no-data', ['message' => __('podcast.no_data_calendar')])
      </div>
    </section>
    <aside class="col-sm-2 col-xs-12 visible-xs" style="margin-top: 10px; margin-bottom: 10px">
      @include('layouts.content-sidebar', ['class' => 'nav-pills'])
    </aside>
  </div>
</section>
@endsection
