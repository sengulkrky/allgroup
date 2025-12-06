const ticker = document.getElementById("keywords");
const original = ticker.innerHTML;

while (ticker.scrollWidth < window.innerWidth * 3) {
    ticker.innerHTML += original;
}

let pos = 0;

function scrollTicker() {
    pos -= 0.25; 
    if (Math.abs(pos) >= ticker.scrollWidth / 2) {
        pos = 0;
    }

    ticker.style.transform = `translateX(${pos}px)`;
    requestAnimationFrame(scrollTicker);
}

scrollTicker();
