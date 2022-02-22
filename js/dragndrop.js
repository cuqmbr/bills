const draggables = document.querySelectorAll('.card')
const container = document.querySelector('.content')

draggables.forEach(draggable => {
    draggable.addEventListener('dragstart', () => {
        draggable.classList.add('dragging');
    })

    draggable.addEventListener('dragend', () => {
        draggable.classList.remove('dragging')
    })
})

container.addEventListener('dragover', e => {
    e.preventDefault()
    const afterElement = getDragAfterElement(container, e.clientX)
    console.log(afterElement)
    const draggable = document.querySelector('.dragging')
    if (afterElement == null) {
        container.appendChild(draggable)
    } else {
        container.insertBefore(draggable, afterElement)
    }
})

function getDragAfterElement (container, x) {
    const draggableElements = [...container.querySelectorAll('.draggable:not(.dragging)')]

    draggableElements.reduce((closest, child) => {
        const box = child.getBoundingClientRect()
        const offset = x - box.right - box.width / 2
        if (offset < 0 && offset > closest.offset) {
            return { offset: offset, element: child}
        } else {
            return closest
        }
    }, { offset:  Number.NEGATIVE_INFINITY }).element
}