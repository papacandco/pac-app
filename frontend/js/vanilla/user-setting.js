$('[name="update_password"]').click(function (e) {
  var disabled = $('[name="password"]').attr('disabled')
  $('[name="password"]').attr('disabled', !disabled)
  $('[name="password_confirmation"]').attr('disabled', !disabled)
})

let timout
let route = $('[data-theme-route]').data('theme-route')

$('[name="patch"]').click(function () {
  if (typeof timout !== 'undefined') {
    clearTimeout(timout)
  }

  timout = setTimeout(function () {
    $.ajax({
      url: route,
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      }
    })
  }, 1000)
})
