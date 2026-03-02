import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';
import 'swiper/css/pagination';

export function initSwiper() {
    console.log("Swiper file kebaca");
    const swiperElement = document.querySelector(".mySwiper");
    if (!swiperElement) return;

    new Swiper(".mySwiper", {
        slidesPerView: 4,
        spaceBetween: 20,
        grabCursor: true,
        preventClicks: false,
        preventClicksPropagation: false,
        slideToClickedSlide: false,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            1024: { slidesPerView: 4 },
            768: { slidesPerView: 2 },
            480: { slidesPerView: 1 },
        },
    });
}