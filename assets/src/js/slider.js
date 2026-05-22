import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

document.querySelectorAll('.wp-block-starter-theme-slider').forEach((el) => {
    new Swiper(el, {
        modules: [Navigation, Pagination, Autoplay],
        loop: el.dataset.loop === 'true',
        speed: parseInt(el.dataset.speed, 10) || 500,
        autoplay:
            el.dataset.autoplay === 'true' ? { delay: 3000, disableOnInteraction: false } : false,
        pagination: { el: el.querySelector('.swiper-pagination'), clickable: true },
        navigation: {
            nextEl: el.querySelector('.swiper-button-next'),
            prevEl: el.querySelector('.swiper-button-prev'),
        },
    });
});
