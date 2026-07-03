<?php
defined('ABSPATH') || exit;

$enabled = get_field('over_team_enabled');
if ((string) $enabled === '0') return;

$eyebrow       = get_field('over_team_eyebrow')       ?: 'Het team';
$title_main    = get_field('over_team_title_main')    ?: 'Vier ondernemers.';
$title_accent  = get_field('over_team_title_accent')  ?: 'Eén missie.';
$members       = get_field('over_team_members');
$mission_quote = get_field('over_team_mission_quote') ?: '"Een hulpmiddel hoort het probleem op te lossen. Niet gedeeltelijk — maar volledig."';
$mission_meta  = get_field('over_team_mission_meta')  ?: 'Oculoo — Easy as that';

if (empty($members) || !is_array($members)) {
  $members = [
    ['initials' => 'LB', 'name' => 'Lars van den Broek', 'role' => 'Co-founder'],
    ['initials' => 'ST', 'name' => 'Simon Terhürne',      'role' => 'Co-founder'],
    ['initials' => 'LS', 'name' => 'Lars Slomp',          'role' => 'Co-founder'],
    ['initials' => 'FO', 'name' => 'Friso Oude Tanke',    'role' => 'Co-founder'],
  ];
}
?>

<section class="over-team section-md">
  <div class="ls-container">

    <header class="over-team__head">
      <div class="over-team__title-wrap">
        <?php if ($eyebrow) : ?>
          <p class="over-team__eyebrow"><?= esc_html($eyebrow); ?></p>
        <?php endif; ?>

        <?php if ($title_main || $title_accent) : ?>
          <h2 class="over-team__title">
            <?php if ($title_main) : ?><span><?= esc_html($title_main); ?></span><?php endif; ?>
            <?php if ($title_accent) : ?> <em><?= esc_html($title_accent); ?></em><?php endif; ?>
          </h2>
        <?php endif; ?>
      </div>

    </header>

    <?php if (!empty($members)) : ?>
      <div class="over-team__grid">
        <?php foreach ($members as $member) :
          $initials = isset($member['initials']) ? strtoupper(trim((string) $member['initials'])) : '';
          $name     = isset($member['name'])     ? trim((string) $member['name'])     : '';
          $role     = isset($member['role'])     ? trim((string) $member['role'])     : '';
          if ($name === '' && $role === '') continue;
        ?>
          <article class="over-team-card">
            <?php if (!empty($member['photo']) && !empty($member['photo']['url'])) : ?>
              <div class="over-team-card__avatar over-team-card__avatar--photo">
                <img src="<?= esc_url($member['photo']['sizes']['large'] ?? $member['photo']['url']); ?>"
                     alt="<?= esc_attr($member['photo']['alt'] ?? $name); ?>"
                     loading="lazy">
              </div>
            <?php else : ?>
              <div class="over-team-card__avatar"><?= esc_html($initials ?: mb_substr($name, 0, 1)); ?></div>
            <?php endif; ?>
            <?php if ($name !== '') : ?><h3><?= esc_html($name); ?></h3><?php endif; ?>
            <?php if ($role !== '') : ?><p class="over-team-card__role"><?= esc_html($role); ?></p><?php endif; ?>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if ($mission_quote || $mission_meta) : ?>
      <div class="over-team__mission">
        <?php if ($mission_quote) : ?>
          <p class="over-team__mission-quote"><?= esc_html($mission_quote); ?></p>
        <?php endif; ?>
        <?php if ($mission_meta) : ?>
          <p class="over-team__mission-meta"><?= esc_html($mission_meta); ?></p>
        <?php endif; ?>
      </div>
    <?php endif; ?>

  </div>
</section>
