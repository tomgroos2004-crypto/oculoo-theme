document.addEventListener('DOMContentLoaded', () => {
  const body = document.body;
  const toggle = document.querySelector('[data-header-toggle]');
  const panel = document.querySelector('[data-header-panel]');
  const headerWrap = document.querySelector('.ls-header-wrap');

  const OPEN = 'ls-nav-open';
  const BP = 960;

  /* Scroll state — toggle "is-scrolled" on the header wrap so it can
     transition from transparent (over the hero) to a floating glass card. */
  if (headerWrap) {
    const SCROLL_TRIGGER = 24;
    const setScrolled = () => {
      if (window.scrollY > SCROLL_TRIGGER) {
        headerWrap.classList.add('is-scrolled');
      } else {
        headerWrap.classList.remove('is-scrolled');
      }
    };

    setScrolled();
    window.addEventListener('scroll', setScrolled, { passive: true });
  }

  if (toggle && panel) {
    const openMenu = () => {
      body.classList.add(OPEN);
      toggle.setAttribute('aria-expanded', 'true');
    };

    const closeMenu = () => {
      body.classList.remove(OPEN);
      toggle.setAttribute('aria-expanded', 'false');
    };

    toggle.addEventListener('click', () => {
      body.classList.contains(OPEN) ? closeMenu() : openMenu();
    });

    panel.addEventListener('click', (e) => {
      if (e.target.closest('a')) closeMenu();
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeMenu();
    });

    window.addEventListener('resize', () => {
      if (window.innerWidth >= BP) closeMenu();
    });
  }
});
