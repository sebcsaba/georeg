<div>Loginfield</div>
<?php if ($request->getUser()->isAdmin()) { ?>
<div><a href="javascript:openPage('NewEvent');">Új verseny</a></div>
<?php } ?>
<span>Versenyek:</span>
<ul>
	<? foreach ($request->getData('events') as $event) { ?>
		<li><a href="javascript:openPage('Event',{id:<?h($event->getId())?>});"><?h($event->getName())?></a></li>
	<? } ?>
</ul>
