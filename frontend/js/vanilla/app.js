require('./bootstrap')
require('./hash-scroll')
require('./owl-carousel')

const players = document.querySelectorAll('.video-player')

Array.prototype.forEach.call(players, (element, index) => {
  const config = {
    youtube: {
      rel: 0,
      showinfo: 0,
    },
    hideControls: true,
    quality: 720,
    volume: 1
  }

  if (element.dataset.poster) {
    config.poster = element.dataset.poster
  }

  const player = new Plyr(element, config)
})

// Prevent all invalids links
$('a[href="#"]').on("click", e => {
  e.preventDefault()
})

// Ajaxify is the little system for help
// the ajax loading the application base on dataset
$('[data-ajaxify]').on("click", e => {
  e.preventDefault()
  let $this = $(e.target)
  if ($this.data('hidden-now')) {
    $($this.data('hidden')).fadeOut(100)
  }
  const method = $this.data('ajaxify-method') ?? "get"
  axios[method]($this.data('ajaxify'))
  .then(res => {
    if (res.data.ok) {
      if (res.data.message) {
        const $modal = $("#flash-info-session")
        $modal.find("#flash-info-message").html(res.data.message)
        $modal.modal({show: true})
      }
      if ($this.data('hidden-element')) {
        $($this.data('hidden-element')).fadeOut(100)
      }
    }
  })
})

// Load the syntax lighting
if ('hljs' in window) {
  hljs.initHighlightingOnLoad()
}

// Normalize the curriculum videa section container
let $curriculumVideoCcontainer = $('#curriculum-video-container')
if ($curriculumVideoCcontainer.length > 0) {
  $('#curriculum-video-list').css('height', $curriculumVideoCcontainer.height() + 2.3)
}

// Enable the popover functionality
if ($('[data-toggle="popover"]').length > 0) {
  $('[data-toggle="popover"]').popover()
}

// Add additonnal style in pre tag
if ($('pre').length > 0) {
  $('pre code').css('background-color', '#282828')
}

// Live authentification
let $modal = $('#challengePasswordRequire')
if ($('#challengePasswordRequire').length > 0) {
  $modal.modal({
    show: true,
    backdrop: false,
    keyboard: false
  })

  $modal.on('hide.bs.modal', () => {
    $modal.modal({show: true, backdrop: true})
  })
}

// The comment reply system
let $replyComment = $('.reply-comment')
let $commentFormContainer

if ($replyComment.length > 0) {
  $replyComment.on("click", function(e) {
    e.preventDefault()
    let $this = $(this)
    let commentId = $this.data('comment')
    if (typeof $commentFormContainer !== 'undefined') {
      $commentFormContainer.html('')
    }
    $commentFormContainer = $('#comment-form-conatiner-' + commentId)
    $commentFormContainer
    .html('<div style="margin-top: 15px">' + $('#comment-form').html() + '</div>')
    $commentFormContainer
    .find('button')
    .text('Répondre au commentaire')
    $commentFormContainer
    .find('form')
    .append(`<input type="hidden" value="${commentId}" name="comment_id" />`)
  })
}

window.codelearningclub = (function () {
  if (document.querySelector("html").classList.contains("dark-theme")) {
    $("pre code").css("background-color", "#282828");
    $("#highlight-css").attr(
      "href",
      "https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.0.3/styles/atom-one-dark.min.css"
    );
  } else {
    $("pre code").css("background-color", "unset");
    $("#highlight-css").attr(
      "href",
      "https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.0.3/styles/atom-one-light.min.css"
    );
  }
  function switchToTheme(value) {
    setStorageValue('code_learning_club_switch_to_theme', value)
  }

  function storageValueExists(name, value) {
    const result = sessionStorage.getItem(name)
    return result == value
  }

  function hideContractDialog() {
    const dialogs = document.querySelector('#cookie-contrat-message')
    if (dialogs) {
      $(dialogs).fadeOut(300)
    }
  }

  function showContractDialog() {
    const dialogs = document.querySelector('#cookie-contrat-message')
    if (dialogs) {
      $(dialogs).fadeIn()
    }
  }

  function setStorageValue(name, value) {
    sessionStorage.setItem(name, value)
  }

  if (storageValueExists('code_learning_club_contract_consent', 1)) {
    hideContractDialog()
  } else {
    showContractDialog()
  }

  // Theme manager
  const darkMode = document.querySelector('#dark-mode-button [name="dark-mode"]')
  const $themeNavbarButton = $("#change-theme-button")
  $themeNavbarButton.on("click", function(e) {
    e.preventDefault()
    const $this = $(this)
    const $icon = $this.find("i")
    if ($this.data("is-light")) {
      $("pre code").css("background-color", "#282828");
      $("#highlight-css").attr(
        "href",
        "https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.0.3/styles/atom-one-dark.min.css"
      );
      switchToTheme("dark")
      if (darkMode) {
        darkMode.checked = true;
      }
      $("html").addClass("dark-theme")
      $icon.removeClass("fa-sun").addClass("fa-moon")
      $this.data("is-light", false)
    } else {
      $("pre code").css("background-color", "unset");
      $("#highlight-css").attr(
        "href",
        "https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.0.3/styles/atom-one-light.min.css"
      );
      if (darkMode) {
        darkMode.checked = false;
      }
      switchToTheme("light")
      $this.data("is-light", true)
      $icon.removeClass("fa-moon").addClass("fa-sun")
      $("html").removeClass("dark-theme")
    }
  })

  if (storageValueExists('code_learning_club_switch_to_theme', 'dark')) {
    if (darkMode) {
      darkMode.checked = true
    }
    $themeNavbarButton.data("is-light", false)
    $themeNavbarButton
      .find("i")
      .removeClass("fa-sun")
      .addClass("fa-moon")
  } else {
    if (darkMode) {
      darkMode.checked = false
    }
    $themeNavbarButton.data("is-light", true)
    $themeNavbarButton
      .find("i")
      .removeClass("fa-moon")
      .addClass("fa-sun")
  }

  if (darkMode) {
    darkMode.addEventListener('click', function () {
      if (darkMode.checked) {
        switchToTheme('dark')
        $('html').addClass('dark-theme')
        $themeNavbarButton.data("is-light", false)
        $themeNavbarButton
          .find("i")
          .removeClass("fa-sun")
          .addClass("fa-moon")
      } else {
        switchToTheme('light')
        $('html').removeClass('dark-theme')
        $themeNavbarButton.data("is-light", true)
        $themeNavbarButton
          .find("i")
          .removeClass("fa-moon")
          .addClass("fa-sun")
      }
    })
  }

  // Close the form curriculum header
  $('#close-header').on("click", function (e) {
    let parentId = $(this).data("parent")
    let $parent = $("#forum-curriculum-" + parentId)
    $parent.fadeOut()
  })

  return {
    storageValueExists: storageValueExists,
    hideContractDialog: hideContractDialog
  }
})()
