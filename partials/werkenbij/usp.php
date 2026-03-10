$usp_items = [
  [
    'title' => 'Unieke events & festivals',
    'text'  => 'Je werkt mee aan toonaangevende evenementen door heel Nederland.'
  ],
  [
    'title' => 'Hecht team',
    'text'  => 'Korte lijnen, veel verantwoordelijkheid en ruimte voor eigen initiatief.'
  ],
  [
    'title' => 'Groei & ontwikkeling',
    'text'  => 'We investeren in mensen, niet alleen in projecten.'
  ],
];
<section class="ls-section ls-section--soft">
  <div class="ls-container">
    <div class="ls-grid ls-grid--3">
      <?php foreach ($usp_items as $usp) : ?>
        <div class="ls-usp">
          <h3 class="h3"><?= esc_html($usp['title']); ?></h3>
          <p><?= esc_html($usp['text']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
