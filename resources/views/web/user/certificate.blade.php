<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    @vite(['resources/css/app.scss', 'resources/css/user.scss', 'resources/js/app.js'])
    <script src="{{web_resource_url('assets/web/vendor/jquery/jquery.min.js')}}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="{{web_resource_url('assets/js/image-viewer.min.js')}}" id="gd-image-viewer"
            data-target-selector=".gallery-img"
            data-allow-rotate="false"
            data-allow-download="false">
    </script>
</head>
<body>
<x-web.user.header/>

<section class="bg-01">
    <div class="container mx-auto">
        <div class="pt-[60px]">
            <x-web.user.profile :user="$user"/>
        </div>

        <div class="grid grid-cols-12 gap-x-12">

            <x-web.user.sidebar active="certificate"/>

            <div class="lg:col-span-9">

                <x-web.user.breadcrumb title="{{__('我的证书')}}"/>

                <div class="flex items-center justify-between pb-5 mb-5 border-b border-[#998675]">
                    <h5 class="text-xl font-bold">{{__('我的证书')}}</h5>
                </div>
                <div class="p-0">
                    <div class="grid grid-cols-12 gap-x-6" id="table-body"></div>

                    <x-web.table-data url="{{route('user.certificate.list.html')}}"/>

                </div>
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
                <div class="md:col-span-6">
                    <div class="card mb-4 j-user-box">
                        <div class="card-body">
                            <div class="mb-3 flex justify-center">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#view_certificate">
                                    <img class="img-fluid rounded gallery-img" src="${item.file_url}" alt="${item.certificate_name}" style="height: 200px;">
                                </a>
                            </div>
                            <div class="flex items-center flex-wrap justify-between gap-2">
                                <h6 class="font-semibold">${item.certificate_name}</h6>
                                <ul class="edit-delete-icon flex items-center gap-x-3 mt-3">
                                    <li>
                                        <a href="javascript:;" class="btn-eye">
                                            <i class="fa-regular fa-eye"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="${item.download_url}" class="inline-flex text-sm action-icon">
                                            <i class="fa-solid fa-download"></i>
                                        </a>
                                    </li>
                                </ul>
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

        const $modal = $('#view-certificate');

        $modal.on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const img = button.data('img') || button.attr('data-img') || '';
            const download = button.data('download') || button.attr('data-download') || '';
            if (!img) return;

            $modal.find('#certificate-img').attr('src', img);
            $modal.find('#certificate-url').attr('href', download);
        });

        $modal.on('hidden.bs.modal', function () {
            $modal.find('#certificate-img').attr('src', '');
            $modal.find('#certificate-url').attr('href', '#');
        });

        $(document).on('click', '.btn-eye', function (e) {
            $(this).parents('.card-body').find('img').click()
        })
    });
</script>

<style>
    #table-body tr, #table-body td {
        display: block;
        width: 100%;
        grid-column: span 12 / span 12;
    }
</style>
</html>
