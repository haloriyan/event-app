let touchStartX = 0
let touchStartY = 0
let touchEndX = 0
let touchEndY = 0

const gestureZone = document.querySelector('body')

gestureZone.addEventListener('touchstart', (e) => {
    touchStartX = e.changedTouches[0].screenX
    touchStartY = e.changedTouches[0].screenY
})

gestureZone.addEventListener('touchend', (e) => {
    touchEndX = e.changedTouches[0].screenX
    touchEndY = e.changedTouches[0].screenY
    handleGesture()
})