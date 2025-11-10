function Toast(type, message, position, timeout) {
    this.type = type;
    this.css = 'toast-top-full-width';
    this.msg = message;
    this.timeout = timeout || 6000;
}

toastr.options.positionClass = 'toast-top-full-width';
toastr.options.extendedTimeOut = 1000;
toastr.options.timeOut = 6000;
toastr.options.fadeOut = 250;
toastr.options.fadeIn = 250;

/**
 *
 * @param type error、info、warning、success
 * @param message
 * @param position
 * @param timeout
 */
function showToast(type, message, position, timeout) {
    var t = new Toast(type, message, position, timeout);
    toastr.options.positionClass = t.css;
    toastr.options.timeOut = t.timeout;
    toastr[t.type](t.msg);
}

function showLoading() {
    $('body').waitMe({
        effect: 'ios',
        bg: 'rgba(255,255,255,0.7)',
        color: '#000',
        maxSize: '',
        waitTime: -1,
        textPos: 'vertical'
    });
}

function hideLoading() {
    $('body').waitMe('hide');
}
