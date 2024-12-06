<div class="modal fade" id="follow-curriculum-modal" tabindex="-1">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-bookmark text-muted"></i> Suivre</h5>
      </div>
      <form action="{{ route('bookmark', ['id' => $curriculum->id]) }}" method="post" id="challengePasswordRequireForm">
        @csrf
        <div class="modal-body">
          <p>Voulez-vous suive cette formations ?</p>
          <input type="hidden" name="type" value="curriculum">
        </div>
        <div class="modal-footer">
          <a href="#" style="text-decoration: underline" data-toggle="popover" data-placement="bottom" data-trigger="focus" tabindex="0" data-content="Cela vous permetra de suivre votre progression et d'être plus productif." class="pull-left">Besoin d'aide ?</a>
          <button type="submit" class="btn btn-sm btn-danger">OUI</button>
        </div>
      </form>
    </div>
  </div>
</div>
