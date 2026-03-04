import Swiper from 'swiper';
import { Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';

export function initSwiperFasilitas() {

    const el = document.querySelector('.swiper-fasilitas');
    if (!el) return;

    new Swiper(el, {
        modules: [Pagination],
        slidesPerView: 1,
        spaceBetween: 30,
        centeredSlides: true,
        loop: true,
        grabCursor: true,
        pagination: {
            el: el.querySelector('.swiper-pagination'),
            clickable: true,
        },
        breakpoints: {
            768: { slidesPerView: 2, spaceBetween: 40 },
            1024: { slidesPerView: 3, spaceBetween: 50 }
        }
    });
}