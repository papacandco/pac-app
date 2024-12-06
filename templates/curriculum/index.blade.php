@extends('layouts.app', ['active' => 'curriculum'])

@section('title', __('curriculum.full_title'))

@section('seo')
  @include('partials.seo', [
    'title'         => __('curriculum.title'),
    'description'   => __('curriculum.description')
  ])
@endsection

@section('content')
@include('curriculum.partials.header')
@include('partials.ads')
<section class="container">
  <div class="row">
    <div class="col-sm-12" style="margin-top: 10px;">
      <ul class="breadcrumb">
        <li><a href="{{ route('index') }}">Home</a></li>
        <li class="active">Formations</li>
      </ul>
      <div class="row">
        @forelse($curriculums as $curriculum)
          @include('curriculum.partials.curriculum', ['curriculum' => $curriculum])
        @empty
          @include('partials.no-data', ['message' => __('curriculum.no_data')])
        @endforelse
      </div>
    </div>
    <aside class="col-xs-12 visible-xs" style="margin-top: 10px;">
      @include('layouts.content-sidebar', ['class' => 'nav-pills'])
    </aside>
  </div>
</section>
@endsection
