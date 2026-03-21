document.addEventListener('DOMContentLoaded', () => {
  const body = document.body;
  const toggle = document.querySelector('[data-header-toggle]');
  const panel = document.querySelector('[data-header-panel]');

  const OPEN = 'ls-nav-open';
  const BP = 960;

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
