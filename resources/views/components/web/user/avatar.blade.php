@props([
    'module' => 'admin',
    'user' => null
])

<!-- Cropper JS -->
<script src="{{web_resource_url('assets/admin/plugins/cropper/cropper.min.js')}}"></script>
<!-- Cropper CSS -->
<link rel="stylesheet" href="{{web_resource_url('assets/admin/plugins/cropper/cropper.min.css')}}">

<a href="javascript:void(0);"
   class="avatar flex-shrink-0 avatar-xxxl avatar-rounded border-slate-200 me-3"
   data-avatar-trigger="true">
    <img src="{{$user->avatar}}" alt="Img" class="img-fluid avatar-img">
</a>
<div class="profile-upload-head">
    <h6><a href="javascript:void(0);">{{__('头像')}}</a></h6>
    <p class="text-sm text-[#6d6d6d] mb-0">{{__('PNG或JPG的宽度和高度不超过800px')}}</p>
    <div class="new-employee-field">
        <div class="flex items-center mt-2">
            <div class="image-upload relative mb-0 me-2">
                <input type="file" id="avatar-file-input" accept="image/*">
                <a href="#"
                   class="btn bg-gray-100 btn-sm rounded-full image-uploads"
                   data-avatar-trigger="true">{{__('上传')}}</a>
            </div>
            <div class="img-delete ms-1">
                <a href="#" class="btn btn-sm bg-[#ff4667] rounded-full text-white remove-avatar">{{__('删除')}}</a>
            </div>
        </div>
    </div>
</div>

<!-- Avatar Crop Modal -->
<dialog id="avatar-crop-modal" class="modal">
    <div class="modal-box w-11/12 max-w-5xl">
        <h3 class="text-lg font-bold">{{__('修改头像')}}</h3>
        <div class="py-4">
            <div class="grid gap-4 lg:grid-cols-12 items-start">
                <div class="lg:col-span-8">
                    <div class="aspect-square bg-base-200 border border-base-300 rounded-box flex items-center justify-center overflow-hidden">
                        <img id="avatar-cropper-image" src="" alt="Avatar Crop" class="img-fluid d-none max-w-full max-h-full">
                        <span id="avatar-cropper-placeholder" class="text-base-content/60 hidden">{{__('请选择一张图片')}}</span>
                    </div>
                </div>
                <div class="lg:col-span-4 flex flex-col items-center">
                    <div class="avatar-crop-preview shadow-sm mx-auto cropper-preview"></div>
                    <p class="text-base-content/70 text-center mt-3 text-sm">{{__('预览区域为最终圆形头像效果')}}</p>
                </div>
            </div>
        </div>
        <div class="modal-action">
            <form method="dialog" class="flex items-center gap-2">
                <button type="button" class="btn btn-ghost bg-[#f8f8f8]" id="avatar-crop-cancel">{{__('取消')}}</button>
                <button type="button" class="btn btn-secondary bg-[#ff4667]" id="avatar-crop-confirm">{{__('保存头像')}}</button>
            </form>
        </div>
    </div>
</dialog>

<style>

    .avatar {
        position: relative;
        height: 2.625rem;
        width: 2.625rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        color: var(--white);
        font-weight: 500;
    }

    .avatar a.badge:hover {
        color: var(--white);
    }

    .avatar img {
        width: 100%;
        height: 100%;
        border-radius: 4px;
    }

    .avatar.avatar-rounded {
        border-radius: 50%;
    }

    .avatar.avatar-rounded img {
        border-radius: 50%;
    }

    .avatar.avatar-radius-0 {
        border-radius: 0;
    }

    .avatar.avatar-radius-0 img {
        border-radius: 0;
    }

    .avatar .avatar-badge {
        position: absolute;
        inset-block-start: -4%;
        inset-inline-end: -0.375rem;
        width: 1.4rem;
        height: 1.4rem;
        font-size: 0.625rem;
        border: 2px solid var(--white);
        border-radius: 50% !important;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .avatar.online:before,
    .avatar.offline:before {
        position: absolute;
        content: "";
        width: 0.5rem;
        height: 0.5rem;
        border-radius: 50%;
        inset-inline-end: 0;
        inset-block-end: 0;
        border: 2px solid var(--white) !important;
        z-index: 1;
    }

    .avatar.online:before {
        background-color: #03c95a;
    }

    .avatar.offline:before {
        background-color: var(--gray-500);
    }

    .avatar.avatar-xs {
        width: 1.25rem;
        height: 1.25rem;
        line-height: 1.25rem;
        font-size: 0.65rem;
    }

    .avatar.avatar-xs .avatar-badge {
        padding: 0.25rem;
        width: 1rem;
        height: 1rem;
        line-height: 1rem;
        font-size: 0.5rem;
        inset-block-start: -25%;
        inset-inline-end: -0.5rem;
    }

    .avatar.avatar-sm {
        width: 1.5rem;
        height: 1.5rem;
        line-height: 1.5rem;
        font-size: 0.65rem;
    }

    .avatar.avatar-sm .avatar-badge {
        padding: 0.3rem;
        width: 1.1rem;
        height: 1.1rem;
        line-height: 1.1rem;
        font-size: 0.5rem;
        inset-block-start: -28%;
        inset-inline-end: -0.45rem;
    }

    .avatar.avatar-sm.online:before,
    .avatar.avatar-sm.offline:before {
        width: 0.5rem;
        height: 0.5rem;
    }

    .avatar.avatar-md {
        width: 2rem;
        height: 2rem;
        line-height: 2rem;
        font-size: 0.8rem;
    }

    .avatar.avatar-md .avatar-badge {
        padding: 0.4rem;
        width: 1.2rem;
        height: 1.2rem;
        line-height: 1.2rem;
        font-size: 0.65rem;
        inset-block-start: -6%;
        inset-inline-end: -13%;
    }

    .avatar.avatar-md.online:before,
    .avatar.avatar-md.offline:before {
        width: 0.75rem;
        height: 0.75rem;
    }

    .avatar.avatar-md svg {
        width: 1.5rem;
        height: 1.5rem;
    }

    .avatar.avatar-lg {
        width: 2.813rem;
        height: 2.813rem;
        line-height: 2.813rem;
        font-size: 1rem;
    }

    .avatar.avatar-lg .avatar-badge {
        inset-block-start: -15%;
        inset-inline-end: -0.25%;
    }

    .avatar.avatar-lg.online:before,
    .avatar.avatar-lg.offline:before {
        width: 0.8rem;
        height: 0.8rem;
    }

    .avatar.avatar-lg svg {
        width: 1.8rem;
        height: 1.8rem;
    }

    .avatar.avatar-xl {
        width: 3.6rem;
        height: 3.6rem;
        line-height: 3.6rem;
        font-size: 1.25rem;
    }

    .avatar.avatar-xl .avatar-badge {
        inset-block-start: -8%;
        inset-inline-end: -0.2%;
    }

    .avatar.avatar-xl.online:before,
    .avatar.avatar-xl.offline:before {
        width: 0.95rem;
        height: 0.95rem;
    }

    .avatar.avatar-xxl {
        width: 5rem;
        height: 5rem;
        line-height: 5rem;
        font-size: 1.5rem;
    }

    .avatar.avatar-xxl .avatar-badge {
        inset-block-start: -4%;
        inset-inline-end: 0rem;
    }

    .avatar.avatar-xxl.online:before,
    .avatar.avatar-xxl.offline:before {
        width: 1.05rem;
        height: 1.05rem;
        inset-block-end: 0.25rem;
    }

    .avatar.avatar-xxxl {
        width: 6rem;
        height: 6rem;
        line-height: 6rem;
        font-size: 1.75rem;
    }

    .avatar.avatar-xxxl .avatar-badge {
        inset-block-start: -4%;
        inset-inline-end: 0rem;
    }

    .avatar.avatar-xxxl.online:before,
    .avatar.avatar-xxxl.offline:before {
        width: 1.05rem;
        height: 1.05rem;
        inset-block-end: 0.25rem;
    }

    .avatar-list-stacked {
        padding: 0;
    }

    .avatar-list-stacked.avatar-group-overlapped .avatar {
        margin-right: -0.875rem;
    }

    .avatar-list-stacked.avatar-group-overlapped .avatar:hover {
        z-index: 1;
    }

    .avatar-list-stacked.avatar-group-lg .avatar {
        width: 3.25rem;
        height: 3.25rem;
    }

    .avatar-list-stacked.avatar-group-lg .avatar > .initial-wrap {
        font-size: 0.95rem;
    }

    .avatar-list-stacked.avatar-group-lg.avatar-group-overlapped .avatar {
        margin-right: -1rem;
    }

    .avatar-list-stacked.avatar-group-sm .avatar {
        width: 1.5rem;
        height: 1.5rem;
    }

    .avatar-list-stacked.avatar-group-sm .avatar > .initial-wrap {
        font-size: 0.6rem;
    }

    .avatar-list-stacked.avatar-group-sm.avatar-group-overlapped .avatar {
        margin-right: -0.625rem;
    }

    .avatar-list-stacked.avatar-group-xs .avatar {
        width: 1rem;
        height: 1rem;
        margin-inline-end: -6px !important;
    }

    .avatar-list-stacked.avatar-group-xs .avatar > .initial-wrap {
        font-size: 0.6rem;
    }

    .avatar-list-stacked.avatar-group-xs.avatar-group-overlapped .avatar {
        margin-right: -6px;
    }

    .avatar-list-stacked .avatar {
        margin-inline-end: -20px !important;
        border: 1px solid rgba(0, 0, 0, 0.05);
        vertical-align: middle;
        transition: transform ease 200ms;
    }

    .avatar-list-stacked .avatar:last-child {
        margin-inline-end: 0 !important;
    }

    .avatar-list-stacked .avatar:hover {
        z-index: 1;
        transform: translateY(-0.188rem);
    }

    .avatar-group {
        display: -webkit-inline-box;
        display: -ms-inline-flexbox;
        display: inline-flex;
    }

    .avatar-group .avatar {
        width: 2.625rem;
        height: 2.625rem;
    }

    .avatar-group .avatar .avatar-img,
    .avatar-group .avatar > .initial-wrap {
        border: 2px solid var(--white);
        font-size: 0.9rem;
    }

    .avatar-group.avatar-group-overlapped .avatar {
        margin-right: -0.875rem;
    }

    .avatar-group.avatar-group-overlapped .avatar:hover {
        z-index: 1;
    }

    .avatar-group.avatar-group-lg .avatar {
        width: 3.25rem;
        height: 3.25rem;
    }

    .avatar-group.avatar-group-lg .avatar > .initial-wrap {
        font-size: 0.95rem;
    }

    .avatar-group.avatar-group-lg.avatar-group-overlapped .avatar {
        margin-right: -1rem;
    }

    .avatar-group.avatar-group-sm .avatar {
        width: 2rem;
        height: 2rem;
    }

    .avatar-group.avatar-group-sm .avatar > .initial-wrap {
        font-size: 0.6rem;
    }

    .avatar-group.avatar-group-sm.avatar-group-overlapped .avatar {
        margin-right: -0.625rem;
    }

    .avatar.avatar-xl.border.online::before {
        width: 10px;
        height: 10px;
        inset-inline-end: 5px;
    }

    .avatar-xxxl.candidate-img {
        width: 135px;
        height: 135px;
    }

    .avatar-crop-preview {
        width: 160px;
        height: 160px;
        border-radius: 50%;
        overflow: hidden;
        background: #f5f5f5;
    }

    .avatar-crop-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .cropper-container {
        max-width: 100%;
    }

    .cropper-view-box,
    .cropper-face {
        border-radius: 50%;
    }

    .image-upload input[type="file"] {
        width: 57px;
        opacity: 0;
        position: relative;
        z-index: 9;
        cursor: pointer;
    }

    .image-upload .image-uploads {
        text-align: center;
        position: absolute;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
    }

    .btn.btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
</style>

<script>
    (function () {
        const fileInput = document.getElementById('avatar-file-input');
        const triggers = document.querySelectorAll('[data-avatar-trigger]');
        const modalElement = document.getElementById('avatar-crop-modal');
        const cropperImage = document.getElementById('avatar-cropper-image');
        const placeholder = document.getElementById('avatar-cropper-placeholder');
        const confirmButton = document.getElementById('avatar-crop-confirm');
        const cancelButton = document.getElementById('avatar-crop-cancel');
        const avatarImages = document.querySelectorAll('img.avatar-img');
        const previewSelector = '.cropper-preview';

        let cropperInstance = null;

        function destroyCropper() {
            if (cropperInstance) {
                cropperInstance.destroy();
                cropperInstance = null;
            }
        }

        triggers.forEach(trigger => {
            trigger.addEventListener('click', function (event) {
                event.preventDefault();
                fileInput.click();
            });
        });

        fileInput.addEventListener('change', function (event) {
            const [file] = event.target.files || [];
            if (!file) {
                return;
            }

            if (!file.type.startsWith('image/')) {
                showToast('error', '请选择图片文件');
                fileInput.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                placeholder.classList.add('d-none');
                cropperImage.classList.remove('d-none');
                cropperImage.src = e.target.result;

                modalElement.showModal();
                modalElement.addEventListener('close', function initCropper() {}, {once: true});
                requestAnimationFrame(() => {
                    destroyCropper();
                    const CropperClass = window.Cropper;
                    if (typeof CropperClass !== 'function') {
                        showToast('error', '未加载裁剪组件');
                        return;
                    }
                    cropperInstance = new CropperClass(cropperImage, {
                        aspectRatio: 1,
                        viewMode: 1,
                        dragMode: 'move',
                        autoCropArea: 1,
                        background: false,
                        preview: previewSelector
                    });
                });
            };

            reader.readAsDataURL(file);
        });

        modalElement.addEventListener('close', function () {
            destroyCropper();
            cropperImage.src = '';
            cropperImage.classList.add('d-none');
            placeholder.classList.remove('d-none');
            fileInput.value = '';
        });

        confirmButton.addEventListener('click', function () {
            if (!cropperInstance) {
                showToast('error', '请先选择并裁剪图片');
                return;
            }

            const canvas = cropperInstance.getCroppedCanvas({
                width: 400,
                height: 400,
                imageSmoothingQuality: 'high'
            });

            if (!canvas) {
                showToast('error', '裁剪失败，请重试');
                return;
            }

            const dataUrl = canvas.toDataURL('image/png');
            handleSetAvatar(dataUrl)
        });

        cancelButton.addEventListener('click', function () {
            modalElement.close();
        });

        function handleSetAvatar(avatar) {
            showLoading()

            let form = {
                avatar
            }
            form._token = '{{csrf_token()}}'

            $.ajax({
                type: "post",
                url: "{{route($module.'.set-avatar.html')}}",
                data: form,
                dataType: "json",
                success: function (data) {
                    if (data.code !== 0) {
                        showToast('error', data.msg);
                        return;
                    }

                    avatarImages.forEach((img) => {
                        if (img) {
                            img.src = avatar;
                        }
                    });
                    modalElement.close();

                    showToast('success', 'Successful');
                },
                error: function () {
                    showToast('error', 'Failed, please try again later');
                },
                complete: function () {
                    hideLoading();
                }
            });
        }
    })();

    $(function () {
        $('.remove-avatar').click(function () {
            confirm_alert('Are you sure?', "You won't be able to revert this!", 'Yes, Delete!!').then((result) => {
                if (!result.isConfirmed) {
                    return;
                }

                showLoading();

                $.ajax({
                    type: "delete",
                    url: "{{route($module.'.remove-avatar.html')}}",
                    data: {
                        _token: '{{csrf_token()}}'
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.code !== 0) {
                            showToast('error', data.msg);
                            return;
                        }

                        showToast('success', 'Successful');
                        $('.avatar-img').attr('src', '{{web_resource_url('assets/admin/img/avatar.png')}}')
                    },
                    error: function () {
                        showToast('error', 'Failed, please try again later');
                    },
                    complete: function () {
                        hideLoading();
                    }
                });
            });
        });
    });
</script>
