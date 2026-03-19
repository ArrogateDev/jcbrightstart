<!DOCTYPE html>
<html lang="en">

<x-web.user.head/>

<body>

<div class="main-wrapper">

    <x-web.user.header :user="$user"/>

    <div class="content">
        <div class="container">

            <x-web.user.profile :user="$user"/>

            <div class="row">

                <x-web.user.sidebar active="quiz"/>

                <div class="col-lg-9">

                    <x-web.user.breadcrumb title="{{__('我的测验')}}"/>

                    <div class="page-title d-flex align-items-center justify-content-between">
                        <h5>{{__('我的测验')}}</h5>
                    </div>
                    <div id="table-body"></div>

                    <x-admin.table-data url="{{route('user.quiz.list.html')}}"/>

                </div>
            </div>
        </div>
    </div>

    <x-web.user.footer/>

</div>

</body>

<script>
    function renderTable(list) {
        const tbody = $('#table-body');
        tbody.empty();
        if (!list || list.length === 0) return;

        list.forEach(function (item) {
            const row = `
                <div class="border rounded-2 p-3 mb-3 j-user-box">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div>
                                <h6 class="mb-2"><a href="${item.url}">${item.title}</a></h6>
                                Number of Questions : ${item.total_questions}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center justify-content-end mt-2 mt-md-0">
                                <a href="${item.url}" class="arrow-next"><i class="isax isax-arrow-right-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            tbody.append(row);
        });
    }

    $(function () {
        getData(1);
    });
</script>

<style>
    #table-body tr, #table-body td {
        display: block;
        width: 100%;
    }
</style>
</html>
