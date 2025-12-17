(function ($) {
    // USE STRICT
    "use strict";


    //-------------------------------------------------------
    // Config Animsition
    //-------------------------------------------------------

    try {
        var preloader_object = $('.js-preloader');
        preloader_object.animsition({
            inClass: 'fade-in',
            outClass: 'fade-out',
            inDuration: 800,
            outDuration: 800,
            linkElement: 'a:not([target="_blank"]):not([href^="#"]):not([class^="chosen-single"])',
            loading: true,
            loadingParentElement: 'html',
            loadingClass: 'loader-wrapper',
            loadingInner: '<div class="loader"></div>',
            timeout: false,
            timeoutCountdown: 5000,
            onLoadEvent: true,
            browser: [ 'animation-duration', '-webkit-animation-duration'],
            overlay : false,
            overlayClass : 'animsition-overlay-slide',
            overlayParentElement : 'html',
            transition: function(url){ window.location.href = url; }
        });

    } catch(err) {
        console.log(err)
    }


})(jQuery);

(function ($) {
    // USE STRICT
    "use strict";

    // Global variables
    var html_body = $('html, body');


    //-------------------------------------------------------
    // Config Slick
    //-------------------------------------------------------

    try {

        var slick_object = $('.js-slick-wrapper');
        slick_object.each(function () {
            var that = $(this);
            var slick_content = that.find('.js-slick-content');

            var arrow_left = that.find('.js-slick-prev');
            var arrow_right = that.find('.js-slick-next');
            var option = {
                accessibility: true,
                adaptiveheight: false,
                autoplay: false,
                autoplayspeed: 5000,
                arrows: false,
                asnavfor: null,
                appendarrows: $(this),
                appenddots: $(this),
                prevarrow: '<i class="slick-prev"></i>',
                nextarrow: '<i class="slick-next"></i>',
                centermode: false,
                centerpadding: '50px',
                cssease: 'ease',
                dots: false,
                dotsclass: 'slick-dots',
                draggable: true,
                fade: false,
                focuson: false,
                speed: 800,
                pauseonhover: false,
                xl: 1, lg: this.xl, md: this.lg, sm: this.md, xs: this.sm,
                vertical: false,
                loop: true,
                thumb: false,
                customnav: false,
                variablewidth: false,
                variableheight: false,
                swipetoslide: true
            };

            for (var k in option) {
                if (option.hasOwnProperty(k)) {
                    if ($(this).attr('data-slick-' + k) != null) {
                        option[k] = $(this).data('slick-' + k);
                    }
                }
            }

            if (option.customnav === true) {
                option.appendarrows = that.find('.slick__arrows');
                option.appenddots = that.find('.slick__dots');
            }

            var slickAPI = slick_content;

            var animationInString = '[data-animation], [data-animation-in]';
            var animationOutString = '[data-animation-out]';

            slickAPI.on('init reinit', function() {
                var elementAnimate = $(this).find(animationInString);
                elementAnimate.css("visibility", "hidden");
                var firstAnimatingElements = $(this).find('.slick-current [data-animation], .slick-current [data-animation-in]');
                doAnimations(firstAnimatingElements);
            });

            if (option.thumb)
                slickAPI.slick({
                    accessibility: option.accessibility,
                    adaptiveHeight: option.adaptiveheight,
                    autoplay: option.autoplay,
                    autoplaySpeed: option.autoplayspeed,
                    arrows: option.arrows,
                    asNavFor: option.asnavfor,
                    appendArrows: option.appendarrows,
                    appendDots: option.appenddots,
                    prevArrow: option.prevarrow,
                    nextArrow: option.nextarrow,
                    centerMode: option.centermode,
                    centerPadding: option.centerpadding,
                    cssease: option.cssease,
                    dots: option.dots,
                    dotsClass: option.dotsclass,
                    draggable: option.draggable,
                    pauseOnHover: option.pauseonhover,
                    fade: option.fade,
                    focusOnSelect: option.focuson,
                    vertical: option.vertical,
                    slidesToShow: option.xl,
                    slidesToScroll: option.xl,
                    infinite: option.loop,
                    swipeToSlide: option.swipetoslide,
                    speed: option.speed,
                    variableWidth: option.variablewidth,
                    variableHeight: option.variableheight,
                    customPaging: function(slick, index) {
                        var portrait = $(slick.$slides[index]).data('thumb');
                        return '<img src=" ' + portrait + ' "/><div class="bg-overlay"></div>';
                    },

                    responsive: [
                        {
                            breakpoint: 1201,
                            settings: {
                                slidesToShow: option.lg,
                                slidesToScroll: option.lg
                            }
                        },
                        {
                            breakpoint: 993,
                            settings: {
                                slidesToShow: option.md,
                                slidesToScroll: option.md,
                                variableWidth: false

                            }
                        },
                        {
                            breakpoint: 769,
                            settings: {
                                slidesToShow: option.sm,
                                slidesToScroll: option.sm,
                                centerPadding: "50px",
                                variableWidth: false
                            }
                        },
                        {
                            breakpoint: 576,
                            settings: {
                                slidesToShow: option.xs,
                                slidesToScroll: option.xs,
                                fade: false,
                                centerPadding: "50px",
                                variableWidth: false
                            }
                        }
                    ]
                });
            else
                slickAPI.slick({
                    accessibility: option.accessibility,
                    adaptiveHeight: option.adaptiveheight,
                    autoplay: option.autoplay,
                    autoplaySpeed: option.autoplayspeed,
                    arrows: option.arrows,
                    asNavFor: option.asnavfor,
                    appendArrows: option.appendarrows,
                    appendDots: option.appenddots,
                    prevArrow: option.prevarrow,
                    nextArrow: option.nextarrow,
                    centerMode: option.centermode,
                    centerPadding: option.centerpadding,
                    cssease: option.cssease,
                    dots: option.dots,
                    dotsClass: option.dotsclass,
                    draggable: option.draggable,
                    pauseOnHover: option.pauseonhover,
                    fade: option.fade,
                    focusOnSelect: option.focuson,
                    vertical: option.vertical,
                    slidesToShow: option.xl,
                    slidesToScroll: option.xl,
                    infinite: option.loop,
                    swipeToSlide: option.swipetoslide,
                    speed: option.speed,
                    variableWidth: option.variablewidth,
                    variableHeight: option.variableheight,
                    responsive: [
                        {
                            breakpoint: 1201,
                            settings: {
                                slidesToShow: option.lg,
                                slidesToScroll: option.lg
                            }
                        },
                        {
                            breakpoint: 993,
                            settings: {
                                slidesToShow: option.md,
                                slidesToScroll: option.md,
                                variableWidth: false
                            }
                        },
                        {
                            breakpoint: 769,
                            settings: {
                                slidesToShow: option.sm,
                                slidesToScroll: option.sm,
                                centerPadding: "50px",
                                variableWidth: false

                            }
                        },
                        {
                            breakpoint: 576,
                            settings: {
                                slidesToShow: option.xs,
                                slidesToScroll: option.xs,
                                fade: false,
                                centerPadding: "20px",
                                variableWidth: false
                            }
                        }
                    ]
                });

            slickAPI.on('afterChange', function(e, slick, currentSlide) {
                var $animatingElements = $(this).find('[data-slick-index="' + currentSlide + '"]').find(animationInString);
                doAnimations($animatingElements);
            });

            slickAPI.on('beforeChange', function(e, slick, currentSlide, nextSlide) {
                var $animatingElements = $(this).find('[data-slick-index="' + nextSlide + '"]').find(animationInString);
                if (!($(this).find('[data-slick-index="' + currentSlide + '"]').find(animationOutString).length === 0)) {
                    var $elementAnimateCurrent = $(this).find('[data-slick-index="' + currentSlide + '"]').find(animationOutString);
                    doAnimationsOut($elementAnimateCurrent);
                    return;
                }
                doAnimations($animatingElements);

            });


            function doAnimations(elements) {
                var animationEndEvents = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
                elements.each(function() {
                    elements.css("visibility", "visible");
                    var $animationDelay = $(this).data('animation-delay');
                    var $animationType = 'animated ' + $(this).data('animation');
                    if ($(this).data('animation') === undefined)
                        $animationType = 'animated ' + $(this).data('animation-in');
                    $(this).css({
                        'animation-delay': $animationDelay,
                        '-webkit-animation-delay': $animationDelay
                    });
                    $(this).addClass($animationType).one(animationEndEvents, function() {
                        $(this).removeClass($animationType);
                    });
                });
            }

            function doAnimationsOut(elements) {
                var animationEndEvents = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';

                elements.each(function() {
                    var $animationDelay = "0s";
                    var $animationType = 'animated ' + $(this).data('animation-out');
                    $(this).css({
                        'animation-delay': $animationDelay,
                        '-webkit-animation-delay': $animationDelay
                    });
                    $(this).addClass($animationType).one(animationEndEvents, function() {
                        $(this).removeClass($animationType);
                    });
                    elements.css("visibility", "hidden");
                });
            }

            arrow_left.on('click', function () {
                slick_content.slick('slickPrev');
            });

            arrow_right.on('click', function () {
                slick_content.slick('slickNext');
            });
        });

    } catch(err) {
        console.log(err)
    }

    try {
        $('.js-center-arrow').each(function () {
            var that = $(this);
            var arrow = that.find('.slick-arrow');
            var heightImg = that.find('.js-img').outerHeight();
            var heightArrow = that.find('.slick-arrow').outerHeight();
            var offsetTop = heightImg/2 - heightArrow/2;
            arrow.css('top', offsetTop);
        });
    } catch(err) {
        console.log(err);
    }

})(jQuery);
(function ($) {
    // USE STRICT
    "use strict";


    //-------------------------------------------------------
    // Config Lightbox2
    //-------------------------------------------------------

    try {
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true
        })

    } catch(err) {
        console.log(err);
    }

})(jQuery);

(function ($) {
    // USE STRICT
    "use strict";
    
    try {
        new WOW().init({
            animateClass: 'animated',
            mobile: false
        });
    } catch (error) {
        console.log(error);
    }
    
  
})(jQuery);
(function ($) {
    // USE STRICT
    "use strict";


    //-------------------------------------------------------
    // Config CountDown
    //-------------------------------------------------------

    try {
        $('.cd100').each(function () {
            var that = $(this);
            var y = 0, m =0, d = 0, h = 0, min = 0, sec = 0;
            var countdownYears = that.find('[data-years]');
            var countdownMonths = that.find('[data-months]');
            var countdownDays = that.find('[data-days]');
            var countdownHours = that.find('[data-hours]');
            var countdownMinutes = that.find('[data-minutes]');
            var countdownSeconds = that.find('[data-seconds]');

            if (countdownYears != null) {
                y = countdownYears.data('years');
            }

            if (countdownMonths != null) {
                m = countdownMonths.data('months');
            }

            if (countdownDays != null) {
                d = countdownDays.data('days');
            }

            if (countdownHours != null) {
                h = countdownHours.data('hours');
            }

            if (countdownMinutes != null) {
                min = countdownMinutes.data('minutes');
            }

            if (countdownSeconds != null) {
                sec = countdownSeconds.data('seconds');
            }

            that.countdown100({
                /*Set Endtime here*/
                /*Endtime must be > current time*/
                endtimeYear: y,
                endtimeMonth: m,
                endtimeDate: d,
                endtimeHours: h,
                endtimeMinutes: min,
                endtimeSeconds: sec,
                timeZone: ""
                // ex:  timeZone: "America/New_York"
                //go to " http://momentjs.com/timezone/ " to get timezone
            });
        })

    } catch(err) {
        console.log(err);
    }

})(jQuery);

(function ($) {
    'use strict';

    /*[ Counter Up ]
    ===========================================================*/

    try {

        var counterUpHanlde = $('.js-counterup');

        counterUpHanlde.each(function () {
            $(this).counterUp({
                delay: 10,
                time: 1000
            });
        });

    } catch(err) {
        console.log(err);
    }


})(jQuery);
(function ($) {
    'use strict';

    /*[ Progress Bar ]
    ===========================================================*/
    try {
        var progressbarSimple = $('.js-progressbar-simple');
        progressbarSimple.each(function () {
            var that = $(this);
            var executed = false;
            $(window).on('load', function () {
                that.waypoint(function () {
                    if (!executed) {
                        executed = true;
                        /*progress bar*/
                        that.progressbar({
                            update: function (current_percentage, $this) {
                                $this.parent().find('.js-value').html(current_percentage + '%');
                            }
                        });
                    }
                }, {offset: 'bottom-in-view'});
            })

        });
    } catch (err) {
        console.log(err);
    }

})(jQuery);
(function ($) {
    'use strict';

    /*[ Config MatchHeight ]
    ===========================================================*/

    try {

        var matchHeightItem = $('.js-matchHeight');

        matchHeightItem.matchHeight();

    } catch(err) {
        console.log(err)
    }
})(jQuery);
(function ($) {
    'use strict';

    /*[ Isotope ]
    ===========================================================*/

    try {

        var $isotopeWrapper = $('.js-isotope-wrapper');

        $isotopeWrapper.each(function () {
            var that = $(this);
            var isotopeFilter = that.find('.iostope-filter');
            var isotopeContent = that.find('.isotope-content');

            // init Isotope
            $(window).on('load', function () {
                var $iso = isotopeContent.isotope({
                    itemSelector: '.isotope-item',
                    percentPosition: true,
                    animationEngine : 'best-available',
                    masonry: {
                        columnWidth: '.isotope-item-sizer',
                        horizontalOrder: true
                    }
                });

                $iso.imagesLoaded().progress( function() {
                    $iso.isotope('layout');
                });

                $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                    $iso.isotope('layout');
                })
            });

            isotopeFilter.on('click', 'li', function () {
                isotopeContent.isotope({filter: $(this).attr('data-filter')});
            });

            isotopeFilter.on('click', 'li', function () {
                isotopeFilter.find('.active').removeClass('active');
                $(this).addClass('active');
            });


        });

    } catch(err) {
        console.log(err)
    }
})(jQuery);
(function ($) {
    'use strict';

    /*[ Select 2 Config ]
    ===========================================================*/

    try {
        var selectSimple = $('.js-select-simple');

        selectSimple.each(function () {
            var that = $(this);
            var selectBox = that.find('select');
            var selectDropdown = that.find('.select-dropdown');
            selectBox.select2({
                dropdownParent: selectDropdown
            });
        });

    } catch (err) {
        console.log(err);
    }


})(jQuery);
(function ($) {
    'use strict';

    /*[ NoUISlider Config ]
    ===========================================================*/

    try {
        var html5Slider = document.getElementById('pricepicker');
        if (html5Slider !== null) {
            noUiSlider.create(html5Slider, {
                start: [ 10, 62 ],
                connect: true,
                step: 1,
                range: {
                    'min': 10,
                    'max': 100
                }
            });
            var nodes = [document.getElementById('lower-value'), document.getElementById('upper-value')];
            html5Slider.noUiSlider.on('update', function( values, handle ) {
                nodes[handle].innerHTML = "$" + values[handle];
            });
        }

    } catch (err) {
        console.log(err);
    }


})(jQuery);
(function ($) {
    // USE STRICT
    "use strict";


    //-------------------------------------------------------
    // Header
    //-------------------------------------------------------

    try {
        // Hamburger Menu
        $('.hamburger').on('click', function () {
            $(this).toggleClass('is-active');
            $('.navbar-mobile').slideToggle('500');
        });
        $('.navbar-mobile__list li.has-sub > a').on('click', function () {
            var dropdown = $(this).siblings('ul.navbar-mobile__child');
            $(this).toggleClass('active');
            $(dropdown).slideToggle('500');
            return false;
        });
    } catch (err) {
        console.log(err)
    }

    try {
        // Header sticky
        var headerWrapper = $(".js-header-1");

        headerWrapper.each(function () {
            var that = $(this);
            var headerbar = that.find('.header__bar');

            var headerbarOffsetTop = headerbar.offset().top;
            var headerbarHeight = headerbar.outerHeight();

            headerbar.after("<div class='header__holder'></div>");

            $(window).on('scroll', function () {
                if ($(window).scrollTop() > headerbarOffsetTop) {
                    $('.header__holder').css('height', headerbarHeight);
                    headerbar.addClass('header--fixed');
                } else {
                    headerbar.removeClass("header--fixed");
                    $('.header__holder').css('height', 0);
                }
            });
        });
    } catch (error) {
        console.log(error);
    }


})(jQuery);

(function ($) {
    'use strict';

    /*[ Video player ]
    ===========================================================*/

    try {

        var videoPlayerHandle = $('.js-video-player');

        videoPlayerHandle.each(function () {
            var that = $(this);
            var videoPlayerBtn = that.find('.video__overlay');
            var videoPlayerContent = that.find('.video__content');

            var imagesURLs = that.find('.video__cover').attr('src');
            that.css('background-image', 'url(' + imagesURLs + ')');

            videoPlayerBtn.on('click', function (e) {
                videoPlayerContent.children('iframe')[0].src += "rel=0&autoplay=1";
                videoPlayerContent.css('opacity', 1);
                $(this).fadeOut('fast');
                e.preventDefault();
            })

        });

    } catch(err) {
        console.log(err)
    }
})(jQuery);


(function ($) {
    // USE STRICT
    "use strict";

    try {
        var targetModal = $('.js-modal-video');

        targetModal.each(function () {
            var that  = $(this);
            var idVideo = that.data("target");
            var video_content = $(idVideo).find('.modal-video__video');
            var modal_dialog = $(idVideo).find('.modal-dialog');
            var srcOld = video_content.children('iframe').attr('src');
            that.on("click", function () {
                video_content.children('iframe')[0].src += "&autoplay=1";
                setTimeout(function(){
                    $(idVideo).find('.modal-video__video').css('opacity', '1');
                }, 300);
            });

            $(idVideo).on("hidden.bs.modal", function () {
                video_content.children('iframe')[0].src  = srcOld;
                $(this).find('.modal-video__video').css('opacity', '0');
            });

            $(idVideo).on("hide.bs.modal", function (e) {
                modal_dialog.attr("class", "modal-dialog modal-video__dialog animated fadeOut");
            });

            $(idVideo).on('show.bs.modal', function (e) {
                modal_dialog.attr("class", "modal-dialog modal-video__dialog animated fadeIn");
            });
        });

    } catch(err) {
        console.log(err)
    }

})(jQuery);
(function ($) {
    'use strict';

    /*[ TO TOP ]
    ===========================================================*/

    try {
        // Back To Top
        var offset = 450;
        var duration = 500;
        var upToTop = $("#to-top");
        upToTop.hide();
        $(window).on('scroll', function () {
            if ($(this).scrollTop() > offset) {
                upToTop.fadeIn(duration);
            } else {
                upToTop.fadeOut(duration);
            }
        });

        upToTop.on('click', function (event) {
            event.preventDefault();
            $('html, body').animate({scrollTop: 0}, duration);
            return false;
        });
    } catch (err) {
        console.log(err);
    }


})(jQuery);
(function ($) {
    'use strict';

    /*[ Parallax ]
    ===========================================================*/

    try {
        var bgParallax = $('.js-parallax-scroll');
        var posWindow = $(window).scrollTop();
        var hWindow = $(window).height();
        var x = 0;
        var y = 3;

        bgParallax.each(function () {
            var that = $(this);
            var posParallax = that.offset().top;
            var hParallax = that.outerHeight();
            var setPosParallax = function() {
                if ($(window).width() > 992) {
                    if(bgParallax.outerHeight() < $(window).height()) {

                        x = that.offset().top - $(window).scrollTop();

                        $(that).css('background-position','center '+(x/y)+'px');
                    }
                    else {
                        $(that).css('background-position','center', 'center');
                    }
                } else {
                    $(that).css('background-attachment','scroll');
                }
            };

            setPosParallax();

            $(window).on('resize', function(){
                setPosParallax();
            });

            $(window).on('scroll',function(){
                setPosParallax();
            });
        });
    } catch(err) {
        console.log(err);
    }

})(jQuery);
(function ($) {
    // USE STRICT
    "use strict";
    try {
        $('.js-qty').each(function () {
            var spinner = $(this),
                input = spinner.find('input[type="number"]'),
                btnUp = spinner.find('.qty-btn--up'),
                btnDown = spinner.find('.qty-btn--down'),
                min = input.attr('min'),
                max = input.attr('max');

            btnUp.on('click', function () {
                var oldValue = parseFloat(input.val());
                var newVal = oldValue + 1;
                spinner.find("input").val(newVal);
                spinner.find("input").trigger("change");
            });

            btnDown.on('click', function () {
                var oldValue = parseFloat(input.val());
                if (oldValue <= min) {
                    var newVal = oldValue;
                } else {
                    var newVal = oldValue - 1;
                }
                spinner.find("input").val(newVal);
                spinner.find("input").trigger("change");
            });


        });
    } catch (error) {
        console.log(error);
    }


})(jQuery);
(function ($) {
    // USE STRICT
    "use strict";

    //-------------------------------------------------------
    // CHECKOUT
    //-------------------------------------------------------

    try {
        
        var radio_input = $('.js-radio-input');
        var content = $('.js-radio-content');

        radio_input.each(function(){
            var that = $(this);
            that.on('change', function(){
                if(that.is(':checked')) {
                    content.slideUp(300);
                    that.parent().parent().find('.js-radio-content').slideDown(300);
                }
            });
        });

    } catch (error) {
        console.log(error);
    }
    
  
})(jQuery);





