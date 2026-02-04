<div class="modal fade" id="learn-box" tabindex="-1" aria-labelledby="learn-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center">
                    <h5 class="modal-title" id="learn-label">{{__('学习')}}</h5>
                    <ul class="nav nav-tabs ml-4" id="learn-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="learn-play-tab" data-toggle="tab" href="#learn-play" role="tab" aria-controls="learn-play" aria-selected="true">
                                📖 {{__('内容')}}
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="learn-quiz-tab" data-toggle="tab" href="#learn-quiz" role="tab" aria-controls="learn-quiz" aria-selected="false">
                                ❓ {{__('测验')}}
                            </a>
                        </li>
                    </ul>
                </div>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-0">
                <div class="tab-content" id="learn-tab-content">
                    <div class="tab-pane fade show active" id="learn-play" role="tabpanel" aria-labelledby="learn-play-tab">
                        @include('web.course.play')
                    </div>
                    <div class="tab-pane fade" id="learn-quiz" role="tabpanel" aria-labelledby="learn-quiz-tab">
                        @include('web.course.quiz')
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between" style="display: none;">
                <button class="d-flex justify-content-center align-items-center per-btn">
                    ← {{__('上一题')}}
                </button>
                <button class="d-flex justify-content-center align-items-center next-btn">
                    {{__('下一题')}} →
                </button>
            </div>
        </div>
    </div>
</div>
