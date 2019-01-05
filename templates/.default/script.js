$(function() {
    $('.owl-brand').owlCarousel({
        center: true,
        loop: false,
        margin: 30,
        nav: true,
        items: 2,
        smartSpeed: 700,
        responsive: {
            480: {
                items: 2
            },
            768: {
                items: 6
            },
            1024: {
                center: false,
                items: 8
            }
        }
    });
});