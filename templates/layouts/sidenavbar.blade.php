@php $active = \Route::currentRouteName() ?? 'tutorial'; @endphp
<ul class="nav {{ $class ?? '' }} tech-sidebar">
  <li class="{{ $active == 'tutorial' ? 'active tech-sidebar-active' : '' }}">
    <a href="{{ route('tutorial') }}">{{ __('navbar.tutorial') }}</a>
  </li>
  <li class="{{ $active == 'curriculum' ? 'active tech-sidebar-active' : '' }}">
    <a href="{{ route('curriculum') }}">{{ __('navbar.course') }}</a>
  </li>
  <li class="{{ $active == 'forum' ? 'active tech-sidebar-active' : '' }}">
    <a href="{{ route('forum') }}">{{ __('navbar.forum') }}</a>
  </li>
  <li class="{{ $active == 'podcast' ? 'active tech-sidebar-active' : '' }}">
    <a href="{{ route('podcast') }}">{{ __('navbar.podcast') }}</a>
  </li>
</ul>
<br />
