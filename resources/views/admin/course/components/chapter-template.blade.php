<div id="chapter-template" style="display: none;">
    <div class="chapter-item mb-3 border rounded" data-chapter-index="">
        <div class="accordion" id="chapter-accordion-">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <span class="accordion-button d-flex align-items-center"
                          data-bs-toggle="collapse"
                          data-bs-target="#chapter-collapse-"
                          aria-expanded="true"
                          role="button"
                          style="box-shadow: none;">
                        <i class="fa-solid fa-grip-vertical me-2 text-muted" style="cursor: move;"></i>
                        <span class="chapter-number fw-medium">{{__('章节')}} <span class="chapter-index-number">1</span></span>
                    </span>
                </h2>
                <div id="chapter-collapse-" class="accordion-collapse collapse show" data-bs-parent="#chapter-accordion-">
                    <div class="accordion-body">
                        <div class="d-flex justify-content-between align-items-center py-2 bg-light border-top chapter-actions">
                            <div class="flex-grow-1 me-3">
                                <input type="text" name="chapters[][title]"
                                       class="form-control form-control-sm chapter-title-input"
                                       placeholder="{{__('章节标题')}}"
                                       required>
                            </div>
                            <div class="d-flex align-items-center">
                                <button type="button" class="btn btn-sm btn-success add-unit-btn me-2" data-chapter-index="">
                                    <i class="fa-solid fa-plus me-1"></i>{{__('新增单元')}}
                                </button>
                                <button type="button" class="btn btn-sm btn-danger remove-chapter-btn">
                                    <i class="fa-solid fa-trash me-1"></i>{{__('删除章节')}}
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="chapters[][id]" value="">
                        <div class="units-container" data-chapter-index=""></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

