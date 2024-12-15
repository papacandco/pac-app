%raw
  $progress = $curriculum->computeProgression(auth()->user());
%endraw
<div class="progress" style="height: 5px; margin-top: 10px; margin-bottom: 0px">
  <div class="progress-bar progress-bar-{{ $progress == 100 ? "success" : ($progress < 70 ? "danger" : "warning") }}" role="progressbar" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $progress }}%;">
    <span class="sr-only">{{ $progress }}% Complete</span>
  </div>
</div>
