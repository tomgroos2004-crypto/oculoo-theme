<div class="ls-header-wrap">
  <header class="ls-header">
    <div class="ls-container">
      <div class="ls-header-inner">

        <!-- Logo -->
        <a
          class="ls-header-brand"
          href="<?= esc_url(home_url('/')); ?>"
          aria-label="Eventsuper home"
        >
          <img
            src="http://oculoo.local/wp-content/uploads/2026/03/LOGO-13-okt-1.png"
            alt="Eventsuper"
            loading="eager"
            decoding="async"
          >
        </a>

        <!-- Desktop nav -->
        <nav class="ls-header-nav" aria-label="Hoofdmenu">
          <a class="<?= (is_page('jouw-eventsuper') ? 'is-active' : ''); ?>" href="/jouw-eventsuper/">Onze producten</a>
          <a class="<?= (is_page('proef-de-sfeer') ? 'is-active' : ''); ?>" href="/proef-de-sfeer/">Over ons</a>
          <a class="<?= (is_page('samenwerken') ? 'is-active' : ''); ?>" href="/samenwerken/">Samenwerken</a>
          <a class="<?= (is_page('samenwerken') ? 'is-active' : ''); ?>" href="/samenwerken/">Log in</a>			

			
        </nav>

		  <a class="btn btn-secondary" href="/werken-bij-eventsuper/">
            Winkelmandje
          </a>
        <!-- Burger -->
        <button
          class="ls-header-burger"
          aria-label="Menu openen"
          aria-expanded="false"
          data-header-toggle
        >
        </button>

      </div>
    </div>
  </header>
</div>