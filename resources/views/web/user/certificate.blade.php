<!DOCTYPE html>
<html lang="en">

<x-web.user.head/>

<script src="{{web_resource_url('assets/js/image-viewer.min.js')}}" id="gd-image-viewer"
        data-target-selector=".gallery-img"
        data-allow-rotate="false"
        data-allow-download="false">
</script>
<body>

<div class="main-wrapper">

    <x-web.user.header :user="$user"/>

    <x-web.user.breadcrumb title="{{__('我的证书')}}"/>

    <div class="content">
        <div class="container">

            <x-web.user.profile :user="$user"/>

            <div class="row">

                <x-web.user.sidebar active="certificate"/>

                <div class="col-lg-9">
                    <div class="page-title d-flex align-items-center justify-content-between">
                        <h5>{{__('我的证书')}}</h5>
                    </div>
                    <div class="p-0">
                        <div class="row" id="table-body"></div>

                        <x-admin.table-data url="{{route('user.certificate.list.html')}}"/>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-web.user.footer/>

    <div class="modal fade" id="view-certificate">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>{{__('查看证书')}}</h5>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                            aria-label="Close">
                        <i class="isax isax-close-circle5"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center"><img id="certificate-img" class="img-fluid" alt=""></div>
                    <div class="text-end mt-4">
                        <a id="certificate-url" href="#" class="btn btn-secondary rounded-pill">
                            <i class="isax isax-import me-2"></i>
                            {{__('下载')}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

</body>

<script>
    function renderTable(list) {
        const tbody = $('#table-body');
        tbody.empty();
        if (!list || list.length === 0) return;

        list.forEach(function (item) {
            const row = `
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="mb-3 d-flex justify-content-center">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#view_certificate">
                                    <img class="img-fluid rounded gallery-img" src="${item.file_url}" alt="${item.certificate_name}" style="height: 200px;">
                                </a>
                            </div>
                            <div class="d-flex align-items-center flex-wrap justify-content-between gap-2">
                                <h6>${item.certificate_name}</h6>
                                <ul class="edit-delete-icon d-flex align-items-center">
                                    <li>
                                        <a href="javascript:;" class="btn-eye">
                                            <i class="isax isax-eye"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="${item.download_url}" class="d-inline-flex fs-14 action-icon">
                                            <i class="isax isax-import"></i>
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
    }
</style>
</html>
