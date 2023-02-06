<div class="page-sidebar navbar-collapse collapse">
    <!-- BEGIN SIDEBAR MENU -->
    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
        {{--<li class="nav-item start {{ (stripos($_SERVER['REQUEST_URI'], '/home') !== false)? ' active open': '' }}">
            <a href="/home" class="nav-link nav-toggle">
                <i class="icon-home"></i>
                <span class="title">Dashboard</span>
                <span class="selected"></span>
                <span class="arrow open"></span>
            </a>
        </li>--}}
        <li class="nav-item {{ (stripos($_SERVER['REQUEST_URI'], '/users') !== false)? ' active open': '' }}">
            <a href="#" class="nav-link nav-toggle">
                <i class="icon-doc"></i>
                <span class="title">Users</span>
                <span class="selected"></span>
                <span class="arrow open"></span>
            </a>
        </li>
        <li class="nav-item {{ (stripos($_SERVER['REQUEST_URI'], '/arts') !== false)? ' active open': '' }}">
            <a href="#" class="nav-link nav-toggle">
                <i class="icon-grid"></i>
                <span class="title">Arts</span>
                <span class="selected"></span>
                <span class="arrow open"></span>
            </a>
        </li>
        <li class="nav-item {{ (stripos($_SERVER['REQUEST_URI'], '/feels') !== false)? ' active open': '' }}">
            <a href="#" class="nav-link nav-toggle">
                <i class="icon-camera"></i>
                <span class="title">Feels</span>
                <span class="selected"></span>
                <span class="arrow open"></span>
            </a>
        </li>
    </ul>
    <!-- END SIDEBAR MENU -->
</div>
