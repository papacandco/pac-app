%if(!isset($disable_about))
<div class="row">
  <div class="col-sm-12">
    %include('partials.what')
  </div>
</div>
%endif
<div class="row">
  <div class="col-sm-12">
    %include('partials.newsletter')
  </div>
</div>
%if(!isset($disable_comment))
  <br>
  <div class="row">
    <div class="col-sm-12">
      %include('partials.comment')
    </div>
  </div>
%endif
