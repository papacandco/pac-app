<div class="row" id="curriculum-video-list" data-simplebar>
  %loop($curriculum->graphs as $key => $graph)
    <div class="col-sm-12 curriculum-video-item" id="curriculum-video-{{ $graph->id }}">
      %include('curriculum.partials.pager', ['element' => $graph->element, 'key' => $key, 'active' => $tutorial->id == $graph->graph_id])
    </div>
  %endloop
</div>
