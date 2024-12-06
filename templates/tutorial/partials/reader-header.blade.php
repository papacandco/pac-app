@if ($form_curriculum)
{{--   <div class="pull-right" style="display: inline-block; position: relative; top: 10px">
    <a href="#" class="btn btn-sm btn-danger" data-target="#curriculum-sommary-modal" data-toggle="modal">Afficher la table de matière</a>
  </div> --}}
{{--   <div style="position: fixed; bottom: 10px; right: 10px; z-index: 10000">
    <a href="#" class="btn btn-sm btn-primary" data-target="#curriculum-sommary-modal" data-toggle="modal">Afficher la table des matières</a>
  </div> --}}
  <div class="container-fluid cirruculum-header-bg-color" style="padding: 10px;">
    <div class="container" style="padding-top: 0;">
      <div class="row">
        <div class="col-sm-9" id="curriculum-video-container">
          @include('partials.video', ['url' => $tutorial->video, 'mode' => 'video', 'poster' => $tutorial->cover])
        </div>
        <div class="col-sm-3 shadow-sm">
          @include("tutorial.partials.curriculm-tutorials")
        </div>
      </div>
    </div>
  </div>
@endif
