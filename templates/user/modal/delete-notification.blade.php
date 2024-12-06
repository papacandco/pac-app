<div class="modal" id="delete-all-notifications" tabindex="-1">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title text-white"><i class="fa fa-bell"></i> Notification</h5>
      </div>
      <form action="{{ route('user.notification.delete') }}?all" method="post" id="deleteBookmarkForm">
        @csrf
        <div class="modal-body">
          <p id="message">Voulez-vous supprimer tout les notifications</p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
        </div>
      </form>
    </div>
  </div>
</div>
