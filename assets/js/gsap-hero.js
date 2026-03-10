(function () {
  /* =========================================================
     GSAP Motion – Single file (site-wide)
     - Keeps HOME hero + content widget intact
     - Adds Werken bij animations (ls-sfeer-hero + usp + vacatures + quote)
     - Keeps Sfeer grid cluster pulse
     - Fixes: no nested IIFEs, no global hard returns per page
     - Fixes: hero no longer targets only the first [data-hero]
     - Fixes: skyline/home hero never gets video/parallax motion
  ========================================================= */

  if (!window.gsap) return;

  const hasST = !!window.ScrollTrigger;
  if (hasST) gsap.registerPlugin(ScrollTrigger);

  const prefersReduced =
    window.matchMedia &&
    window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* =========================================================
     MOTION TOKENS (DESIGN SYSTEM)
  ========================================================= */

  const EASE = {
    reveal: 'expo.out',
    soft: 'power3.out',
    elastic: 'elastic.out(1, 0.5)',
    linear: 'none'
  };

  const MASS = {
    heavy: 1.2,
    medium: 0.7,
    light: 0.4
  };

  /* =========================================================
     HELPERS
  ========================================================= */

  function markInit(el, key = 'gsapInit') {
    if (!el) return false;
    if (el.dataset[key] === 'true') return false;
    el.dataset[key] = 'true';
    return true;
  }

  /* =========================================================
     HERO (GLOBAL) — DO NOT BREAK HOME
     - Targets ALL heroes with [data-hero]
     - Keeps your original behavior
     - Skyline/home hero: NO video scrub
       (guard: .ls-hero--home OR data-no-video-scrub="1")
  ========================================================= */

  function initHero() {
    const heroes = document.querySelectorAll('[data-hero]');
    if (!heroes.length) return false;

    let did = false;

    heroes.forEach((hero) => {
      if (!markInit(hero, 'gsapInit')) return;

      const content = hero.querySelector('.ls-hero-content');
      if (!content) return;

      did = true;

      const actions = hero.querySelector('.ls-hero-actions');
      const video   = hero.querySelector('.ls-hero-bg-video');
      const grain   = hero.querySelector('.ls-hero-grain');

      const isFestival = hero.classList.contains('is-festival');

      // Content reveal (as you had it)
      gsap.from(content, {
        y: isFestival ? 120 : 40,
        scale: isFestival ? 0.94 : 1,
        opacity: 0,
        filter: 'blur(6px)',
        duration: 1,
        ease: EASE.reveal,
        clearProps: 'transform,opacity,filter',
        scrollTrigger: hasST
          ? { trigger: hero, start: 'top 75%', once: true }
          : null
      });

      // Actions
      if (actions) {
        gsap.from(actions, {
          y: 48,
          rotation: -6,
          opacity: 0,
          duration: 0.65,
          ease: EASE.elastic,
          clearProps: 'transform,opacity',
          scrollTrigger: hasST
            ? { trigger: hero, start: 'top 70%', once: true }
            : null
        });
      }

      // Video scrub (DISABLED for skyline/home hero)
      const isHomeSkyline = hero.classList.contains('ls-hero--home');
      const blockVideoScrub = hero.dataset.noVideoScrub === '1';

      if (video && hasST && !prefersReduced && !isHomeSkyline && !blockVideoScrub) {
        gsap.to(video, {
          scale: 1.08,
          y: -28,
          ease: EASE.linear,
          scrollTrigger: {
            trigger: hero,
            start: 'top bottom',
            end: 'bottom top',
            scrub: MASS.heavy
          }
        });
      }

      // Grain loop
      if (grain && !prefersReduced) {
        gsap.to(grain, {
          backgroundPosition: '200% 200%',
          duration: 40,
          ease: EASE.linear,
          repeat: -1
        });
      }
    });

    return did;
  }

  /* =========================================================
     CONTENT WIDGET (GLOBAL) — DO NOT BREAK HOME
     - Same as your original
  ========================================================= */

  function initContentStagger() {
    const sections = document.querySelectorAll('[data-content]');
    if (!sections.length) return false;

    let did = false;

    sections.forEach((section) => {
      if (!markInit(section, 'gsapInit')) return;

      did = true;

      const items = [];
      const visual = section.querySelector('.ls-content-visual');

      ['.ls-content-text', '.ls-content-body', '.ls-content-cta'].forEach((sel) => {
        const el = section.querySelector(sel);
        if (el) items.push(el);
      });

      if (items.length) {
        gsap.from(items, {
          y: 24,
          opacity: 0,
          duration: 0.55,
          ease: EASE.soft,
          stagger: 0.12,
          clearProps: 'transform,opacity',
          scrollTrigger: hasST
            ? { trigger: section, start: 'top 80%', once: true }
            : null
        });
      }

      if (visual && hasST && !prefersReduced) {
        gsap.to(visual, {
          y: -36,
          ease: EASE.linear,
          scrollTrigger: {
            trigger: section,
            start: 'top 70%',
            end: 'bottom 30%',
            scrub: MASS.medium
          }
        });
      }
    });

    return did;
  }

  /* =========================================================
     SFEER GRID CLUSTERS (GLOBAL if items exist)
     - Your original cluster pulse, cleaned + idempotent
  ========================================================= */

  function initSfeerClusters() {
    if (!hasST) return false;

    const root = document.querySelector('[data-sfeer-grid]') || document;
    const items = Array.from(root.querySelectorAll('.ls-sfeer-item'));
    if (!items.length) return false;

    // Prevent double init per page
    const guardHost = (root === document ? document.documentElement : root);
    if (!markInit(guardHost, 'sfeerClustersInit')) return false;

    const CLUSTER_SIZE = 4;
    const clusters = [];

    for (let i = 0; i < items.length; i += CLUSTER_SIZE) {
      clusters.push(items.slice(i, i + CLUSTER_SIZE));
    }

    clusters.forEach((cluster) => {
      const triggerItem = cluster[0];

      ScrollTrigger.create({
        trigger: triggerItem,
        start: 'top 70%',
        once: true,
        onEnter: () => {
          cluster.forEach((item, i) => {
            setTimeout(() => item.classList.add('is-active'), i * 120);
          });

          setTimeout(() => {
            cluster.forEach((item) => item.classList.remove('is-active'));
          }, 1200);
        }
      });
    });

    return true;
  }

  /* =========================================================
     WERKEN BIJ (PAGE TEMPLATE)
     - Uses your template markup:
       .ls-sfeer-hero, .ls-usp, vacatures section, .ls-quote
     - No assumptions about body classes; we detect by presence
  ========================================================= */

  function initWerkenBij() {
    if (!hasST) return false;

    const hero = document.querySelector('.ls-sfeer-hero');
    if (!hero) return false; // not this template/page

    // Prevent double init
    if (!markInit(hero, 'werkenBijInit')) return false;

    let did = false;

    // HERO (ruig / statement)
    const content = hero.querySelector('.ls-sfeer-hero-content');
    const title = hero.querySelector('.ls-sfeer-hero-title');
    const lead  = hero.querySelector('.ls-sfeer-hero-lead');
    const hint  = hero.querySelector('.ls-sfeer-scrollhint');

    if (content) {
      did = true;

      const tl = gsap.timeline({
        scrollTrigger: { trigger: hero, start: 'top 80%', once: true }
      });

      tl.from(content, {
        y: 160,
        scale: 0.92,
        opacity: 0,
        duration: 0.9,
        ease: 'power4.out'
      });

      if (title) {
        tl.from(title, {
          y: 40,
          opacity: 0,
          duration: 0.6,
          ease: 'power3.out'
        }, '-=0.5');
      }

      if (lead) {
        tl.from(lead, {
          y: 24,
          opacity: 0,
          duration: 0.5,
          ease: 'power3.out'
        }, '-=0.45');
      }

      if (hint) {
        tl.from(hint, {
          y: 16,
          opacity: 0,
          duration: 0.4,
          ease: 'power2.out'
        }, '-=0.3');
      }
    }

    // USP GRID
    document.querySelectorAll('.ls-usp').forEach((usp, i) => {
      if (!markInit(usp, 'gsapInit')) return;

      did = true;

      gsap.from(usp, {
        x: -80,
        opacity: 0,
        duration: 0.45,
        ease: 'power3.out',
        delay: i * 0.08,
        scrollTrigger: { trigger: usp, start: 'top 85%', once: true }
      });
    });

    // VACATURES SECTION
    // Your vacatures section is: <section class="ls-section section-sm"> (non-soft) containing h2 + render
    const vacaturesSection = Array.from(document.querySelectorAll('section.ls-section'))
      .find((sec) => sec.querySelector('h2.h2') && !sec.classList.contains('ls-section--soft'));

    if (vacaturesSection && markInit(vacaturesSection, 'gsapInit')) {
      did = true;

      gsap.from(vacaturesSection, {
        y: 100,
        opacity: 0,
        duration: 0.7,
        ease: 'power3.out',
        scrollTrigger: { trigger: vacaturesSection, start: 'top 80%', once: true }
      });
    }

    // QUOTE
    const quote = document.querySelector('.ls-quote');
    if (quote && markInit(quote, 'gsapInit')) {
      did = true;

      const p = quote.querySelector('p');
      const footer = quote.querySelector('footer');

      const tl = gsap.timeline({
        scrollTrigger: { trigger: quote, start: 'top 88%', once: true }
      });

      tl.from(quote, {
        y: 120,
        opacity: 0,
        duration: 0.85,
        ease: 'power4.out'
      });

      if (p) {
        tl.from(p, {
          y: 36,
          opacity: 0,
          duration: 0.6,
          ease: 'power3.out'
        }, '-=0.4');
      }

      if (footer) {
        tl.from(footer, {
          y: 18,
          opacity: 0,
          duration: 0.45,
          ease: 'power2.out'
        }, '-=0.3');
      }
    }

    return did;
  }

  /* =========================================================
     ASYNC SAFE INIT
     - Re-scans a few times for late-rendered DOM
     - No dependency on return values for stopping early
  ========================================================= */

  let tries = 0;
  const interval = setInterval(() => {
    tries++;

    // Keep HOME intact:
    initHero();
    initContentStagger();

    // Optional modules if elements exist:
    initSfeerClusters();
    initWerkenBij();

    if (tries > 20) clearInterval(interval);
  }, 150);

})();
