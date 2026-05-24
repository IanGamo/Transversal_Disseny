$(document).ready(function () {

    // HOVER IMAGEN 
    $('.evento-foto').on('mouseenter', function () {
        $(this).find('.evento-hover-info').stop(true).fadeIn(250).css('display', 'flex');
        $(this).find('img').css('transform', 'scale(1.05)');
    });

    $('.evento-foto').on('mouseleave', function () {
        $(this).find('.evento-hover-info').stop(true).fadeOut(200);
        $(this).find('img').css('transform', 'scale(1)');
    });

});