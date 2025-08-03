<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="{{ route('dashboard') }}">
            <h4> Dream House </h4>
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <li>
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('houses.index') }}">
                        <i class="fas fa-home"></i>Houses
                    </a>
                </li>
                <li>
                    <a href="{{ route('wallets.index') }}">
                        <i class="fas fa-wallet"></i>Wallet Transactions
                    </a>
                </li>
                <li>
                    <a href="{{ route('orders.index') }}">
                        <i class="fas fa-shopping-cart"></i>Orders
                    </a>
                </li>
                <li>
                    <a href="{{ route('services.index') }}">
                        <i class="fas fa-concierge-bell"></i>Services
                    </a>
                </li>
                <li>
                    <a href="{{ route('categories.index') }}">
                        <i class="fas fa-th-large"></i>Categories
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.join_requests.index') }}">
                        <i class="fas fa-user-plus"></i>Join Requests
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>