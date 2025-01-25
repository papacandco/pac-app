%if($form_curriculum)
  <div class="container-fluid cirruculum-header-bg-color" style="padding: 10px;">
    <div class="container" style="padding-top: 0;">
      <div class="row">
        <div class="col-sm-9" id="curriculum-video-container">
          %include('partials.video', ['url' => $tutorial->video, 'mode' => 'video', 'poster' => $tutorial->cover])
        </div>
        <div class="col-sm-3 shadow-sm">
          %include("tutorial.partials.curriculm-tutorials")
        </div>
      </div>
    </div>
  </div>
%endif
