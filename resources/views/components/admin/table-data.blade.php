@props(['url' => null])
<style>
    #field-list th[data-field] {
        cursor: pointer;
        user-select: none;
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out;
    }
</style>
<div class="row align-items-center mt-4" id="pagination-container" style="display: none;">
    <div class="col-md-4 d-flex align-items-center">
        <div class="me-2">
            <select id="data-limit" class="form-select form-select-sm">
                <option value="10">10</option>
                <option value="20" selected>20</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        <p class="pagination-text" id="pagination-info">Page 1 of 1</p>
    </div>
    <div class="col-md-8">
        <ul class="pagination lms-page justify-content-center justify-content-md-end mt-2 mt-md-0" id="pagination-links">
        </ul>
    </div>
</div>
<script>
    let tableParams = null;

    function getData(page = 1, params = {}) {
        tableParams = params;
        let limit = $('#data-limit').val();
        tableParams = Object.assign(tableParams, {limit: limit,});

        let $field, field, sort;
        const $fieldBox = $('#field-list');
        $sort = $fieldBox.find('th[data-sort]');
        $fields = $fieldBox.find('th[data-field]');
        if ($sort.length > 0) {
            $field = $sort.eq(0);
            field = $field.data('field')
            sort = $field.attr('data-sort');
        } else {
            $field = $fields.eq(0);
            field = $field.data('field');
            sort = 'asc';
            $field.attr('data-sort', sort)
        }
        if ($field) {
            $field.add($field.siblings()).each(function () {
                var textContent = $(this).text();
                $(this).empty().text(textContent);
            });

            $field.append(`<i class="fa-solid fa-arrow-${sort === 'asc' ? 'up' : 'down'}-short-wide"></i>`);
        }
        const requestParams = Object.assign({page: page,}, tableParams, {
            sort_field: field,
            sort_direction: sort
        });

        $.ajax({
            url: "{{$url}}",
            data: requestParams,
            dataType: "json",
            beforeSend: function () {
                renderLoadingTable();
            },
            success: function (response) {
                if (response.code !== 0) {
                    showToast('error', response.msg);
                    renderEmptyTable();
                    return;
                }

                const data = response.data;
                if (!data || data.length === 0) {
                    tbody.html(`
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="isax isax-document-text fs-24 mb-2"></i>
                                <p class="mb-0">{{__('暂无数据')}}</p>
                            </td>
                        </tr>
                    `);
                    return;
                }
                renderTable(data.data);
                renderPagination(data, params);
            },
            error: function () {
                showToast('error', '{{__('加载失败，请稍后重试！')}}');
                renderEmptyTable();
            }
        });
    }

    function renderPagination(pagination) {
        const container = $('#pagination-container');
        const info = $('#pagination-info');
        const links = $('#pagination-links');

        if (!pagination || pagination.total === 0) {
            container.hide();
            return;
        }

        container.show();
        @if(app()->getLocale() == 'en')
        info.text(`Page ${pagination.current_page} of ${pagination.total}`);
        @else
        info.text(`{{__('第')}} ${pagination.current_page} {{__('页，共')}} ${pagination.last_page} {{__('页，共')}} ${pagination.total} {{__('条')}}`);
        @endif

        links.empty();

        const prevDisabled = pagination.current_page === 1 ? 'disabled' : '';
        const prevNum = pagination.per_page;
        links.append(`
            <li class="page-item prev ${prevDisabled}">
                <a class="page-link" href="javascript:void(0);1" onclick="handlePageClick('${prevNum}')" tabindex="-1">
                    <i class="fas fa-angle-left"></i>
                </a>
            </li>
        `);

        pagination.links.forEach(function (link) {
            const pageNum = parseInt(link.label);
            if (_.isInteger(pageNum)) {
                const active = link.active ? 'active' : '';
                links.append(`
                    <li class="page-item ${active}">
                        <a class="page-link" href="javascript:void(0);" onclick="handlePageClick('${pageNum}')">
                            ${pageNum}
                        </a>
                    </li>
                `);
            }
        });

        const nextDisabled = pagination.current_page === pagination.last_page ? 'disabled' : '';
        const nextNum = pagination.current_page + 1;
        links.append(`
            <li class="page-item next ${nextDisabled}">
                <a class="page-link" href="javascript:void(0);" onclick="handlePageClick('${nextNum}')">
                    <i class="fas fa-angle-right"></i>
                </a>
            </li>
        `);
    }

    function handlePageClick(page) {
        if (!page) return;
        getData(page, tableParams);
        $('html, body').animate({scrollTop: 0}, 300);
    }

    function renderLoadingTable() {
        const tbody = $('#table-body');
        tbody.html(`
            <tr>
                <td colspan="7" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">{{__('加载中...')}}</span>
                    </div>
                </td>
            </tr>
            `);
    }

    function renderEmptyTable() {
        const tbody = $('#table-body');
        tbody.html(`
            <tr>
                <td colspan="7" class="text-center py-4 text-muted">
                    <i class="isax isax-document-text fs-24 mb-2"></i>
                    <p class="mb-0">{{__('暂无数据')}}</p>
                </td>
            </tr>
        `);
        $('#pagination-container').hide();
    }

    $(function () {
        $('#data-limit').change(function () {
            getData(1, tableParams);
        })

        $('#field-list th[data-field]').click(function () {
            let sort = ($(this).attr('data-sort') === 'asc') ? 'desc' : 'asc';

            $(this).siblings().removeAttr('data-sort');
            $(this).attr('data-sort', sort);

            getData(1, tableParams);
        })
    })
</script>
