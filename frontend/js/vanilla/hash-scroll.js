require('../../vendor/animate-scroll/index')

// Show the subnavbar
const $subNavbar = $('#sub-navbar');

if ($subNavbar.length > 0) {
  $(window).on("scroll", e =>
    window.pageYOffset > 500 ? $subNavbar.fadeIn(200) : $subNavbar.fadeOut(200)
  ).trigger('scroll')
}

// let location = window.location
// if (location.hash) {
//   let hash = location.hash
//   let [type, id] = hash.split('-')
//   if (type == '#pager') {
//     $("#curriculum-video-" + id).animatescroll({
//       element: "#curriculum-video-list",
//       scrollSpeed: 5000,
//       easing: 'easeInOutBack'
//     })
//   } else {
//     $("#scroll-element-" + id).animatescroll({
//       scrollSpeed: 3000,
//       easing: 'easeOutBack'
//     })
//   }
// }
