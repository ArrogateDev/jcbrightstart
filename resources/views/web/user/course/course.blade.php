@props(['course' => null])
<div class="col-xl-4 col-md-6">
    <div class="course-item-two course-item mx-0 j-user-box">
        <div class="course-img">
            <a href="{{route('course.details.html',['course'=>$course->id])}}">
                <img src="{{$course->thumbnail}}" alt="img"
                     class="img-fluid">
            </a>
        </div>
        <div class="course-content">
            <h6 class="title mb-2">
                <a href="{{route('course.details.html',['course'=>$course->id])}}">{{$course->title??""}}</a>
            </h6>
            <div class="d-flex align-items-center justify-content-center">
                <a href="{{route('course.details.html',['course'=>$course->id])}}" class="btn btn-dark btn-sm d-inline-flex align-items-center">
                    View Course<i class="isax isax-arrow-right-3 ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>
