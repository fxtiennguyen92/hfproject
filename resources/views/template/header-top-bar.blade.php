@if (isset($page))
<nav class="navbar header-top-bar navbar-fixed-top">
  @if (isset($page->back_route) && $page->back_route)
  <a class="arrow-back" href="{{ route($page->back_route) }}"><i class="material-icons">&#xE5C4;</i></a>@else
  <a class="arrow-back" href="{{ url()->previous() }}"><i class="material-icons">&#xE5C4;</i></a>@endif
</nav>
<script>
  $('body').addClass('has-top-bar')
</script>
@endif
