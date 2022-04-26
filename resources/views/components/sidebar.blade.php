<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">Rukada</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu">
        <li {{ request()->is('dashboard') ? 'class="mm-active"' : '' }}>
            <a href="{{ route('dashboard') }}">
                <div class="parent-icon"><i class='fas fa-tachometer-alt' style="font-size: 16px;"></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li class="menu-label">Menu</li>
        <li {{ request()->is('category') ? 'class="mm-active"' : '' }}>
            <a href="{{ route('category') }}">
                <div class="parent-icon"><i class='fas fa-list-ul' style="font-size: 16px;"></i>
                </div>
                <div class="menu-title">Category</div>
            </a>
        </li>
        <li {{ request()->is('subcategory') ? 'class="mm-active"' : '' }}>
            <a href="{{ route('subcategory') }}">
                <div class="parent-icon"><i class='fas fa-list' style="font-size: 16px;"></i>
                </div>
                <div class="menu-title">Subcategory</div>
            </a>
        </li>
        <li {{ request()->is('product') ? 'class="mm-active"' : '' }}>
            <a href="{{ route('product') }}">
                <div class="parent-icon"><i class='fas fa-shopping-cart' style="font-size: 16px;"></i>
                </div>
                <div class="menu-title">Product</div>
            </a>
        </li>
    </ul>
    <!--end navigation-->
</div>