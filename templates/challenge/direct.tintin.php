%extends('layouts.app', [
'active' => false,
'isolate' => true
])

%block('title', $challenge->title)

%block('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.0.3/styles/monokai-sublime.min.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.0.3/highlight.min.js">
</script>
%endsection

%block('content')
<div class="container-fluid bg-primary video-mobile min-vh-100"
  style="padding: 30px; padding-top: 0px;">
  <div class="row no-gutters">
    <div class="col-sm-12">
      <div class="pull-right" style="position: relative; top: 8px;">
        %include('partials.brand')
      </div>
      <h3 style="font-size: 24px; display: inline-block">#{{ $challenge->id }} {{ $challenge->title }}</h3>
      <p class="text-muted">
        {{ $challenge->description }}
      </p>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-9" id="curriculum-video-container">
      %include('partials.video', ['url' => $challenge->video, 'mode' => 'video'])
    </div>
    <div class="col-sm-3">
      <div class="row" id="curriculum-video-list"
        style="overflow-y: scroll; padding: 5px; padding-bottom: 10px; padding-top: 20px;">
        %foreach(range(0, 10) as $item)
        <div class="col-sm-12" id="curriculum-video">
          %include('challenge.partials.message')
        </div>
        %endforeach
      </div>
    </div>
  </div>
</div>
%endsection
