<nav class="left-menu" left-menu>
    <div class="logo-container">
        <a href="{{ route('home_page') }}" class="logo">
            <img src="img/hf-logo.png"/>
        </a>
    </div>
    <div class="left-menu-inner scroll-pane">
        <ul class="left-menu-list left-menu-list-root list-unstyled">
            <li>
                <a class="left-menu-link" href="javascript: void(0);">
                    <i class="material-icons">&#xE8F6;</i> Khuyến mãi
                </a>
            </li>
            <li class="left-menu-list-separator "><!-- --></li>
            <li class="left-menu-list">
                <a class="left-menu-link" href="javascript: void(0);">
                    <i class="material-icons">&#xE87C;</i> Thông tin tài khoản
                </a>
            </li>
            <li class="left-menu-list-submenu">
                <a class="left-menu-link" href="javascript: void(0);">
                    <i class="material-icons">&#xE24D;</i> Đơn hàng
                </a>
                <ul class="left-menu-list list-unstyled">
                    <li>
                        <a class="left-menu-link" href="{{ route('order_list_page') }}">
                            <i class="material-icons">&#xE867;</i> Đơn hàng hiện tại
                        </a>
                    </li>
                    <li>
                        <a class="left-menu-link" href="javascript: void(0);">
                            <i class="material-icons">&#xE889;</i> Lịch sử đơn hàng
                        </a>
                    </li>
                </ul>
            </li>
            <li class="left-menu-list-separator "><!-- --></li>
            <li class="left-menu-list">
                <a class="left-menu-link" href="javascript: void(0);">
                    <i class="material-icons">&#xE839;</i> Nhận xét & Đánh giá
                </a>
            </li>
        </ul>
    </div>
</nav>