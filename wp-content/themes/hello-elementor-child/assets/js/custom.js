document.addEventListener('DOMContentLoaded', function () {

    document.addEventListener('change', function (e) {
        if (e.target.closest('.product-filters select')) {
            const url = new URL(window.location.href);

            document.querySelectorAll('.product-filters select').forEach(select => {
                if (select.value) {
                    url.searchParams.set(select.name, select.value);
                } else {
                    url.searchParams.delete(select.name);
                }
            });

            window.location.href = url.toString();
        }
    });

    document.querySelectorAll('.slideshow-image').forEach(bgDiv => {

        const container = bgDiv.closest('.product-slideshow');
        if (!container) return;
        const thumbnails = container.querySelectorAll('.slideshow_source img');
        if (!thumbnails.length) return;

        let currentIndex = 0;
        let interval = null;
        const setActiveImage = (index) => {
            const src = thumbnails[index]?.getAttribute('src');
            if (!src) return;

            bgDiv.style.backgroundImage = `url(${src})`;
            bgDiv.style.backgroundSize = 'cover';
            bgDiv.style.backgroundPosition = 'center';
            bgDiv.style.backgroundRepeat = 'no-repeat';
            thumbnails.forEach(img => img.classList.remove('active'));
            thumbnails[index].classList.add('active');
            currentIndex = index;
        };

        const startSlideshow = () => {
            interval = setInterval(() => {
                const nextIndex = (currentIndex + 1) % thumbnails.length;
                setActiveImage(nextIndex);
            }, 3000);
        };

        const resetSlideshow = () => {
            clearInterval(interval);
            startSlideshow();
        };

        setActiveImage(0);
        //startSlideshow();

        thumbnails.forEach((img, index) => {
            img.addEventListener('click', () => {
                setActiveImage(index);
                resetSlideshow();
            });
        });
    });

    document.querySelectorAll('.cooking-tab-title').forEach(button => {
        button.addEventListener('click', function () {
            const tabId = this.dataset.tab;
            document.querySelectorAll('.cooking-tab-title').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.cooking-tab-content').forEach(tab => tab.classList.remove('active'));
            this.classList.add('active');
            document.getElementById(tabId)?.classList.add('active');
        });
    });

    const thumbSwiper = new Swiper('.productCatThumbs', {
        spaceBetween: 4,
        slidesPerView: "auto",
        watchSlidesProgress: true,
        slideToClickedSlide: true,
    });

    const mainSwiper = new Swiper('.productCatMain', {
        slidesPerView: 1,
        spaceBetween: 0,
        loop: true,
        // autoplay: {
        //     delay: 3500,
        //     disableOnInteraction: false,
        // },
        thumbs: {
            swiper: thumbSwiper,
        },
    });

    // var verticalSwiper = new Swiper(".timeline_slider", {
    //     direction: "vertical",
    //     slidesPerView: 3,
    //     spaceBetween: 16,
    //     autoHeight: true,
    //     loop: true,
    //     navigation: {
    //         nextEl: ".swiper-button-next",
    //         prevEl: ".swiper-button-prev",
    //     },
    // });

    const spaceBetween = 16;
    const slidesToShow = 3;

    const firstCard = document.querySelector(".timeline_card");

    if (!firstCard) return;

    const cardHeight = firstCard.offsetHeight;

    const swiperHeight =
        (cardHeight * slidesToShow) +
        (spaceBetween * (slidesToShow - 1));

    const swiperEl = document.querySelector(".timeline_slider");
    swiperEl.style.height = `${swiperHeight}px`;

    var verticalSwiper = new Swiper(".timeline_slider", {
        direction: "vertical",
        slidesPerView: slidesToShow,
        spaceBetween: spaceBetween,
        loop: true,
        centeredSlides: true,
        autoHeight: false,
        navigation: {
            nextEl: ".timeline_slider_wrapper .swiper-button-next",
            prevEl: ".timeline_slider_wrapper .swiper-button-prev",
        },
    });


    const famCards = document.querySelectorAll('.fam_card');
    let z = famCards.length;
    famCards.forEach(div => {
        div.style.zIndex = z;
        z--;
    });


});

//tikka tribe page image slider
var verticalSwiper = new Swiper(
  ".vertical-column.column-1, .vertical-column.column-3",
  {
    direction: "vertical",
    slidesPerView: "auto",
    loop: true,
    allowTouchMove: false,
    spaceBetween: 32,
    speed: 10000,
     observer: true,
    observeParents: true,
    autoplay: {
      delay: 0,
      disableOnInteraction: false,
    },
    breakpoints: {
      0: { spaceBetween: 18 },
      769: { spaceBetween: 32 },
    },
  }
);
var verticalSwiper2 = new Swiper(
  ".vertical-column.column-2, .vertical-column.column-4",
  {
    direction: "vertical",
    slidesPerView: "auto",
    loop: true,
    allowTouchMove: false,
    spaceBetween: 32,
    speed: 10000,
    observer: true,
    observeParents: true,
    autoplay: {
      delay: 0,
      reverseDirection: true,
      disableOnInteraction: false,
    },

    breakpoints: {
      0: { spaceBetween: 18 },
      769: { spaceBetween: 32 },
    },
  }
);



document.addEventListener('DOMContentLoaded', function () {

    const slides = document.querySelectorAll('.slide');
    const slideInner = document.querySelectorAll('.category-slide-inner');
    const dotsContainer = document.getElementById('dots');
    const wrapper = document.querySelector(".category-slider");
    if (!slideInner.length || !wrapper) return;
    let maxHeight = 0;
    slideInner.forEach(slide => {
        const height = slide.offsetHeight;
        if (height > maxHeight) {
            maxHeight = height;
        }
    });
    wrapper.style.height = maxHeight + "px";
    let current = 0;
    slides.forEach((_, index) => {
        const dot = document.createElement('span');
        dot.addEventListener('click', () => {
            current = index;
            updateSlides();
        });
        dotsContainer.appendChild(dot);
    });
    const dots = dotsContainer.querySelectorAll('span');
    function updateSlides() {
        slides.forEach((slide, index) => {
            slide.classList.remove('active', 'prev', 'next');
            dots[index].classList.remove('active');
            if (index === current) {
                slide.classList.add('active');
                dots[index].classList.add('active');
            }
            if (index === (current - 1 + slides.length) % slides.length) {
                slide.classList.add('prev');
            }
            if (index === (current + 1) % slides.length) {
                slide.classList.add('next');
            }
        });
    }
    document.getElementById('next').addEventListener('click', () => {
        current = (current + 1) % slides.length;
        updateSlides();
    });
    document.getElementById('prev').addEventListener('click', () => {
        current = (current - 1 + slides.length) % slides.length;
        updateSlides();
    });
    updateSlides();

    document.querySelectorAll('.custom-slider-wrap').forEach(section => {

        const swiperEl = section.querySelector('.swiper');
        if (!swiperEl || !swiperEl.swiper) return;

        const swiper = swiperEl.swiper;

        swiper.params.navigation = {
            nextEl: section.querySelector('.elementor-swiper-button-next'),
            prevEl: section.querySelector('.elementor-swiper-button-prev'),
        };

        swiper.navigation.init();
        swiper.navigation.update();
    });


});


/**
 * ----------- Printing Recipe and Copy Recipe-------------
 */
const printBtn = document.getElementById('print-btn');
if (printBtn) {
    printBtn.addEventListener('click', function (e) {
        e.preventDefault();
        window.print();
    });
}

const copyBtn = document.getElementById('copy-btn');
if (copyBtn) {
    copyBtn.addEventListener('click', async function () {

        const container = document.querySelector('.print-container');
        if (!container) return;

        const html = container.innerHTML;
        const text = container.innerText;

        try {
            await navigator.clipboard.write([
                new ClipboardItem({
                    'text/html': new Blob([html], { type: 'text/html' }),
                    'text/plain': new Blob([text], { type: 'text/plain' })
                })
            ]);
        } catch (err) {
            fallbackCopy(text);
        }
    });
}
function fallbackCopy(text) {
    const textarea = document.createElement('textarea');
    textarea.value = text;
    document.body.appendChild(textarea);
    textarea.select();
    document.execCommand('copy');
    textarea.remove();
}