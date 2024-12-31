<ul class="nav {{ $class ?? '' }} tech-sidebar">
  <li class="{{ $active == "tutorial" ? 'active tech-sidebar-active': '' }}">
    <a href="?type=tutorial">
      Tutoriels
    </a>
  </li>
  <li class="{{ $active == "curriculum" ? 'active tech-sidebar-active': '' }}">
    <a href="?type=curriculum">
      Formations
    </a>
  </li>
  <li class="{{ $active == "podcast" ? 'active tech-sidebar-active': '' }}">
    <a href="?type=podcast">
      Podcasts
    </a>
  </li>
  <li class="{{ $active == "question" ? 'active tech-sidebar-active': '' }}">
    <a href="?type=question">
      Forums
    </a>
  </li>
</ul>
