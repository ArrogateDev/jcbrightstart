<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    @vite(['resources/css/app.scss', 'resources/css/user.scss', 'resources/js/app.js', 'resources/css/font-awesome/all.min.css'])
    <script src="{{web_resource_url('assets/web/vendor/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{ web_resource_url('assets/js/lodash.js') }}"></script>
</head>

<body>
<x-web.user.header/>

<section class="bg-01">
    <div class="container mx-auto">
        <div class="pt-[60px]">
            <x-web.user.profile :user="$user"/>
        </div>

        <div class="grid grid-cols-12 lg:gap-x-12">

            <x-web.user.sidebar active="quiz"/>

            <div class="col-span-12 lg:col-span-10">

                <x-web.user.breadcrumb title="{{__('我的测验')}}"/>

                <div class="mb-5 flex flex-col gap-4 border-b border-[#998675] pb-5 lg:flex-row lg:items-center lg:justify-between">
                    <h5 class="text-xl font-bold">{{__('我的测验')}}</h5>
                </div>
                <div id="table-body"></div>

                <x-web.table-data url="{{route('user.quiz.list.html')}}"/>

            </div>
        </div>

    </div>
</section>

<x-web.footer/>
</body>

<script>
    function renderTable(list) {
        const tbody = $('#table-body');
        tbody.empty();
        if (!list || list.length === 0) return;

        list.forEach(function (item) {
            const row = `
                <div class="border rounded-2 p-3 mb-3 j-user-box">
                    <div class="grid grid-cols-12 items-center">
                        <div class="col-span-8">
                            <div>
                                <h6 class="text-base font-semibold mb-2"><a href="${item.url}">${item.title}</a></h6>
                                Number of Questions : ${item.total_questions}
                            </div>
                        </div>
                        <div class="col-span-4">
                            <div class="flex items-center justify-end mt-2 mt-md-0">
                                <a href="${item.url}" class="arrow-next"><i class="fa-solid fa-arrow-right"></i><a/>
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
