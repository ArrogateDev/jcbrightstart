<div class="html-content-body" id="html-content-body">
    {!! $unit->content ?? '' !!}
</div>

<script>
    $(function () {
        let currentUnit = null;
        let currentChapter = null;
        let htmlEndTimer = null;
        let htmlStarted = false;
        let htmlEnded = false;

        function clearHtmlTimer() {
            if (htmlEndTimer) {
                clearTimeout(htmlEndTimer);
                htmlEndTimer = null;
            }
        }

        function recordHtmlStart() {
            if (htmlStarted) return;
            htmlStarted = true;
            if (typeof window.recordPlayStart === 'function' && currentUnit && currentChapter) {
                window.recordPlayStart(currentChapter, currentUnit);
            }
        }

        function recordHtmlEnd() {
            if (htmlEnded) return;
            htmlEnded = true;
            if (typeof window.recordPlayEnd === 'function' && currentUnit && currentChapter) {
                window.recordPlayEnd(currentChapter, currentUnit, 0);
            }
        }

        window.playHtml = function (unit) {
            clearHtmlTimer();
            currentUnit = unit.id;
            currentChapter = unit.chapter_id;
            htmlStarted = false;
            htmlEnded = false;

            $('#play-content').html(`<div class="html-content-body" id="html-content-body">${unit.content || ''}</div>`);
            $('#play-loading').removeClass('d-flex').addClass('d-none');

            recordHtmlStart();
            htmlEndTimer = setTimeout(function () {
                recordHtmlEnd();
            }, 800);
        };

        window.clearHtml = function () {
            clearHtmlTimer();
            htmlStarted = false;
            htmlEnded = false;
            currentUnit = null;
            currentChapter = null;
        };
    });
</script>
