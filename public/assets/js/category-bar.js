$(() => {
  $('.js-category-bar').on('click', e => {
    e.stopPropagation()

    $(e.delegateTarget)
      .children('div')
      .children('.a-category-bar__icon').toggleClass('toggled')

    $(e.delegateTarget).children('ul').slideToggle(300)
  })
})