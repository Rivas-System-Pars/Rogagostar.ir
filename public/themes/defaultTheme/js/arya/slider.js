arya = document.getElementById('newSwiper')




var swiper2 = new Swiper(arya, {
    spaceBetween: 30,
    loop: true,
    centeredSlides: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });



var faqSwiper = new Swiper(".faq_swiper", {
  slidesPerView: 1,
  spaceBetween: 20,
  breakpoints: {
      320: {
          slidesPerView: 1,
          spaceBetween: 20,
      },
      768: {
          slidesPerView: 2,
          spaceBetween: 30,
      },
      992: {
          slidesPerView: 2,
          spaceBetween: 40,
      },
  },
  autoplay: {
      delay: 2500, // Time between slide changes
      disableOnInteraction: false, // Ensure autoplay continues even after user interaction
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

const accordionHeaders = document.querySelectorAll(".the_accordion_header");
let autoplayTimeout;

accordionHeaders.forEach((header) => {
  header.addEventListener("click", () => {
      header.classList.toggle("active"); // Toggle the active class

      // Stop autoplay and set a timer to resume after 15 seconds
      faqSwiper.autoplay.stop();

      if (autoplayTimeout) {
          clearTimeout(autoplayTimeout); // Clear any existing timeout
      }

      autoplayTimeout = setTimeout(() => {
          faqSwiper.autoplay.start(); // Resume autoplay after 15 seconds
      }, 15000);
  });
});
