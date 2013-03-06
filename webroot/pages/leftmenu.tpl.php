<div>Loginfield</div>
<?php if ($request->getUser()->isAdmin()) { ?>
<div><a href="javascript:openPage('NewEvent');"><?h($t('left.new_event'))?></a></div>
<?php } ?>
<span><?h($t('left.events_list'))?></span>
<ul>
	<? foreach ($request->getData('events') as $event) { ?>
		<li><a href="javascript:openPage('Event',{id:<?h($event->getId())?>});"><?h($event->getName())?></a></li>
	<? } ?>
</ul>
