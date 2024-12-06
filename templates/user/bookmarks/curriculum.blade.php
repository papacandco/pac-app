@extends('layouts.app', ['active' => 'profile', 'navbar_with_shadow' => true])

@section('title', __('user.favoris_title'))

@section('content')
@include('user.partials.header', ['active' => 'bookmark'])
<section class="container" style="margin-bottom: 150px">
  <h3>{{ __('user.bookmark.curriculum.title') }}</h3>
  <div class="row">
    <aside class="col-sm-2 hidden-xs" style="margin-top: 10px;">
      @include('user.partials.sidebar', ["active" => "curriculum"])
    </aside>
    <div class="col-sm-10">
      <div class="row">
        @forelse($bookmarks as $curriculum)
          @include('curriculum.partials.curriculum', ['curriculum' => $curriculum])
        @empty
          @include('partials.no-data', ['message' => __('user.bookmark.curriculum.no_data')])
        @endforelse
      </div>
    </div>
  </div>
</section>
@include('user.modal.delete')
@endsection

@section('script')
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
@endsection
