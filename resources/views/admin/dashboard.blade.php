<!DOCTYPE html>
<html lang="en">

<x-admin.head/>

<!-- Daterangepikcer JS -->
<script src="{{web_resource_url('assets/admin/js/moment.min.js')}}" type="text/javascript"></script>
<script src="{{web_resource_url('assets/admin/plugins/daterangepicker/daterangepicker.js')}}" type="text/javascript"></script>

<!-- ApexChart JS -->
<script src="{{web_resource_url('assets/admin/plugins/apexchart/apexcharts.min.js')}}" type="text/javascript"></script>
{{--<script src="{{web_resource_url('assets/admin/plugins/apexchart/chart-data.js')}}" type="text/javascript"></script>--}}

<body>

<div class="main-wrapper">

    <x-admin.header/>

    <x-admin.breadcrumb title="{{__('仪表板')}}"/>

    <div class="content">
        <div class="container">

            <div class="row">

                <x-admin.sidebar active="dashboard"/>

                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-md-6 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
											<span class="icon-box bg-primary-transparent me-2 me-xxl-3 flex-shrink-0">
												<img src="{{web_resource_url('assets/admin/img/icon/graduation.svg')}}" alt="">
											</span>
                                        <div>
                                            <span class="d-block">{{__('开始课程')}}</span>
                                            <h4 class="fs-24 mt-1">{{$start_course}}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
											<span class="icon-box bg-secondary-transparent me-2 me-xxl-3 flex-shrink-0">
												<img src="{{web_resource_url('assets/admin/img/icon/book.svg')}}" alt="">
											</span>
                                        <div>
                                            <span class="d-block">{{__('完成课程')}}</span>
                                            <h4 class="fs-24 mt-1">{{$complete_course}}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
											<span class="icon-box bg-success-transparent me-2 me-xxl-3 flex-shrink-0">
												<img src="{{web_resource_url('assets/admin/img/icon/bookmark.svg')}}" alt="">
											</span>
                                        <div>
                                            <span class="d-block">{{__('完成测验')}}</span>
                                            <h4 class="fs-24 mt-1">{{$complete_quizzes}}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
											<span class="icon-box bg-info-transparent me-2 me-xxl-3 flex-shrink-0">
												<img src="{{web_resource_url('assets/admin/img/icon/user-octagon.svg')}}" alt="">
											</span>
                                        <div>
                                            <span class="d-block">{{__('家长总数')}}</span>
                                            <h4 class="fs-24 mt-1">{{$parents}}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
											<span class="icon-box bg-blue-transparent me-2 me-xxl-3 flex-shrink-0">
												<img src="{{web_resource_url('assets/admin/img/icon/book-2.svg')}}" alt="">
											</span>
                                        <div>
                                            <span class="d-block">{{__('课程总数')}}</span>
                                            <h4 class="fs-24 mt-1">{{$total_courses}}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
											<span class="icon-box bg-purple-transparent me-2 me-xxl-3 flex-shrink-0">
												<img src="{{web_resource_url('assets/admin/img/icon/money-add.svg')}}" alt="">
											</span>
                                        <div>
                                            <span class="d-block">{{__('证书总数')}}</span>
                                            <h4 class="fs-24 mt-1">{{$certificates}}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div
                                class="d-flex align-items-center flex-wrap gap-3 justify-content-between border-bottom mb-2 pb-3">
                                <h5 class="fw-bold">{{__('已登记家长')}}</h5>
                                <div class="input-icon position-relative input-range-picker">
										<span class="input-icon-addon">
											<i class="isax isax-calendar"></i>
										</span>
                                    <input type="text" class="form-control date-range booking-range"
                                           placeholder="dd/mm/yyyy - dd/mm/yyyy">
                                </div>
                            </div>
                            <div id="chart"></div>
                        </div>
                    </div>
                    <h5 class="mb-3 fw-bold">{{__('近期开设的课程')}}</h5>
                    <div class="table-responsive custom-table">
                        <table class="table">
                            <thead class="thead-light">
                            <tr>
                                <th>Courses</th>
                                <th>Status</th>
                                <th>Creat Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($courses as $course)
                                <tr>
                                    <td>
                                        <div class="course-title d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar avatar-xl flex-shrink-0 me-2">
                                                <img src="{{$course->thumbnail}}" alt="{{$course->title}}"></a>
                                            <div>
                                                <p class="fw-medium">
                                                    <a href="javascript:void(0);">
                                                        {{$course->title}}
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($course->status ==2)
                                            <span class="badge badge-sm bg-success d-inline-flex align-items-center me-1"><i class="fa-solid fa-circle fs-5 me-1"></i>Published</span>
                                        @elseif($course->status ==1)
                                            <span class="badge badge-sm bg-secondary d-inline-flex align-items-center me-1"><i class="fa-solid fa-circle fs-5 me-1"></i>Suspensed</span>
                                        @else
                                            <span class="badge badge-sm bg-info d-inline-flex align-items-center me-1"><i class="fa-solid fa-circle fs-5 me-1"></i>Draft</span>
                                        @endif
                                    </td>
                                    <td>{{$course->created_at}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-admin.footer/>

    <script>
        $(function () {
            let chart;
            var start = moment().subtract(29, "days");
            var end = moment();

            function booking_range(start, end) {
                showLoading()
                $(".bookingrange span").html(
                    start.format("M/D/YYYY") + " - " + end.format("M/D/YYYY")
                );

                let form = {
                    start: start.format("YYYY-MM-DD"),
                    end: end.format("YYYY-MM-DD"),
                };

                $.ajax({
                    url: "{{route('admin.dashboard.user.html')}}",
                    data: form,
                    dataType: "json",
                    success: function (response) {
                        if (response.code !== 0) {
                            showToast('error', response.msg);
                            return;
                        }

                        let {data, x_axis} = response.data

                        var sColStacked = {
                            chart: {
                                height: 290,
                                type: 'bar',
                                stacked: true,
                                toolbar: {
                                    show: false,
                                }
                            },
                            responsive: [{
                                breakpoint: 480,
                                options: {
                                    legend: {
                                        position: 'bottom',
                                        offsetX: -10,
                                        offsetY: 0
                                    }
                                }
                            }],
                            plotOptions: {
                                bar: {
                                    borderRadius: 5,
                                    horizontal: false,
                                    endingShape: 'rounded'
                                },
                            },
                            series: [{
                                name: 'Earnings',
                                data: data
                            }],
                            xaxis: {
                                categories: x_axis,
                                labels: {
                                    style: {
                                        colors: '#4D4D4D',
                                        fontSize: '13px',
                                    }
                                }
                            },
                            yaxis: {
                                labels: {
                                    offsetX: -15,
                                    style: {
                                        colors: '#4D4D4D',
                                        fontSize: '13px',
                                    }
                                }
                            },
                            grid: {
                                borderColor: '#4D4D4D',
                                strokeDashArray: 5
                            },
                            legend: {
                                show: false
                            },
                            dataLabels: {
                                enabled: false // Disable data labels
                            },
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    shade: 'dark',
                                    type: 'linear',
                                    shadeIntensity: 0.35,
                                    gradientToColors: ['#392C7D'], // Second gradient color
                                    inverseColors: false,
                                    opacityFrom: 1,
                                    opacityTo: 1,
                                    stops: [0, 100],
                                    angle: 90 // This sets the gradient direction from top to bottom
                                }
                            },
                        }

                        if (typeof chart !== 'undefined' && chart !== null) {
                            chart.updateOptions(sColStacked);
                        } else {
                            chart = new ApexCharts(
                                document.querySelector("#chart"),
                                sColStacked
                            );
                            chart.render();
                        }
                    }, error: function () {
                        showToast('error', 'Failed, please try again later')
                    }, complete: function () {
                        hideLoading()
                    }
                });
            }

            $(".booking-range").daterangepicker(
                {
                    startDate: start,
                    endDate: end,
                    ranges: {
                        "Last 30 Days": [moment().subtract(29, "days"), moment()],
                        "Last Year": [
                            moment().subtract(11, "month"),
                            moment()
                        ],
                    },
                    showCustomRangeLabel: false
                },
                booking_range
            );

            booking_range(start, end);
        })
    </script>

</div>

</body>

</html>
