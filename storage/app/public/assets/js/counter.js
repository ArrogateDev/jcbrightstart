function visible(partial) {
    var $t = partial,
        $w = jQuery(window),
        viewTop = $w.scrollTop(),
        viewBottom = viewTop + $w.height(),
        _top = $t.length ? $t.offset().top : 0,
        _bottom = _top + ($t.length ? $t.height() : 0),
        compareTop = partial === true ? _bottom : _top,
        compareBottom = partial === true ? _top : _bottom;

    if (!$t.length) {
        return false;
    }

    return ((compareBottom <= viewBottom) && (compareTop >= viewTop) && $t.is(':visible'));
}

$(window).scroll(function () {
    const $countDigit = $('.count-digit');
    if (visible($countDigit)) {
        if ($countDigit.hasClass('counter-loaded')) return;
        $countDigit.addClass('counter-loaded');
        $countDigit.each(function () {
            var $this = $(this);
            jQuery({Counter: 0}).animate({Counter: $this.text()}, {
                duration: 3000,
                easing: 'swing',
                step: function () {
                    $this.text(Math.ceil(this.Counter));
                }
            });
        });
    }
})
