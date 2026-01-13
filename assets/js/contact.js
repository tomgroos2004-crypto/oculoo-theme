document.addEventListener('submit', async (e) => {
  const form = e.target.closest('.ls-contact-form-el');
  if (!form) return;

  e.preventDefault();

  const fd = new FormData(form);

  try {
    const res = await fetch(form.action, {
      method: 'POST',
      body: fd,
      headers: { 'Accept': 'application/json' }
    });

    if (res.ok) {
      form.reset();
      alert('Bedankt! Je bericht is verzonden.');
    } else {
      alert('Versturen mislukt.');
    }
  } catch {
    alert('Netwerkfout.');
  }
});
