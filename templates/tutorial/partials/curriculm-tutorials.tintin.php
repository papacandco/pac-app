<div class="row" id="curriculum-video-list" data-simplebar>
  %loop($curriculum->tutorials as $key => $element)
    <div class="col-sm-12 curriculum-video-item" id="curriculum-video-{{ $element->id }}">
      %include('curriculum.partials.pager', ['element' => $element, 'curriculum' => $curriculum, 'key' => $key, 'active' => $tutorial->id == $element->id])
    </div>
  %endloop
</div>
