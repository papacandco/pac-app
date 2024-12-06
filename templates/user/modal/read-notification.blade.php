<div class="modal" id="read-all-notifications" tabindex="-1">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title text-white"><i class="fa fa-bell-o"></i> Notification</h5>
      </div>
      <form action="{{ route('user.notification.read') }}" method="post">
        @csrf
        <div class="modal-body">
          <p id="message">Voulez-vous marquer toutes les notifications comme lu ?</p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-danger">Marquer comme lu</button>
        </div>
      </form>
    </div>
  </div>
</div>
