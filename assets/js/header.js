document.addEventListener('DOMContentLoaded', () => {
  const body   = document.body;
  const toggle = document.querySelector('[data-header-toggle]');
  const panel  = document.querySelector('[data-header-panel]');

  if (!toggle || !panel) return;

  const OPEN = 'ls-nav-open';
  const BP   = 960;

  const openMenu = () => {
    body.classList.add(OPEN);
    toggle.setAttribute('aria-expanded', 'true');
    body.style.overflow = 'hidden';
  };

  const closeMenu = () => {
    body.classList.remove(OPEN);
    toggle.setAttribute('aria-expanded', 'false');
    body.style.overflow = '';
  };

  toggle.addEventListener('click', () => {
    body.classList.contains(OPEN) ? closeMenu() : openMenu();
  });

  // Sluit bij klik op link
  panel.addEventListener('click', e => {
    if (e.target.closest('a')) closeMenu();
  });

  // ESC sluit menu
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeMenu();
  });

  // Resize naar desktop = altijd sluiten
  window.addEventListener('resize', () => {
    if (window.innerWidth >= BP) closeMenu();
  });
});
