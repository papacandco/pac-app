@extends('layouts.app', ['active' => 'notification', 'navbar_with_shadow' => true])

@section('title', __('user.notification_title'))

@section('content')
@include('user.partials.header', ['active' => 'notification'])
<section class="container" style="margin-top: -20px; margin-bottom: 10px; padding: 20px;">
  <div class="row">
    <div class="col-sm-12">
      <div class="pull-right" style="position: relative; top: 30px">
        <a href="#" class="text-danger" data-toggle="modal" data-target="#delete-all-notifications">Supprimer tout</a> &bull; <a href="#" class="text-danger" data-toggle="modal" data-target="#read-all-notifications">Marquer tout comme lu</a>
      </div>
      <h3>{{ __('user.notification_title') }} ({{ $user->unreadNotifications()->count() }})</h3>
      <ul class="notifications">
        @forelse($notifications as $notification)
          @include("user.partials.notification", compact("notification"))
        @empty
            @include('partials.no-data', [
            'message' => 'Aucune notification'
            ])
        @endforelse
      </ul>
    </div>
  </div>
</section>

@include("user.modal.delete-notification")
@include("user.modal.read-notification")
@endsection

