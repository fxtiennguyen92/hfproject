<div id="footer-menu">
  <ul class="list-inline clearfix ">
    <li>
      <a href="{{ route('home_page') }}">
        <img src="{{ env('CDN_HOST') }}/img/icon/icon-128x128.png "/>
      </a>
    </li>
    <li class="@if(isset($nav)) @if($nav == 'blog') active @endif @endif">
      <a href="{{ route('blog_page') }}">
        <i class="material-icons ">&#xE871;</i>
      </a>
    </li>
    <li class="@if(isset($nav)) @if($nav == 'order') active @endif @endif">
      @if (!auth()->check())
      <a href="{{ route('login_page') }}">
      @elseif (auth()->check() && auth()->user()->role == 1)
      <a href="{{ route('pro_order_list_page') }}">
      @else
      <a href="{{ route('order_list_page') }}">
      @endif
        <i class="material-icons ">&#xE8B0;</i>
      </a>
    </li>
    <li class="@if(isset($nav)) @if($nav == 'control') active @endif @endif">
      <a href="{{ route('control') }}">
        <i class="material-icons ">&#xE7FD;</i>
      </a>
    </li>
  </ul>
</div>