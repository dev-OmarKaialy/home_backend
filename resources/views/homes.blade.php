@include('components.header', ['title' => 'Homes'])

<body>
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        @include('components.header-mobile')
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        @include('components.sidebare')
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            @include('components.header-desktop')
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content" style="padding-top: 60px;">
                <!-- USER DATA-->
                <div class="user-data m-b-30">
                    <h3 class="title-3 m-b-30">
                        <i class="zmdi zmdi-account-calendar"></i>user data
                    </h3>
                    <div class="filters m-b-45">
                        <div class="select-wrapper">
                            <select class="form-select form-select-lg" name="property">
                                <option selected="selected">All Properties</option>
                                <option value="">Products</option>
                                <option value="">Services</option>
                            </select>

                        </div>
                        <div class="select-wrapper">
                            <select class="form-select form-select-lg" name="time">
                                <option selected="selected" value="all">All Time</option>
                                <option value="month">By Month</option>
                                <option value="day">By Day</option>
                            </select>

                        </div>
                    </div>
                    <div class="table-responsive table-data">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>
                                        <label class="au-checkbox">
                                            <input type="checkbox">
                                            <span class="au-checkmark"></span>
                                        </label>
                                    </td>
                                    <td>name</td>
                                    <td>role</td>
                                    <td>type</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($homes as $home )
                                <tr>
                                    <td>
                                        <label class="au-checkbox">
                                            <input type="checkbox">
                                            <span class="au-checkmark"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="table-data__info">
                                            <h6>lori lynch</h6>
                                            <span>
                                                <a href="#">johndoe@gmail.com</a>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="role admin">admin</span>
                                    </td>
                                    <td>
                                        <div class="select-wrapper">
                                            <select class="form-select form-select-lg" name="property">
                                                <option selected="selected">Full Control</option>
                                                <option value="">Post</option>
                                                <option value="">Watch</option>
                                            </select>

                                        </div>
                                    </td>
                                    <td>
                                        <span class="more">
                                            <i class="zmdi zmdi-more"></i>
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="user-data__footer">
                        <button class="au-btn au-btn-load">load more</button>
                    </div>
                </div>
                <!-- END USER DATA-->
            </div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    @include('components.js-script')

</body>

</html>
<!-- end document-->