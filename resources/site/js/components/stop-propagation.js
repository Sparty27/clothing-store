;(()=>{

const elems = document.querySelectorAll('[data-stop-propagation]')

elems.forEach((elem) => {
    elem.addEventListener('click', (event) => {
        event.stopPropagation()
    })
})

})()