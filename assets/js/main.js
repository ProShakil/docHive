$(document).ready(function () {

    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('#backToTop').removeClass('d-none');
        } else {
            $('#backToTop').addClass('d-none');
        }
    });

    $('#backToTop').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 500);
    });

});