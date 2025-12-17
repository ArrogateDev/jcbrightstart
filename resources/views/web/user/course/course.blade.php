@props(['course' => null])
<div class="col-xl-4 col-md-6">
    <div class="course-item-two course-item mx-0">
        <div class="course-img">
            <a href="javascript:void(0);">
                <img src="{{web_resource_url('assets/admin/img/course/course-01.jpg')}}" alt="img"
                     class="img-fluid">
            </a>
        </div>
        <div class="course-content">
            <div class="d-flex justify-content-between mb-2">
                <div class="d-flex align-items-center">
                    <a href="javascript:void(0);" class="avatar avatar-sm">
                        <img src="{{web_resource_url('assets/admin/img/user/user-29.jpg')}}" alt="img"
                             class="img-fluid avatar avatar-sm rounded-circle">
                    </a>
                    <div class="ms-2">
                        <a href="javascript:void(0);" class="link-default fs-14">Brenda Slaton</a>
                    </div>
                </div>
                <span class="badge badge-light rounded-pill bg-light d-inline-flex align-items-center fs-13 fw-medium mb-0">
                    Design
                </span>
            </div>
            <h6 class="title mb-2">
                <a href="javascript:void(0);">{{$course->title??""}}</a>
            </h6>
            <p class="d-flex align-items-center mb-3"><i
                    class="fa-solid fa-star text-warning me-2"></i>5.0 (999 Reviews)
            </p>
            <div class="d-flex align-items-center justify-content-center">
                <a href="javascript:void(0);"
                   class="btn btn-dark btn-sm d-inline-flex align-items-center">View
                    Course<i class="isax isax-arrow-right-3 ms-1"></i></a>
            </div>
        </div>
    </div>
</div>
