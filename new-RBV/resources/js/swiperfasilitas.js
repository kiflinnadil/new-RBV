import Swiper from 'swiper';
import { Pagination, Navigation, Autoplay } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';

export function initSwiperFasilitas() {
    const el = document.querySelector('.swiper-fasilitas');
    if (!el) return;

    new Swiper(el, {
        modules: [Pagination, Navigation, Autoplay],
        slidesPerView: 1,
        spaceBetween: 0,
        centeredSlides: false,
        loop: true,
        grabCursor: true,
        speed: 600,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        pagination: {
            el: document.querySelector('.fasilitas-pagination'),
            clickable: true,
            bulletClass: 'swiper-pagination-bullet',
            bulletActiveClass: 'swiper-pagination-bullet-active',
            renderBullet: function (index, className) {
                return `<span class="${className}"></span>`;
            },
        },
        navigation: {
            nextEl: document.querySelector('.fasilitas-next'),
            prevEl: document.querySelector('.fasilitas-prev'),
        },
    });
}