%extends('layouts.app', ['active' => 'profile', 'navbar_with_shadow' => true])

%block('title', __('user.favoris_title'))

%block('content')
  %include('user.partials.header', ['active' => 'bookmark'])
  <section class="container" style="margin-bottom: 150px">
    <h3>{{ __('user.bookmark.tutorial.title') }}</h3>
    <div class="row">
      <aside class="col-sm-2 hidden-xs" style="margin-top: 10px;">
        %include('user.partials.sidebar', ["active" => "tutorial"])
      </aside>
      <div class="col-sm-9">
        <div class="row">
          %loop($bookmarks as $tutorial)
            %include('tutorial.partials.thumb', ['size' => 6, 'tutorial' => $tutorial])
          %endloop
          %if(count($bookmarks) == 0)
            %include('partials.no-data', ['message' => __('user.bookmark.tutorial.no_data')])
          %endif
        </div>
      </div>
    </div>
  </section>
  %include('user.modal.delete')
%endblock

%block('script')
<script style="text/javascript">
  $('[name="update_password"]').click(function (e) {
    var disabled = $('[name="password"]').attr('disabled');
    $('[name="password"]').attr('disabled', !disabled);
    $('[name="password_confirmation"]').attr('disabled', !disabled);
  })

  $('.delete-bookmark').click(function () {
    var $this = $(this);
    $('#deleteBookmarkForm').find('[name="id"]').val($this.data('id'));
    $('#deleteBookmarkForm').find('[name="type"]').val($this.data('type'));
    $('#deleteBookmarkForm').find('#message').html($this.data('message'));
  });

</script>
%endblock
