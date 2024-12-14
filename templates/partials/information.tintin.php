<div class="modal" id="information-modal" tabindex="-1">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title">Information</h5>
      </div>
      <form action="#" method="post">
        %csrf
        <div class="modal-body">
          <p id="InformationMessageContainer"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
        </div>
      </form>
    </div>
  </div>
</div>
