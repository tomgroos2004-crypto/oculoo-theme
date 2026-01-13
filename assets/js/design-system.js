(function () {

  function initDesignSystem(root) {
    const systems = root.querySelectorAll('.ls-design-system');

    systems.forEach(system => {
      if (system.dataset.dsInit) return; // voorkom dubbele init
      system.dataset.dsInit = 'true';

      const tabs = system.querySelectorAll('[data-ds-tab]');
      const panels = system.querySelectorAll('[data-ds-panel]');

      tabs.forEach(tab => {
        tab.addEventListener('click', () => {
          const index = tab.dataset.dsTab;

          tabs.forEach(t => t.classList.remove('is-active'));
          panels.forEach(p => p.classList.remove('is-active'));

          tab.classList.add('is-active');
          system.querySelector(`[data-ds-panel="${index}"]`)?.classList.add('is-active');
        });
      });
    });
  }

  // Init bij normale pageload
  document.addEventListener('DOMContentLoaded', () => {
    initDesignSystem(document);
  });

  // Init bij Elementor editor / dynamic renders
  if (window.elementorFrontend) {
    window.elementorFrontend.hooks.addAction(
      'frontend/element_ready/global',
      ($scope) => {
        initDesignSystem($scope[0]);
      }
    );
  }

})();
