$(document).ready(function () {

    // ── MODAL ────────────────────────────────────────────────────
    $('.btn-modal').on('click', function () {
        var title = $(this).data('title');
        var body  = $(this).data('body');
        $('#modal-title').text(title);
        $('#modal-body').text(body);
        $('#modal-overlay').addClass('active');
    });

    $('#modal-close').on('click', function () {
        $('#modal-overlay').removeClass('active');
    });

    $('#modal-overlay').on('click', function (e) {
        if ($(e.target).is('#modal-overlay')) {
            $(this).removeClass('active');
        }
    });

    // ── SLIDER 1: EVENTOS ────────────────────────────────────────
    $('.slider-eventos').slick({
        dots: true,
        infinite: true,
        speed: 600,
        autoplay: true,
        autoplaySpeed: 2500,
        pauseOnHover: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 640,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false
                }
            }
        ]
    });

    // ── SLIDER 2: EQUIPO 
    $('.slider-equipo').slick({
        dots: true,
        infinite: true,
        speed: 600,
        autoplay: true,
        autoplaySpeed: 3500,
        pauseOnHover: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 640,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false
                }
            }
        ]
    });

});