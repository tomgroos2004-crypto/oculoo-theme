<?php
/**
 * LeadSprint – Header (v4)
 * Simpel, hiërarchisch, tabs-driven pages
 */
?>

<header class="ls-header" data-header>
  <div class="ls-container">
    <div class="ls-header-inner">

      <!-- Logo -->
      <a class="ls-header-brand" href="<?= esc_url(home_url('/')); ?>" aria-label="LeadSprint home">
        <img
          src="https://leadsprint.nl/wp-content/uploads/2025/08/Logo-zonder-achtergrond-leadsprint.png"
          alt="LeadSprint"
          loading="eager"
        >
      </a>

      <!-- Desktop nav -->
     <nav class="ls-header-nav" aria-label="Hoofdmenu">

  <div class="ls-nav-item ls-nav-item--has-children">
    <a href="/onze-diensten/">Onze Diensten</a>

    <div class="ls-nav-dropdown">
      <a href="/leadgeneratie/">Leadgeneratie</a>
      <a href="/website-op-maat/">Websites & webshops</a>
      <a href="/e-mailmarketing/">E-mailmarketing</a>
    </div>
  </div>

  <a href="/cases/">Cases</a>
  <a href="/kennis/">Kennis</a>
  <a href="/over-ons/">Over ons</a>

  <a class="btn btn-primary js-sprint-cta" href="/contact">
    Plan je sprint
  </a>

</nav>


      <!-- Burger -->
      <button
        class="ls-header-burger"
        aria-label="Menu openen"
        aria-expanded="false"
        data-header-toggle
      >
        <span></span>
      </button>

    </div>
  </div>
</header>

<!-- Mobile panel -->
<nav class="ls-header-panel" data-header-panel aria-label="Mobiel menu">

<a href="/leadgeneratie/" class="is-primary">Leadgeneratie</a>
<a href="/websites-en-webshops/" class="is-primary">Websites & webshops</a>

<a href="/cases/">Cases</a>
<a href="/kennis/">Kennis</a>
<a href="/over-ons/">Over ons</a>

<a class="ls-header-cta" href="/contact">Plan je sprint</a>


</nav>
