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
                                <div>
                                    <h5 class="mb-2"><a href="{{route('admin.quiz.html')}}">{{$quiz->title}}</a></h5>
                                    <div class="question-info d-flex align-items-center">
                                        <p class="d-flex align-items-center fs-14 me-2 pe-2 border-end mb-0">
                                            <i class="isax isax-message-question5 text-primary-soft me-2"></i>
                                            {{$quiz->question_num}} Questions
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
                            <thead class="thead-light" id="field-list">
                            <tr>
                                <th>{{__('家长')}}</th>
                                <th>{{__('完成题目')}}</th>
                                <th data-field="completed_at" data-sort="desc">{{__('完成时间')}}</th>
                            </tr>
                            </thead>
                            <tbody id="table-body"></tbody>
                        </table>
                    </div>

                    <x-admin.table-data url="{{route('admin.quiz-results.list.html', ['quiz' => $quiz->id])}}"/>

                </div>
            </div>
        </div>
    </div>

    <x-admin.footer/>


</div>
@csrfRefresh
</body>

<script>
    function renderTable(list) {
        const tbody = $('#table-body');
        tbody.empty();
        if (!list || list.length === 0) return;

        list.forEach(function (item) {
            const row = `
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <a href="javascript:void(0);"
                               class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                <img src="${item.user.avatar}" alt="${item.user.full_name}">
                            </a>
                            <a href="javascript:void(0);">
                                <p class="fs-14">${item.user.full_name}</p>
                            </a>
                        </div>
                    </td>
                    <td>${item.answered}</td>
                    <td>${item.completed_at}</td>
                </tr>
            `;
            tbody.append(row);
        });
    }

    $(function () {
        getData(1);
    })
</script>
</html>
