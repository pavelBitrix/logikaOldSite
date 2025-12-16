const swiper1 = new Swiper('.swiper-cards', {
  effect: 'cards', 
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
})

const swiper2 = new Swiper('.swiper-vendors', {
  speed: 4500,
  autoplay: { 
    delay: 1, 
    disableOnInteraction: false 
  },
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
      slidesPerView: 5,
      spaceBetween: 40
    }
  }
})