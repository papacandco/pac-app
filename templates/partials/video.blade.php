@php
if (!isset($poster)) {
  $poster = false;
}
@endphp
<div class="row no-gutters">
<!--  embed-responsive embed-responsive-16by9 bg-blue  -->
  <div class="col-sm-12 col-xs-12 shadow-lg" style="{{ $style ?? '' }} padding: 0px;">
    @if($mode == 'video-raw')
      <video id="player bg-blue" src="{{ $url }}" class="embed-responsive-item" preload="none" controls></video>
    @elseif($mode == 'audio')
      <audio id="player bg-blue" src="{{ $url }}" class="embed-responsive-item" preload="none" style="width: 100%" controls></audio>
    @else
      <div class="bg-blue plyr__video-embed video-player shadow-lg" {!! $poster ? 'data-poster="'.$poster.'"' : '' !!}>
        <iframe class="shadow-lg" src="{{ $url }}?rel=0" frameborder="0" allowtransparency allowfullscreen></iframe>
      </div>
    @endif
  </div>
</div>
