(function () {

  function initPartnersMarquee(root = document) {
    if (!window.gsap || !window.ScrollTrigger) return;

    gsap.registerPlugin(ScrollTrigger);

    root.querySelectorAll('.ls-partners-slider').forEach((slider) => {
      const viewport = slider.querySelector('.ls-partners-slider__viewport');
      const track = slider.querySelector('.ls-partners-slider__track[data-ls-marquee="true"]');
      if (!viewport || !track) return;

      // voorkom dubbel init
      if (track.dataset.lsMarqueeInit === '1') return;
      track.dataset.lsMarqueeInit = '1';

      const originalItems = Array.from(track.children);
      if (!originalItems.length) return;

      /* --------------------------------------------------
         1. Set vullen tot viewport breedte
      -------------------------------------------------- */

      const viewportW = viewport.clientWidth;
      let setW = track.scrollWidth;

      while (setW < viewportW) {
        originalItems.forEach(el => track.appendChild(el.cloneNode(true)));
        setW = track.scrollWidth;
      }

      /* --------------------------------------------------
         2. Exacte set + duplicaat
      -------------------------------------------------- */

      const setItems = Array.from(track.children);
      const setWidthPx = track.scrollWidth;

      setItems.forEach(el => track.appendChild(el.cloneNode(true)));

      /* --------------------------------------------------
         3. Scroll-driven movement
      -------------------------------------------------- */

      gsap.fromTo(
  track,
  { x: 0 },
  {
    x: -setWidthPx,
    ease: 'none',
    scrollTrigger: {
      trigger: slider,
      start: 'top bottom',
      end: 'bottom top',
      scrub: 0.7,     // 🔑 inertie, niet strak
      invalidateOnRefresh: true
    }
  }
);

    });
  }

  /* --------------------------------------------------
     Async-safe init
  -------------------------------------------------- */

  let tries = 0;
  const interval = setInterval(() => {
    tries++;
    initPartnersMarquee(document);
    if (tries > 20) clearInterval(interval);
  }, 200);

})();
