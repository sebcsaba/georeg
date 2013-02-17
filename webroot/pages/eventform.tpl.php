<?php $event = $request->getData('event'); ?>
<div><?h($request->getData('title'))?></div>
<form method="post" onsubmit="submitForm($(this));return false;">
	<input type="hidden" name="do" value="SaveEvent"/>
	<input type="hidden" name="id" value="<?h($event->getId())?>"/>
	
	<div>
		<label for="f_name">Név</label>
		<input type="text" id="f_name" name="name" value="<?h($event->getName())?>"/>
	</div>
	
	<div>
		<label for="f_eventDate">Dátum</label>
		<input type="text" id="f_eventDate" name="eventDate" value="<?h($event->getEventDate()->toDayString())?>"/>
	</div>
	
	<div>
		<label for="f_registrationEnd">Nevezési határidő</label>
		<input type="text" id="f_registrationEnd" name="registrationEnd" value="<?h($event->getRegistrationEnd()->toDayString())?>"/>
		<input type="text" name="registrationEndTime" value="<?h($event->getRegistrationEnd()->toUserString('H:i'))?>"/>
	</div>
	
	<div>
		<label for="f_international">Nemzetközi</label>
		<input type="checkbox" id="f_international" name="international"
			<?php if($event->getInternational()) { print('checked="checked"'); } ?> />
	</div>
	
	<div>
		<input type="submit"/>
	</div>
	
</form>

<script type="text/javascript">
$('#f_eventDate').datepicker({dateFormat:'yy-mm-dd'});
$('#f_registrationEnd').datepicker({dateFormat:'yy-mm-dd'});
</script>