var swiper = new Swiper(".faq_swiper", {
    slidesPerView: 1,
    spaceBetween:20,
    breakpoints: {
        // when window width is >= 320px
        320: {
          slidesPerView: 1,
          spaceBetween: 20
        },
        // when window width is >= 480px
        768: {
          slidesPerView: 2,
          spaceBetween: 30
        },
        // when window width is >= 640px
        992: {
          slidesPerView:2 ,
          spaceBetween: 40
        }
      },
    pagination: {
        el: ".swiper-pagination",
        type: "fraction",
    },

    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});
const accordionHeaders = document.querySelectorAll('.the_accordion_header');

accordionHeaders.forEach(header => {
    header.addEventListener('click', () => {
        header.classList.toggle('active'); // کلاس active را اضافه یا حذف می‌کند
    });
});

