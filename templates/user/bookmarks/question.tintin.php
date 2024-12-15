%extends('layouts.app', ['active' => 'profile', 'navbar_with_shadow' => true])

%block('title', __('user.favoris_title'))

%block('content')
%include('user.partials.header', ['active' => 'bookmark'])
<section class="container" style="margin-bottom: 150px">
  <h3>{{ __('user.bookmark.question.title') }}</h3>
  <div class="row">
    <aside class="col-sm-2 hidden-xs" style="margin-top: 10px;">
      %include('user.partials.sidebar', ["active" => "question"])
    </aside>
    <div class="col-sm-10">
      <div class="row">
        %forelse($bookmarks as $question)
          %include('forum.partials.question', ['question' => $question, 'type' => 'forum'])
        %empty
          %include('partials.no-data', ['message' => __('user.bookmark.question.no_data')])
        %endforelse
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
