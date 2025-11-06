const slides = document.querySelectorAll('.slide');
let current = 0;

function showSlide(index) {
  slides.forEach((s) => s.classList.remove('active'));
  slides[index].classList.add('active');
}

document.querySelector('.slider-btn.next').addEventListener('click', () => {
  current = (current + 1) % slides.length;
  showSlide(current);
});

document.querySelector('.slider-btn.prev').addEventListener('click', () => {
  current = (current - 1 + slides.length) % slides.length;
  showSlide(current);
});

// Auto-slide cada 5 segundos
setInterval(() => {
  current = (current + 1) % slides.length;
  showSlide(current);
}, 5000);
