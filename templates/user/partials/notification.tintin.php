<li class="notification shadow-sm">
  <div class="media">
    <div class="media-body">
      <p class="notification-desc">{{{ $notification->data["message"] }}}</p>
      <div class="notification-meta">
        <small class="timestamp">{{ $notification->created_at->diffForHumans(null) }} &bull; <i class="fa fa-eye"></i> {{{ $notification->read() ? 'Lu' : 'Non Lu' }}}</small>
      </div>
    </div>
  </div>
</li>
