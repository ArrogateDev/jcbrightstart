@props([
    'module' => 'admin',
    'user' => null
])

<!-- Cropper JS -->
<script src="{{web_resource_url('assets/admin/plugins/cropper/cropper.min.js')}}"></script>
<!-- Cropper CSS -->
<link rel="stylesheet" href="{{web_resource_url('assets/admin/plugins/cropper/cropper.min.css')}}">

<a href="javascript:void(0);"
   class="avatar flex-shrink-0 avatar-xxxl avatar-rounded border me-3"
   data-avatar-trigger="true">
    <img src="{{$user->avatar}}" alt="Img" class="img-fluid avatar-img">
</a>
<div class="profile-upload-head">
    <h6><a href="javascript:void(0);">Your Avatar</a></h6>
    <p class="fs-14 mb-0">PNG or JPG no bigger than 800px width and height
    </p>
    <div class="new-employee-field">
        <div class="d-flex align-items-center mt-2">
            <div class="image-upload position-relative mb-0 me-2">
                <input type="file" id="avatar-file-input" accept="image/*">
                <a href="#"
                   class="btn bg-gray-100 btn-sm rounded-pill image-uploads"
                   data-avatar-trigger="true">Upload</a>
            </div>
            <div class="img-delete ms-1">
                <a href="#"
                   class="btn btn-secondary btn-sm rounded-pill remove-avatar">Delete</a>
            </div>
        </div>
    </div>
</div>

<!-- Avatar Crop Modal -->
<div class="modal fade" id="avatar-crop-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">修改头像</h5>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-lg-8">
                        <div class="ratio ratio-1x1 bg-light border rounded d-flex align-items-center justify-content-center">
                            <img id="avatar-cropper-image" src="" alt="Avatar Crop" class="img-fluid d-none">
                            <span id="avatar-cropper-placeholder" class="text-muted">请选择一张图片</span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="avatar-crop-preview shadow-sm mx-auto cropper-preview"></div>
                        <p class="text-muted text-center mt-3 fs-14">预览区域为最终圆形头像效果</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">取消</button>
                <button type="button" class="btn btn-secondary" id="avatar-crop-confirm">保存头像</button>
            </div>
        </div>
    </div>
</div>

<style>
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
</style>

<script>
    (function () {
        const fileInput = document.getElementById('avatar-file-input');
        const triggers = document.querySelectorAll('[data-avatar-trigger]');
        const modalElement = document.getElementById('avatar-crop-modal');
        const cropperImage = document.getElementById('avatar-cropper-image');
        const placeholder = document.getElementById('avatar-cropper-placeholder');
        const confirmButton = document.getElementById('avatar-crop-confirm');
        const avatarImages = document.querySelectorAll('img.avatar-img');
        const previewSelector = '.cropper-preview';

        const bootstrapModal = new bootstrap.Modal(modalElement);
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

                modalElement.addEventListener('shown.bs.modal', function initCropper() {
                    modalElement.removeEventListener('shown.bs.modal', initCropper);
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
                        preview: previewSelector,
                        ready() {
                            bootstrapModal.handleUpdate();
                        }
                    });
                }, {once: true});

                bootstrapModal.show();
            };

            reader.readAsDataURL(file);
        });

        modalElement.addEventListener('hidden.bs.modal', function () {
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
                    bootstrapModal.hide();

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
