@include('components.header', ['title' => 'Dashboard'])

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
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap">
                                    <h2 class="title-1">overview</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row m-t-25">
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c1">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="fas fa-home"></i>
                                            </div>
                                            <div class="text">
                                                <h2>{{$houses}}</h2>
                                                <span>houses</span>
                                            </div>
                                        </div>
                                        <div class="overview-chart">
                                            <canvas id="widgetChart1"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c2">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="fas fa-concierge-bell"></i>
                                            </div>
                                            <div class="text">
                                                <h2>{{$services}}</h2>
                                                <span>services</span>
                                            </div>
                                        </div>
                                        <div class="overview-chart">
                                            <canvas id="widgetChart2"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c3">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="fas fa-user-plus"></i>
                                            </div>
                                            <div class="text">
                                                <h2>{{$join}}</h2>
                                                <span>join requests</span>
                                            </div>
                                        </div>
                                        <div class="overview-chart">
                                            <canvas id="widgetChart3"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c4">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="fas fa-money-bill-wave"></i>
                                            </div>
                                            <div class="text">
                                                <h2>{{$orders}}</h2>
                                                <span>total orders</span>
                                            </div>
                                        </div>
                                        <div class="overview-chart">
                                            <canvas id="widgetChart4"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-9">
                                <h2 class="title-1 m-b-25">Last Orders</h2>
                                <div class="table-responsive table--no-card m-b-40">
                                    <table class="table table-borderless table-striped table-earning">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Service Provider</th>
                                                <th>House</th>
                                                <th>Status</th>
                                                <th>Payment</th>
                                                <th>Service Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($lastOrders as $order)
                                            <tr>
                                                <td>{{ $order->user->name ?? '-' }}</td>
                                                <td>{{ $order->serviceProviders->name ?? '-' }}</td>
                                                <td>{{ $order->house->title ?? '-' }}</td>
                                                <td><span class="badge {{ $order->status }}">{{ $order->status }}</span></td>
                                                <td><span class="badge {{ $order->payment_status }}">{{ $order->payment_status }}</span></td>
                                                <td>{{ $order->service_date }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">No orders here yet</td>
                                            </tr>
                                            @endforelse
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="copyright">
                                    <p>Copyright © 2025 Dream House. All rights reserved.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    @include('components.js-script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const recentRepChart = document.getElementById('recent-rep-chart').getContext('2d');
        new Chart(recentRepChart, {
            type: 'bar',
            data: {
                labels: ['Houses', 'Services'],
                datasets: [{
                    label: 'Count',
                    data: [{
                        {
                            $houses
                        }
                    }, {
                        {
                            $services
                        }
                    }],
                    backgroundColor: ['#244f76', '#52859e'],
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Houses vs Services'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });


        const percentChart = document.getElementById('percent-chart').getContext('2d');
        new Chart(percentChart, {
            type: 'doughnut',
            data: {
                labels: ['Orders', 'Join Requests'],
                datasets: [{
                    label: 'Distribution',
                    data: [{
                        {
                            $orders
                        }
                    }, {
                        {
                            $join
                        }
                    }],
                    backgroundColor: ['#9ad0c2', '#ebf3d5'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: 'Orders vs Join Requests'
                    }
                }
            }
        });
    </script>

</body>

</html>
<!-- end document-->