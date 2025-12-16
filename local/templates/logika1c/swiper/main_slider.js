const swiper = new Swiper('.swiper', {
  // Default parameters
  virtual: {
      enabled: true,
    },
  slidesPerView: 3,
  speed: 4500,
  autoplay: { 
    delay: 1, 
    disableOnInteraction: false 
  },
  spaceBetween: 20,
  freemode: true,
  slideToClickedSlide: true,
  grabCursor: true,
  loop: true,
  // Responsive breakpoints
  breakpoints: {
    // when window width is >= 320px
    320: {
      slidesPerView: 2,
      spaceBetween: 20
    },
    // when window width is >= 480px
    480: {
      slidesPerView: 3,
      spaceBetween: 30
    },
    // when window width is >= 640px
    640: {
      slidesPerView: 4,
      spaceBetween: 40
    }
  }
})

var swiper = new Swiper(".swiper-vendors", {
  slidesPerView: 3,
  spaceBetween: 20,
  freemode: true,
  slideToClickedSlide: true,
  grabCursor: true,
  loop: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  breakpoints: {
    640: {
      slidesPerView: 3,
      spaceBetween: 20,
    },
    320: {
      slidesPerView: 1,
      spaceBetween: 100,
    },
  },
});

var swiper2 = new Swiper(".swiper-container2", {
  slidesPerView: 3,
  speed: 3500,
  autoplay: { 
    delay: 1, 
    reverseDirection: true,
    disableOnInteraction: false 
  },
  spaceBetween: 20,
  freemode: true,
  slideToClickedSlide: true,
  grabCursor: true,
  loop: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  breakpoints: {
    640: {
      slidesPerView: 3,
      spaceBetween: 20,
    },
    320: {
      slidesPerView: 1,
      spaceBetween: 100,
    },
  },
});

var swiper3 = new Swiper(".swiper-container3", {
  slidesPerView: 3,
  speed: 3000,
  autoplay: { 
    delay: 1, 
    disableOnInteraction: false 
  },
  spaceBetween: 20,
  freemode: true,
  slideToClickedSlide: true,
  grabCursor: true,
  loop: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  breakpoints: {
    640: {
      slidesPerView: 3,
      spaceBetween: 20,
    },
    320: {
      slidesPerView: 1,
      spaceBetween: 100,
    },
  },
});