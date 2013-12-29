<?php $event = $request->getData('event'); ?>
<div class="eventData">
	<h1><?h($event->getName())?></h1>
	<h2><?h($event->getEventDate()->toDayString())?></h2>
	
	<?php if ($event->isRegistrationOpen()) { ?>
		<div><?h($t('event.application.form.registrationDeadline'))?> <?h($event->getRegistrationEnd()->toMinuteString())?></div>
	<?php } else { ?>
		<div><?h($t('event.application.form.registrationClosed'))?></div>
	<?php } ?>
	
	<?php if ($event->getInternational()) { ?>
		<div><?h($t('event.application.form.internationalEvent'))?></div>
	<?php } ?>
</div>

<?php if (count($request->getData('participants'))) { ?>
	<?php foreach ($request->getData('participants') as $participant) { ?>
	<?php } ?>
<?php } else { ?>
	<div><?h($t('event.application.form.noParticipant'))?></div>
<?php } ?>
