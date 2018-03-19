@if (isset($page))
<nav class="navbar header-top-bar navbar-fixed-top">
  <a class="arrow-back" href="{{ route($page->back_route) }}"><i class="material-icons">&#xE5C4;</i></a>
  <h3 class="navbar-title">{{ $page->name }}</h3>
</nav>
@endif