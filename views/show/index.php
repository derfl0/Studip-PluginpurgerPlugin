<? if ($purge): ?>
    <?= Studip\Button::create(_('Bereinigen')) ?>
<? else: ?>
    <?= _('Nichts zu reinigen. Alles scheint zu funktionieren.') ?>
<? endif; ?>
