import './bootstrap';
import { initSlider } from './slider';
import { initSwiper } from './swiper-init';
import { initChart } from './chart';
import { initSwiperFasilitas } from './swiperfasilitas';

document.addEventListener('DOMContentLoaded', () => {
    initSlider();
    initSwiper();
    initChart();
    initSwiperFasilitas();


    const section = document.querySelector('#fasilitasSection');

    if (section) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    section.classList.add('active-section');
                } else {
                    section.classList.remove('active-section');
                }
            });
        }, { threshold: 0.5 });

        observer.observe(section);
    }

});