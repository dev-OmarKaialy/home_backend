<header class="header-desktop" style="height: 60px;">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="header-wrap" style="flex-direction: row-reverse">
                <!-- {-- <form class="form-header" action="" method="POST">
                    <input class="au-input au-input--xl" type="text" name="search" placeholder="Search..." />
                    <button class="au-btn--submit" type="submit" style="background-color: #244F76;">
                        <i class="fas fa-search"></i>
                    </button>
                </form>--} -->

                <div class="header-button">
                    <div class="account-wrap">
                        <div class="account-item clearfix js-item-menu">
                            <div class="image">
                                <img src="{{ Auth::user()->avatar ?? asset('images/icon.png') }}" alt="{{ Auth::user()->name }}" />
                            </div>
                            <div class="account-dropdown js-dropdown">
                                <div class="info clearfix">
                                    <div class="image">
                                        <a href="#">
                                            <img src="{{ Auth::user()->avatar ?? asset('images/icon.png') }}" alt="{{ Auth::user()->name }}" />
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h5 class="name">
                                            <a href="#">{{ Auth::user()->name }}</a>
                                        </h5>
                                        <span class="email">{{ Auth::user()->email }}</span>
                                    </div>
                                </div>
                                <div class="account-dropdown__footer">
                                    <form method="POST" action="{{ route('admin.logout') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-danger" style="margin: 5px 10px;">
                                            <i class="zmdi zmdi-power"></i> Logout
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</header>