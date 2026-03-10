document.addEventListener('DOMContentLoaded', () => {
  const body   = document.body;
  const hero   = document.querySelector('.ls-hero');
  const toggle = document.querySelector('[data-header-toggle]');
  const panel  = document.querySelector('[data-header-panel]');

  const OPEN = 'ls-nav-open';
  const BP   = 960;

  /* ======================================================
     Mobile menu
  ====================================================== */

  if (toggle && panel) {

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

    // Klik op link sluit menu
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
  }

  /* ======================================================
     Hero scroll observer → sticky festival header
  ====================================================== */

  if (!hero) return;

  const observer = new IntersectionObserver(
    ([entry]) => {
      body.classList.toggle('is-scrolled', !entry.isIntersecting);
    },
    {
      threshold: 0,
      // exact 1px voorbij hero = actief
      rootMargin: '-1px 0px 0px 0px'
    }
  );

  observer.observe(hero);
});
