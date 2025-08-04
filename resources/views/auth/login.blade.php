@include('components.header', ['title' => 'Login'])


<body>
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="#">
                                <h3>Dream House</h3>
                            </a>
                        </div>
                        <div class="login-form">
                            <form action="{{route('admin.login.submit')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input class="au-input au-input--full" type="email" name="email" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="au-input au-input--full" type="password" name="password" placeholder="Password">
                                </div>
                                @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                                @endif

                                <div class="login-checkbox">
                                    <label>
                                        <input type="checkbox" name="remember">Remember Me
                                    </label>
                                    {{-- <label>
                                        <a href="#">Forgotten Password?</a>
                                    </label> --}}
                                </div>
                                <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">sign in</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="js/vanilla-utils.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-5.3.7.bundle.min.js"></script>
    <!-- Vendor JS       -->
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>

    <!-- Main JS-->
    <script src="js/bootstrap5-init.js"></script>
    <script src="js/main-vanilla.js"></script>
    <script src="js/swiper-bundle.min.js"></script>
    <script src="js/aos.js"></script>
    <script src="js/modern-plugins.js"></script>

</body>

</html>
<!-- end document-->