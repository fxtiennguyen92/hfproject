<nav class="top-menu">
  <div class="menu-icon-container hidden-md-up">
  </div>
  <div class="menu">
    <div class="menu-info-block">
      <div class="left">
        <div class="">
          <a href="{{ route('home_page') }}"><img src="img/logoh.png" class="navbar-logo"></a>
        </div>
      </div>
      <div class="icon-menu-wrapper">
        <ul class="icon-menu" >
          <li class="icon-menu-user">
            @if(Auth::check())
            <a href="javascript:void(0)">
            @else
            <a href="{{ route('login') }}">
            @endif
              <span><i class="material-icons">person</i></span>
            </a>
          </li>
          
          <li class="icon-menu-notification">
            <a href="javascript:void(0)" >
              <span><i class="material-icons">&#xE80B;</i></span>
            </a>
          </li>
          <li class="icon-menu-order">
            <a href="{{ route('order_list_page') }}" >
              <span><i class="material-icons">&#xE8B0;</i></span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>
