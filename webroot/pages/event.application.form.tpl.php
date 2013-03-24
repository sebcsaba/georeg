<?php $event = $request->getData('event'); ?>
<div class="eventData">
<h1><?h($event->getName())?></h1>
<h2><?h($event->getEventDate()->toDayString())?></h2>
<?php if ($event->getRegistrationEnd()->isBefore(new Timestamp())) { ?>
	<div>A regisztráció lezárult.</div>
<?php } else { ?>
	<div>Regisztrációs határidő: <?h($event->getRegistrationEnd()->toMinuteString())?></div>
<?php } ?>
<?php if ($event->getInternational()) { ?>
	<div>Ez egy nemzetközi verseny.</div>
<?php } ?>
</div>