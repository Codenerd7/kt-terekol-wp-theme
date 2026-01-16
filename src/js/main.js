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
 * Initialize
 */
document.addEventListener('DOMContentLoaded', () => {
  console.log('KT Terekol theme initialized');

  initMobileMenu();
  initSmoothScroll();
});
