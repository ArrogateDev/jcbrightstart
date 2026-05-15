<script>
    $(function () {
        /**
         * 判断对象移除img和br内容后是否为纯文本
         * @param {string|HTMLElement|jQuery} input - 要检测的内容（可以是HTML字符串、DOM元素或jQuery对象）
         * @param {Object} options - 配置选项
         * @param {boolean} options.requireNonEmpty - 是否要求必须有文本内容（默认false，允许空文本）
         * @param {boolean} options.strictMode - 严格模式，同时移除其他换行/空白标签如hr（默认false）
         * @returns {boolean} - 如果移除img/br后只剩纯文本，返回true；否则返回false
         */
        function isPlainText(input, options = {}) {
            const {requireNonEmpty = false, strictMode = false} = options;

            // 获取HTML字符串
            let htmlString = '';

            if (typeof input === 'string') {
                htmlString = input;
            } else if (input instanceof jQuery) {
                if (input.length === 0) return false;
                htmlString = input.prop('outerHTML') || input.html() || '';
            } else if (input instanceof HTMLElement) {
                htmlString = input.outerHTML;
            } else {
                return false;
            }

            // 创建临时DOM容器
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = htmlString;

            // 基础移除：img 和 br
            const elementsToRemove = ['img', 'br'];

            // 严格模式下额外移除 hr, wbr 等换行/空标签
            if (strictMode) {
                elementsToRemove.push('hr', 'wbr');
            }

            // 移除所有指定标签
            elementsToRemove.forEach(tag => {
                const elements = tempDiv.querySelectorAll(tag);
                elements.forEach(el => el.remove());
            });

            // 获取剩余内容的纯文本（去空白后）
            const remainingText = tempDiv.textContent || '';
            const trimmedText = remainingText.trim();

            // 检查是否还有其他HTML标签
            const remainingHtml = tempDiv.innerHTML;
            const hasOtherTags = /<[^>]+>/i.test(remainingHtml);

            // 根据配置返回结果
            if (requireNonEmpty) {
                return !hasOtherTags && trimmedText.length > 1;
            }
            return !hasOtherTags && trimmedText.length > 1;
        }

        // 用于存储已经处理过的父容器，避免重复添加
        const processedParents = new Set();

        $('*').each(function () {
            // 跳过已经处理过的元素
            if ($(this).hasClass('bubble')) return;

            // 检查元素是否包含纯文本子元素（而不是自身是纯文本）
            const children = $(this).children();
            if (children.length === 0) return;

            // 查找所有直接子元素中是否有纯文本元素
            let hasPlainTextChild = false;
            let allPlainTextChildren = [];

            children.each(function () {
                if (isPlainText($(this).html(), {requireNonEmpty: true})) {
                    hasPlainTextChild = true;
                    allPlainTextChildren.push(this);
                }
            });

            if (allPlainTextChildren.length === 1 && !processedParents.has(this)) {
                const child = allPlainTextChildren[0];
                if (!$(child).hasClass('bubble')) {
                    var fontSize = $(child).css('font-size');
                    var tooltipText = '字體大小:' + fontSize;
                    $(child).addClass('bubble').attr('data-tooltip', tooltipText).attr('style', `--tooltip-font-size: ${fontSize}px;`);
                    processedParents.add(child);
                }
            }
        });

        // 处理那些直接是纯文本的根元素（没有父容器的情况）
        $('*').each(function () {
            if ($(this).hasClass('bubble')) return;
            if (['DIV', 'A', 'LI', 'SPAN', 'P', 'H1', 'H2', 'H3', 'H4', 'H5', 'H6'].indexOf($(this).prop('tagName')) <= -1) return;

            // 检查元素本身是否是纯文本（没有子元素或子元素都是空）
            if (isPlainText($(this).html(), {requireNonEmpty: true}) && !processedParents.has(this)) {
                var fontSize = $(this).css('font-size');
                var tooltipText = '字體大小:' + fontSize;
                $(this).addClass('bubble').attr('data-tooltip', tooltipText).attr('style', `--tooltip-font-size: ${fontSize}px;`);
                processedParents.add(this);
            }
        });
    })
</script>

<style>
    .bubble {
        position: relative;
    }

    .bubble[data-tooltip]::before {
        content: attr(data-tooltip);
        width: max-content;
        position: absolute;
        top: 20%;
        font-size: var(--tooltip-font-size, 1.1rem);;
        color: #ff0000;
        z-index: 100;
    }
</style>
