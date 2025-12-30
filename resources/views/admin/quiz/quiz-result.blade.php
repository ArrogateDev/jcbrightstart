<!DOCTYPE html>
<html lang="en">

<x-admin.head/>

<body>

<div class="main-wrapper">

    <x-admin.header/>

    <x-admin.breadcrumb title="{{__('测验结果管理')}}"/>

    <div class="content">
        <div class="container">
            <div class="row">

                <x-admin.sidebar active="quiz"/>

                <div class="col-lg-9">
                    <h5 class="page-title">{{__('测验结果管理')}}</h5>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-sm-flex align-items-center">
                                <div class="quiz-img me-3 mb-2 mb-sm-0">
                                    <img src="{{web_resource_url('assets/admin/img/students/quiz.jpg')}}" alt="">
                                </div>
                                <div>
                                    <h5 class="mb-2"><a href="{{route('admin.quiz.html')}}">{{$quiz->title}}</a></h5>
                                    <div class="question-info d-flex align-items-center">
                                        <p class="d-flex align-items-center fs-14 me-2 pe-2 border-end mb-0">
                                            <i class="isax isax-message-question5 text-primary-soft me-2"></i>
                                            {{$quiz->question_num}} Questions
                                        </p>
                                        <p class="d-flex align-items-center fs-14 mb-0">
                                            <i class="isax isax-clock5 text-secondary-soft me-2"></i>
                                            30 Minutes
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="card bg-secondary-transparent border-0">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="mb-1 fw-normal text-gray-5">{{__('总完成人数')}}</h6>
                                            <span class="fs-20 fw-bold mb-1 d-block text-gray-9">{{$total}}</span>
                                        </div>
                                        <div class="icon-box bg-soft-secondary">
                                            <img src="{{web_resource_url('assets/admin/img/icon/user-tick.svg')}}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card bg-info-transparent border-0">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="mb-1 fw-normal text-gray-5">{{__('过去30天总完成人数')}}</h6>
                                            <span class="fs-20 fw-bold mb-1 d-block text-gray-9">{{$month_total}}</span>
                                        </div>
                                        <div class="icon-box  bg-soft-info">
                                            <img src="{{web_resource_url('assets/admin/img/icon/document.svg')}}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card bg-purple-transparent border-0">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="mb-1 fw-normal text-gray-5">{{__('过去7天总完成人数')}}</h6>
                                            <span class="fs-20 fw-bold mb-1 d-block text-gray-9">{{$week_total}}</span>
                                        </div>
                                        <div class="icon-box  bg-soft-purple">
                                            <img src="{{web_resource_url('assets/admin/img/icon/clock.svg')}}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive custom-table">
                        <table class="table">
                            <thead class="thead-light">
                            <tr>
                                <th>{{__('家长')}}</th>
                                <th>{{__('完成题目')}}</th>
                                <th>{{__('完成时间')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="#"
                                           class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                            <img src="{{web_resource_url('assets/admin/img/user/user-01.jpg')}}" alt="">
                                        </a>
                                        <a href="#" class="fs-14">Thompson Hicks</a>
                                    </div>
                                </td>
                                <td>04</td>
                                <td>22 Aug 2025, 09:00 AM</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="#"
                                           class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                            <img src="{{web_resource_url('assets/admin/img/user/user-06.jpg')}}" alt="">
                                        </a>
                                        <a href="#" class="fs-14">Jennifer Tovar</a>
                                    </div>
                                </td>
                                <td>03</td>
                                <td>10 Aug 2025, 09:15 AM</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="#"
                                           class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                            <img src="{{web_resource_url('assets/admin/img/user/user-09.jpg')}}" alt="">
                                        </a>
                                        <a href="#" class="fs-14">James Schulte</a>
                                    </div>
                                </td>
                                <td>02</td>
                                <td>26 Jul 2025, 02:20 PM</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="#"
                                           class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                            <img src="{{web_resource_url('assets/admin/img/user/user-20.jpg')}}" alt="">
                                        </a>
                                        <a href="#" class="fs-14">Kristy Cardona</a>
                                    </div>
                                </td>
                                <td>02</td>
                                <td>12 Jul 2025, 11:40 AM</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="#"
                                           class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                            <img src="{{web_resource_url('assets/admin/img/user/user-27.jpg')}}" alt="">
                                        </a>
                                        <a href="#" class="fs-14">William Aragon</a>
                                    </div>
                                </td>
                                <td>04</td>
                                <td>02 Jul 2025, 04:30 PM</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="#"
                                           class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                            <img src="{{web_resource_url('assets/admin/img/user/user-30.jpg')}}" alt="">
                                        </a>
                                        <a href="#" class="fs-14">Shirley Lis</a>
                                    </div>
                                </td>
                                <td>01</td>
                                <td>25 Jun 2025, 08:10 AM</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="#"
                                           class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                            <img src="{{web_resource_url('assets/admin/img/user/user-17.jpg')}}" alt="">
                                        </a>
                                        <a href="#" class="fs-14">John Brewer</a>
                                    </div>
                                </td>
                                <td>02</td>
                                <td>17 Jun 2025, 06:30 PM</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="#"
                                           class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                            <img src="{{web_resource_url('assets/admin/img/user/user-37.jpg')}}" alt="">
                                        </a>
                                        <a href="#" class="fs-14">Doris Hughes</a>
                                    </div>
                                </td>
                                <td>03</td>
                                <td>04 Jun 2025, 05:00 PM</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="#"
                                           class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                            <img src="{{web_resource_url('assets/admin/img/user/user-04.jpg')}}" alt="">
                                        </a>
                                        <a href="#" class="fs-14">Sarah Martinez</a>
                                    </div>
                                </td>
                                <td>04</td>
                                <td>20 May 2025, 06:30 PM</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="#"
                                           class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                            <img src="{{web_resource_url('assets/admin/img/user/user-18.jpg')}}" alt="">
                                        </a>
                                        <a href="#" class="fs-14">Sarah Martinez</a>
                                    </div>
                                </td>
                                <td>03</td>
                                <td>15 May 2025, 01:40 PM</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row align-items-center mt-4">
                        <div class="col-md-2">
                            <p class="pagination-text">Page 1 of 2</p>
                        </div>
                        <div class="col-md-10">
                            <ul
                                class="pagination lms-page justify-content-center justify-content-md-end mt-2 mt-md-0">
                                <li class="page-item prev">
                                    <a class="page-link" href="javascript:void(0)" tabindex="-1"><i
                                            class="fas fa-angle-left"></i></a>
                                </li>
                                <li class="page-item first-page active">
                                    <a class="page-link" href="javascript:void(0)">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="javascript:void(0)">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="javascript:void(0)">3</a>
                                </li>
                                <li class="page-item next">
                                    <a class="page-link" href="javascript:void(0)"><i
                                            class="fas fa-angle-right"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <x-admin.footer/>


</div>

</body>

</html>
