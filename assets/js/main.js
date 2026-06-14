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


document.addEventListener('DOMContentLoaded', function(){

    const counters = document.querySelectorAll('.counter');

    counters.forEach(counter => {

        const target = parseInt(
            counter.getAttribute('data-count')
        );

        let count = 0;

        const speed = target / 60;

        const updateCounter = () => {

            if(count < target){

                count += speed;

                counter.innerText =
                    Math.ceil(count);

                requestAnimationFrame(
                    updateCounter
                );

            }else{

                counter.innerText =
                    target + '+';

            }

        };

        updateCounter();

    });

});