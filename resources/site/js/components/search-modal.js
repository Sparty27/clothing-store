;(() => {

const modal = document.querySelector('[data-search-modal]')

if (!modal) return;

const close = document.querySelectorAll('[data-search-modal-close]')
const open = document.querySelectorAll('[data-search-modal-open]')

modal.addEventListener('click', () => {
    modal.classList.remove('open')
})

close.forEach((elem) => {
    elem.addEventListener('click', () => {
        modal.classList.remove('open')
    })
})

open.forEach((elem) => {
    elem.addEventListener('click', () => {
        modal.classList.add('open')
        modal.querySelector('input').focus()
    })
})

})()