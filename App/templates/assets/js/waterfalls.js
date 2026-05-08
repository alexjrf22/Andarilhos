  let currentSlide = 0;
  const slides = document.querySelectorAll('.carousel-slide');
  const dots = document.querySelectorAll('.carousel-dot');
  const nextBtn = document.querySelector('.carousel-next');
  const prevBtn = document.querySelector('.carousel-prev');

  function showSlide(n) {
    slides.forEach(slide => {
      slide.classList.remove('active', 'opacity-100');
      slide.classList.add('opacity-0');
    });
    dots.forEach(dot => {
      dot.classList.remove('active');
      dot.classList.add('bg-opacity-50');
    });
    
    slides[n].classList.remove('opacity-0');
    slides[n].classList.add('active', 'opacity-100');
    dots[n].classList.add('active');
    dots[n].classList.remove('bg-opacity-50');
  }

  function nextSlide() {
    currentSlide = (currentSlide + 1) % slides.length;
    showSlide(currentSlide);
  }

  function prevSlide() {
    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
    showSlide(currentSlide);
  }

  nextBtn.addEventListener('click', nextSlide);
  prevBtn.addEventListener('click', prevSlide);

  dots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
      currentSlide = index;
      showSlide(currentSlide);
    });
  });

  setInterval(nextSlide, 5000);