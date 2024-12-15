<div id="waveform" data-source="{{ $source }}" style="position: relative;">
  <div class="progress" id="progress-container" style="width: 100%; height: 5px; position: absolute; top: 5px; left: 0; right: 0;">
    <div class="progress-bar progress-bar-info" id="progress" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%; height: 2px">
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-12 text-center">
    <button style="font-size: 8px" class="btn disabled btn-danger btn-sm" id="stop-btn"><i class="fa fa-stop"></i></button>
    &nbsp;
    <button class="btn disabled btn-primary btn-sm" style="font-size: 8px" id="pay-btn"><i class="fa fa-play"></i></button>
    &nbsp;
    <button style="font-size: 8px" class="btn disabled btn-primary btn-sm" id="mute-btn"><i class="fa fa-volume-up"></i></button>
    %auth("web")
      &nbsp;
      <button style="font-size: 8px" class="btn btn-primary btn-sm" id="bookmark-btn" data-target="#add-bookmark-modal" data-toggle="modal"><i class="fa fa-bookmark"></i></button>
    %endauth
  </div>
</div>
