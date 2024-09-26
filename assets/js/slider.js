jQuery(document).ready(function($) {
    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 1,
        spaceBetween: 10,
        loop: true, // Enable continuous loop mode
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
		 breakpoints: {
        1440: {
            slidesPerView: 3,
        },	
		767: {
            slidesPerView: 2,
        }	
		 
    }
    });

    var swiper = new Swiper('.testimonials-swiper-container', {
        slidesPerView: 1,
        spaceBetween: 10,
        loop: true, // Enable continuous loop mode
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
});
