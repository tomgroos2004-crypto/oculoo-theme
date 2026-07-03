document.addEventListener('DOMContentLoaded', () => {
  const forms = document.querySelectorAll('.ls-product-page form.variations_form');
  if (!forms.length) return;

  forms.forEach((form) => {
    const colorSelect = form.querySelector('select[name="attribute_pa_kleur"], select[name="attribute_kleur"]');
    if (!colorSelect) return;

    const colorRow = colorSelect.closest('tr');
    if (colorRow) {
      colorRow.style.display = 'none';
    }

    const swatchWrap = form.querySelector('[data-attribute_name="attribute_pa_kleur"], [data-attribute_name="attribute_kleur"]');
    if (swatchWrap) {
      swatchWrap.style.display = 'none';
    }

    if (!colorSelect.value) {
      const firstOption = Array.from(colorSelect.options).find((option) => option.value);
      if (firstOption) {
        colorSelect.value = firstOption.value;
        colorSelect.dispatchEvent(new Event('change', { bubbles: true }));
      }
    }
  });

  const accordion = document.querySelector('[data-product-accordion]');
  if (!accordion) return;

  const items = accordion.querySelectorAll('.ls-ph__acc-item');
  items.forEach((item) => {
    item.addEventListener('toggle', () => {
      if (!item.open) return;
      items.forEach((other) => {
        if (other !== item) other.open = false;
      });
    });
  });
});
