@props(['course' => null])
<div class="md:col-span-1">
    <div class="course-item-two course-item mx-0 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md j-user-box">
        <div class="course-img">
            <a href="{{route('course.details.html',['course'=>$course->id])}}">
                <img src="{{$course->thumbnail}}" alt="img"
                     class="h-48 w-full object-cover">
            </a>
        </div>
        <div class="course-content p-4">
            <h6 class="title mb-3 line-clamp-2 text-base font-semibold text-slate-900">
                <a href="{{route('course.details.html',['course'=>$course->id])}}" class="transition hover:text-indigo-600">{{$course->title??""}}</a>
            </h6>
            <div class="flex items-center justify-center">
                <a href="{{route('course.details.html',['course'=>$course->id])}}" class="inline-flex items-center rounded-full bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-800">
                    {{__('进入课程')}}<i class="isax isax-arrow-right-3 ml-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>
