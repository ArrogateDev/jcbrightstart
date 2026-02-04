<div id="unit-template" style="display: none;">
    <div class="unit-item border rounded p-3 mb-2" data-unit-index="">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <div class="flex-grow-1">
                <input type="text" name="chapters[][units][][title]"
                       class="form-control form-control-sm mb-2"
                       placeholder="{{__('单元标题')}}" required>
                <div class="form-check form-check-inline">
                    <input class="form-check-input unit-type-radio"
                           type="radio"
                           name="chapters[][units][][type]"
                           id=""
                           value="0" checked>
                    <label class="form-check-label" for="">
                        {{__('Youtube 链接')}}
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input unit-type-radio"
                           type="radio"
                           name="chapters[][units][][type]"
                           id=""
                           value="1">
                    <label class="form-check-label" for="">
                        {{__('PDF文件')}}
                    </label>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-danger remove-unit-btn" style="margin: 5px;">
                <i class="fa-solid fa-trash"></i>
            </button>
        </div>
        <div class="unit-content-youtube">
            <input type="text" name="chapters[][units][][video_url]"
                   class="form-control form-control-sm"
                   placeholder="{{__('Youtube URL链接')}}">
        </div>
        <div class="unit-content-pdf" style="display: none;">
            <div class="input-group">
                <input type="file" name="chapters[][units][][pdf]"
                       class="form-control form-control-sm unit-pdf-file-input"
                       accept="application/pdf"
                       style="display: none;">
                <button type="button" class="btn btn-sm btn-outline-primary unit-pdf-select-btn">
                    <i class="fa-solid fa-file-pdf me-1"></i>{{__('选择PDF文件')}}
                </button>
                <input type="text" class="form-control form-control-sm unit-pdf-file-name"
                       placeholder="{{__('未选择文件')}}"
                       readonly>
            </div>
            <div class="unit-pdf-existing-file mt-2" style="display: none;">
                <a href="#" target="_blank" class="btn btn-sm btn-outline-primary unit-pdf-view-btn">
                    <i class="fa-solid fa-file-pdf me-1"></i>{{__('查看当前PDF')}}
                </a>
            </div>
        </div>
        <div class="mt-2">
            <label class="form-label small">{{__('绑定测验')}}</label>
            <select name="chapters[][units][][quiz_id]"
                    class="form-control form-control-sm unit-quiz-select"
                    data-chapter-index=""
                    data-unit-index="">
                <option value="">{{__('请选择测验')}}</option>
            </select>
        </div>
        <div class="mt-2">
            <label class="form-label small">{{__('描述')}}</label>
            <div class="summernote" data-chapter-index="" data-unit-index=""></div>
        </div>
        <input type="hidden" name="chapters[][units][][id]" value="">
    </div>
</div>

