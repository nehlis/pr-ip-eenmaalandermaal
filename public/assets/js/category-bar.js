$(() => {
  const mainMenuItem = $('.js-category-bar-main')
  const subMenuItem  = $('.js-category-bar-sub')

  mainMenuItem.on('click', e => {
    e.stopPropagation()

    $(e.delegateTarget)
      .children('div')
      .children('.a-category-bar__icon').toggleClass('toggled')

    $(e.delegateTarget).children('ul').slideToggle(300)
  })

  subMenuItem.on('click', e => {
    e.stopPropagation()
  })
})