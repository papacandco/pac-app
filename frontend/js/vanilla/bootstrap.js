// window._ = require('lodash')
import Plyr from "./../../vendor/plyr/js/plyr"

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */
try {
  // window.Popper = require('popper.js').default
  window.$ = window.jQuery = require('jquery')

  require('bootstrap')
} catch (e) {}

window.axios = require('axios').default
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
window.Plyr = Plyr

let token = document.querySelector('meta[name="csrf-token"]')

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token')
}

window.strSlug = (str) => {
  str = str.replace(/^\s+|\s+$/g, '') // trim
  str = str.toLowerCase()

  // remove accents, swap ñ for n, etc
  var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;"
  var to = "aaaaeeeeiiiioooouuuunc------"
  for (var i = 0, l = from.length; i < l; i++) {
    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i))
  }

  str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
    .replace(/\s+/g, '-') // collapse whitespace and replace by -
    .replace(/-+/g, '-') // collapse dashes

  return str
}

window.showInfo = (message) => {
  $('#information-modal').find('#InformationMessageContainer').html(message)
  $('#information-modal').modal({show: true});
}
