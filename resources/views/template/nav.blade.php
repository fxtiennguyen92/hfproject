<nav id="top-menu" class="top-menu">
  <div class="menu-icon-container hidden-md-up">
  </div>
  <div class="menu">
    <div class="menu-info-block">
      <div class="left">
        <div class="">
          <a href="{{ route('home_page') }}"><img src="{{ env('CDN_HOST') }}/img/logo/logoh.png" class="navbar-logo"></a>
        </div>
      </div>
      <div class="icon-menu-wrapper">
        <ul class="icon-menu">
          <li class="icon-menu-user @if(isset($nav)) @if($nav == 'control') active @endif @endif">
            <a href="{{ route('control') }}">
              <span>@if (auth()->check()) {{ auth()->user()->email }} @endif</span><i class="material-icons">&#xE7FD;</i>
            </a>
          </li>
          <li class="icon-menu-notification @if(isset($nav)) @if($nav == 'blog') active @endif @endif" style="margin-right: 1px">
            <a href="{{ route('blog_page') }}">
              <span><i class="material-icons">&#xE871;</i></span>
            </a>
          </li>
          <li class="icon-menu-order @if(isset($nav)) @if($nav == 'order') active @endif @endif">
            @if (auth()->check() && auth()->user()->role == 1)
            <a href="{{ route('pro_order_list_page') }}">
            @else
            <a href="{{ route('order_list_page') }}">
            @endif
              <span><i class="material-icons">&#xE8B0;</i></span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>
