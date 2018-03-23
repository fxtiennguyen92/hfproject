@if (isset($page))
<nav class="navbar header-top-bar navbar-fixed-top">
  @if ($page->back_route)
  <a class="arrow-back" href="{{ route($page->back_route) }}"><i class="material-icons">&#xE5C4;</i></a>@else
  <a class="arrow-back" href="window.history.back();"><i class="material-icons">&#xE5C4;</i></a>@endif
  <h3 class="navbar-title">{{ $page->name }}</h3>
</nav>
<script>
  $('body').addClass('has-top-bar')
</script>
@endif
