<div class="modal" id="delete-bookmark-modal" tabindex="-1">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title text-white"><i class="fa fa-bookmark"></i> Bookmark</h5>
      </div>
      <form action="{{ route('bookmark.delete') }}" method="post" id="deleteBookmarkForm">
        @csrf
        <div class="modal-body">
          <p id="message"></p>
          <input type="hidden" name="type" value="tutorial">
          <input type="hidden" name="id">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
        </div>
      </form>
    </div>
  </div>
</div>
