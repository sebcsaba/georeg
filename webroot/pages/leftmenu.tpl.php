<div>Loginfield</div>
<div>New event</div>
<span>Versenyek:</span>
<ul>
	<? foreach ($request->getData('events') as $event) { ?>
		<li><a href="javascript:openPage('Event',{id:<?h($event->getId())?>});"><?h($event->getName())?></a></li>
	<? } ?>
</ul>
