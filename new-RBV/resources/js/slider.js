export function initSlider() {
    const slider = document.getElementById('slider');
    if (!slider) return;

    const totalSlides = slider.children.length;
    let index = 0;
    let direction = 1;

    setInterval(() => {
        index += direction;

        if (index === totalSlides - 1 || index === 0) {
            direction *= -1;
        }

        slider.style.transform = `translateX(-${index * 100}%)`;
    }, 3000);
}