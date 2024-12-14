<div class="modal animated fadeIn" id="flash-info-session" tabindex="-1">
  <div class="modal-dialog modal-sm text-center" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info" style="height: 10px !important">
        <span>&nbsp;</span>
      </div>
      <div class="modal-body">
        <p id="flash-info-message"></p>
      </div>
    </div>
  </div>
</div>
%if (session()->has('success'))
  <div class="modal animated fadeIn" id="flash-session" tabindex="-1">
    <div class="modal-dialog modal-sm text-center" role="document">
      <div class="modal-content">
        {## <div class="modal-header bg-success" style="height: 10px !important">
          <span>&nbsp;</span>
        </div> ##}
        <div class="modal-body">
          <p>{{{ session()->get('success') }}}</p>
        </div>
      </div>
    </div>
  </div>
%elseif (session()->has('error'))
  <div class="modal animated fadeIn" id="flash-session" tabindex="-1">
    <div class="modal-dialog modal-sm text-center" role="document">
      <div class="modal-content">
        {## <div class="modal-header bg-danger" style="height: 10px !important">
          <span>&nbsp;</span>
        </div> ##}
        <div class="modal-body">
          <p>{{{ session()->get('error') }}}</p>
        </div>
      </div>
    </div>
  </div>
%elseif (session()->has('info'))
  <div class="modal animated fadeIn" id="flash-session" tabindex="-1">
    <div class="modal-dialog modal-sm text-center" role="document">
      <div class="modal-content">
        {## <div class="modal-header bg-blue" style="height: 10px !important">
          <span>&nbsp;</span>
        </div> ##}
        <div class="modal-body">
          <p>{{{ session()->get('info') }}}</p>
        </div>
      </div>
    </div>
  </div>
%elseif (session()->has('warning'))
  <div class="modal animated fadeIn" id="flash-session" tabindex="-1">
    <div class="modal-dialog modal-sm text-center" role="document">
      <div class="modal-content">
        <div class="modal-header bg-warning" style="height: 10px !important">
          <span>&nbsp;</span>
        </div>
        <div class="modal-body">
          <p>{{{ session()->get('warning') }}}</p>
        </div>
      </div>
    </div>
  </div>
%endif
<script type="text/javascript">
  $("#flash-session").modal({show: true});
  $("#flash-session").on('modal.bs.hide', function () {
    $("#flash-session").remove();
  });
</script>
