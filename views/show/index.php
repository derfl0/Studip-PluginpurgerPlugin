<form>
<? if ($purge): ?>
    <? if ($purge['new']): ?>
        <h1><?= _('Neue Plugins:') ?></h1>
        <? foreach ($purge['new'] as $new): ?>
            <p><?= $new ?></p>
        <? endforeach; ?>
    <? endif; ?>
    <?= Studip\Button::create(_('Bereinigen'), 'clean') ?>
<? else: ?>
    <?= _('Nichts zu reinigen. Alles scheint zu funktionieren.') ?>
<? endif; ?>
</form>