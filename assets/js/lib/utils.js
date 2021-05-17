import $ from 'jquery';

$(document).ready(function() {
    // back to top
    let offset = 350;
    let duration = 800;
    $(window).scroll(function () {
        if (jQuery(this).scrollTop() > offset) {
            jQuery('.back-to-top').fadeIn(duration);
        } else {
            jQuery('.back-to-top').fadeOut('fast');
        }
    });

    $('.back-to-top').click(function (event) {
        event.preventDefault();
        jQuery('html, body').animate({scrollTop: 0}, duration);
        return false;
    });

    $(function () {
        $('a.page-scroll').bind('click', function (event) {
            var $anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: $($anchor.attr('href')).offset().top
            }, 2000, 'swing');
        });
    });

    function tog(value) {
        return value ? 'addClass' : 'removeClass';
    }

    $(document).on('input', '.clearable', function () {
        $(this)[tog(this.value)]('x');
    }).on('mousemove', '.x', function (e) {
        $(this)[tog(this.offsetWidth - 18 < e.clientX - this.getBoundingClientRect().left)]('onX');
    }).on('touchstart click', '.onX', function (ev) {
        ev.preventDefault();
        $(this).removeClass('x onX').val('').change();
    }).on('focusout', '.clearable', function () {
        $(this).removeClass('x onX');
    });

    // close alert box
    window.setTimeout(function () {
        $(".alert").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 2000);

    $('.onChangeSubmit').change(function(e){
        e.preventDefault();
        $('#loader').show();
        $(this).closest('form').trigger('submit');
    });

    let birthdate = flatpickr('#user_birthdate', {
        locale: 'en',
        weekNumbers: true
    });
});