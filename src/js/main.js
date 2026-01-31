/**
 * KT Terekol - Главный файл скриптов
 *
 * Точка входа для Vite сборки JS
 */

// Импорт стилей для Vite
import '../scss/main.scss';

// Модули
// import './modules/modal';

/**
 * Mobile Menu Toggle
 */
function initMobileMenu() {
  const toggle = document.getElementById('menu-toggle');
  const nav = document.getElementById('primary-nav');

  if (!toggle || !nav) return;

  toggle.addEventListener('click', () => {
    const isExpanded = toggle.getAttribute('aria-expanded') === 'true';

    // Toggle aria-expanded
    toggle.setAttribute('aria-expanded', !isExpanded);

    // Toggle menu visibility
    nav.classList.toggle('is-open');

    // Update aria-label
    toggle.setAttribute(
      'aria-label',
      isExpanded ? 'Открыть меню' : 'Закрыть меню'
    );
  });

  // Close menu on escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && nav.classList.contains('is-open')) {
      toggle.setAttribute('aria-expanded', 'false');
      nav.classList.remove('is-open');
      toggle.setAttribute('aria-label', 'Открыть меню');
      toggle.focus();
    }
  });

  // Close menu on click outside
  document.addEventListener('click', (e) => {
    if (
      nav.classList.contains('is-open') &&
      !nav.contains(e.target) &&
      !toggle.contains(e.target)
    ) {
      toggle.setAttribute('aria-expanded', 'false');
      nav.classList.remove('is-open');
      toggle.setAttribute('aria-label', 'Открыть меню');
    }
  });

  // Close menu on resize (when switching to desktop)
  let resizeTimer;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
      if (window.innerWidth >= 992 && nav.classList.contains('is-open')) {
        toggle.setAttribute('aria-expanded', 'false');
        nav.classList.remove('is-open');
        toggle.setAttribute('aria-label', 'Открыть меню');
      }
    }, 100);
  });
}

/**
 * Stats Counter Animation
 * Анимация цифр при появлении в viewport
 */
function initStatsCounter() {
  const counters = document.querySelectorAll('.kt-metrics__value[data-count]');

  if (!counters.length) return;

  // Форматирование числа с пробелами
  const formatNumber = (num) => {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
  };

  // Анимация счётчика
  const animateCounter = (element) => {
    const target = parseInt(element.dataset.count, 10);
    const duration = 2000; // мс
    const startTime = performance.now();

    const updateCounter = (currentTime) => {
      const elapsed = currentTime - startTime;
      const progress = Math.min(elapsed / duration, 1);

      // Easing: ease-out cubic
      const easeOut = 1 - Math.pow(1 - progress, 3);
      const current = Math.floor(easeOut * target);

      element.textContent = formatNumber(current);

      if (progress < 1) {
        requestAnimationFrame(updateCounter);
      } else {
        element.textContent = formatNumber(target);
      }
    };

    requestAnimationFrame(updateCounter);
  };

  // IntersectionObserver для запуска при появлении
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          animateCounter(entry.target);
          observer.unobserve(entry.target); // Только один раз
        }
      });
    },
    {
      threshold: 0.3, // Запуск когда 30% элемента видно
      rootMargin: '0px 0px -50px 0px',
    }
  );

  counters.forEach((counter) => observer.observe(counter));
}

/**
 * Smooth scroll for anchor links
 */
function initSmoothScroll() {
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener('click', function (e) {
      const targetId = this.getAttribute('href');

      if (targetId === '#') return;

      const targetElement = document.querySelector(targetId);

      if (targetElement) {
        e.preventDefault();
        targetElement.scrollIntoView({
          behavior: 'smooth',
          block: 'start',
        });
      }
    });
  });
}

/**
 * Projects Slider (Swiper)
 */
function initProjectsSlider() {
  const sliderEl = document.getElementById('projects-slider');

  if (!sliderEl || typeof Swiper === 'undefined') return;

  new Swiper(sliderEl, {
    slidesPerView: 1,
    spaceBetween: 16,
    grabCursor: true,
    loop: false,

    // Responsive breakpoints
    breakpoints: {
      576: {
        slidesPerView: 2,
        spaceBetween: 20,
      },
      900: {
        slidesPerView: 3,
        spaceBetween: 24,
      },
    },

    // Navigation arrows (вынесены из swiper на уровень секции)
    navigation: {
      prevEl: '.projects-nav--prev',
      nextEl: '.projects-nav--next',
    },

    // Pagination dots
    pagination: {
      el: '.projects-slider__pagination',
      clickable: true,
    },
  });
}

/**
 * Projects Lightbox (GLightbox)
 */
function initProjectsLightbox() {
  if (typeof GLightbox === 'undefined') return;

  const galleryElements = document.querySelectorAll('.glightbox');

  if (!galleryElements.length) return;

  GLightbox({
    selector: '.glightbox',
    touchNavigation: true,
    loop: true,
    closeButton: true,
    zoomable: true,
  });
}

/**
 * Initialize
 */
document.addEventListener('DOMContentLoaded', () => {
  console.log('KT Terekol theme initialized');

  initMobileMenu();
  initSmoothScroll();
  initStatsCounter();
  initProjectsSlider();
  initProjectsLightbox();
});
