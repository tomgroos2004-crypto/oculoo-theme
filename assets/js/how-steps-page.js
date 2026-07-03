document.addEventListener('DOMContentLoaded', () => {
  const sections = document.querySelectorAll('[data-how-steps]');
  if (!sections.length) return;

  sections.forEach((section) => {
    const tabs = section.querySelectorAll('[data-how-steps-tab]');
    const panels = section.querySelectorAll('[data-how-steps-panel]');
    if (!tabs.length || !panels.length) return;

    const activateTab = (tab) => {
      const panelId = tab.getAttribute('aria-controls');
      if (!panelId) return;

      tabs.forEach((item) => {
        const isActive = item === tab;
        item.classList.toggle('is-active', isActive);
        item.setAttribute('aria-selected', isActive ? 'true' : 'false');
      });

      panels.forEach((panel) => {
        const isActive = panel.id === panelId;
        panel.classList.toggle('is-active', isActive);
        panel.hidden = !isActive;
      });
    };

    tabs.forEach((tab) => {
      tab.addEventListener('click', () => activateTab(tab));
    });
  });
});
