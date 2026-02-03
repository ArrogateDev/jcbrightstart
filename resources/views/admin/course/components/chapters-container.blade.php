<div id="chapters-container">
    @if(isset($course->chapters) && count($course->chapters) > 0)
        @foreach($course->chapters as $chapterIdx => $chapter)
            <div class="chapter-item mb-3" data-chapter-index="{{$chapterIdx}}">
                <div class="accordion" id="chapter-accordion-{{$chapterIdx}}">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <span class="accordion-button d-flex align-items-center"
                                  data-bs-toggle="collapse"
                                  data-bs-target="#chapter-collapse-{{$chapterIdx}}"
                                  aria-expanded="true"
                                  role="button"
                                  style="box-shadow: none;">
                                <i class="fa-solid fa-grip-vertical me-2 text-muted" style="cursor: move;"></i>
                                <span class="chapter-number fw-medium">{{__('章节')}} <span
                                        class="chapter-index-number">{{$chapterIdx + 1}}</span></span>
                            </span>
                        </h2>
                        <div class="d-flex justify-content-between align-items-center p-2 bg-light border-top chapter-actions">
                            <div class="flex-grow-1 me-3">
                                <input type="text" name="chapters[{{$chapterIdx}}][title]"
                                       class="form-control form-control-sm chapter-title-input"
                                       placeholder="{{__('章节标题')}}"
                                       value="{{$chapter->title??''}}"
                                       required>
                            </div>
                            <div class="d-flex align-items-center">
                                <button type="button" class="btn btn-sm btn-success add-unit-btn me-2" data-chapter-index="{{$chapterIdx}}">
                                    <i class="fa-solid fa-plus me-1"></i>{{__('新增单元')}}
                                </button>
                                <button type="button" class="btn btn-sm btn-danger remove-chapter-btn">
                                    <i class="fa-solid fa-trash me-1"></i>{{__('删除章节')}}
                                </button>
                            </div>
                        </div>
                        <div id="chapter-collapse-{{$chapterIdx}}" class="accordion-collapse collapse show"
                             data-bs-parent="#chapter-accordion-{{$chapterIdx}}">
                            <div class="accordion-body">
                                <input type="hidden" name="chapters[{{$chapterIdx}}][id]" value="{{$chapter->id??''}}">
                                <div class="units-container" data-chapter-index="{{$chapterIdx}}">
                                    @if(isset($chapter->units) && count($chapter->units) > 0)
                                        @foreach($chapter->units as $unitIdx => $unit)
                                            <div class="unit-item border rounded p-3 mb-2" data-unit-index="{{$unitIdx}}">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <div class="flex-grow-1">
                                                        <input type="text" name="chapters[{{$chapterIdx}}][units][{{$unitIdx}}][title]"
                                                               class="form-control form-control-sm mb-2"
                                                               placeholder="{{__('单元标题')}}"
                                                               value="{{$unit->title??''}}" required>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input unit-type-radio"
                                                                   type="radio"
                                                                   name="chapters[{{$chapterIdx}}][units][{{$unitIdx}}][type]"
                                                                   id="unit_type_youtube_{{$chapterIdx}}_{{$unitIdx}}"
                                                                   value="0"
                                                                @checked(($unit->type??0) == 0)>
                                                            <label class="form-check-label" for="unit_type_youtube_{{$chapterIdx}}_{{$unitIdx}}">
                                                                {{__('Youtube 链接')}}
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input unit-type-radio"
                                                                   type="radio"
                                                                   name="chapters[{{$chapterIdx}}][units][{{$unitIdx}}][type]"
                                                                   id="unit_type_pdf_{{$chapterIdx}}_{{$unitIdx}}"
                                                                   value="1"
                                                                @checked(($unit->type??1) == 1)>
                                                            <label class="form-check-label" for="unit_type_pdf_{{$chapterIdx}}_{{$unitIdx}}">
                                                                {{__('PDF文件')}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-sm btn-danger remove-unit-btn" style="    margin: 5px;">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </div>
                                                <div class="unit-content-youtube"
                                                     style="display: {{($unit->type??0) == 0 ? 'block' : 'none'}};">
                                                    <input type="text" name="chapters[{{$chapterIdx}}][units][{{$unitIdx}}][video_url]"
                                                           class="form-control form-control-sm"
                                                           placeholder="{{__('Youtube URL链接')}}"
                                                           value="{{$unit->video_url??''}}">
                                                    @if(isset($unit->video_url) && $unit->video_url)
                                                        <div class="mt-2 position-relative">
                                                            <a href="javascript:void(0);" class="preview-video-btn"
                                                               data-video-url="{{$unit->video_url}}">
                                                                <img class="img-fluid rounded"
                                                                     src="{{web_resource_url('assets/admin/img/course/add-course-1.jpg')}}"
                                                                     alt="preview">
                                                                <div class="play-icon">
                                                                    <i class="fa-solid fa-play"></i>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="unit-content-pdf" style="display: {{($unit->type??1) == 1? 'block' : 'none'}};">
                                                    <div class="input-group">
                                                        <input type="file" name="chapters[{{$chapterIdx}}][units][{{$unitIdx}}][pdf]"
                                                               class="form-control form-control-sm unit-pdf-file-input"
                                                               accept="application/pdf"
                                                               style="display: none;">
                                                        <button type="button" class="btn btn-sm btn-outline-primary unit-pdf-select-btn">
                                                            <i class="fa-solid fa-file-pdf me-1"></i>{{__('选择PDF文件')}}
                                                        </button>
                                                        <input type="text" class="form-control form-control-sm unit-pdf-file-name"
                                                               placeholder="{{__('未选择文件')}}"
                                                               value="{{isset($unit->file) && $unit->file ? basename($unit->file) : ''}}"
                                                               readonly>
                                                    </div>
                                                    @if(isset($unit->file) && $unit->file)
                                                        <div class="unit-pdf-existing-file mt-2">
                                                            <a href="{{web_resource_url($unit->file)}}" target="_blank"
                                                               class="btn btn-sm btn-outline-primary unit-pdf-view-btn">
                                                                <i class="fa-solid fa-file-pdf me-1"></i>{{__('查看当前PDF')}}
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="mt-2">
                                                    <label class="form-label small">{{__('绑定测验')}}</label>
                                                    <select name="chapters[{{$chapterIdx}}][units][{{$unitIdx}}][quiz_id]"
                                                            class="form-control form-control-sm unit-quiz-select"
                                                            data-chapter-index="{{$chapterIdx}}"
                                                            data-unit-index="{{$unitIdx}}">
                                                        <option value="">{{__('请选择测验')}}</option>
                                                        @if(isset($unit->quiz_id) && $unit->quiz_id)
                                                            <option value="{{$unit->quiz_id}}" selected>{{$unit->quiz->title??''}}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="mt-2">
                                                    <label class="form-label">{{__('描述')}}</label>
                                                    <div class="summernote" data-chapter-index="{{$chapterIdx}}" data-unit-index="{{$unitIdx}}">{!! $unit->description??'' !!}</div>
                                                    <textarea name="chapters[{{$chapterIdx}}][units][{{$unitIdx}}][description]" 
                                                              class="form-control d-none unit-description-textarea" 
                                                              data-chapter-index="{{$chapterIdx}}" 
                                                              data-unit-index="{{$unitIdx}}">{!! $unit->description??'' !!}</textarea>
                                                </div>
                                                <input type="hidden" name="chapters[{{$chapterIdx}}][units][{{$unitIdx}}][id]"
                                                       value="{{$unit->id??''}}">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>




