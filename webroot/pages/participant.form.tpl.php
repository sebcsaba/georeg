<div><?h($t('participant.form.title'))?></div>
<form method="post" onsubmit="submitForm($(this));return false;">
	<input type="hidden" name="do" value="SaveParticipant"/>
	<input type="hidden" id="f_event_id" name="event_id" value="<?h($event->getId())?>"/>
	<table>
		<tr>
			<th><?h($t('participant.form.player.name'))?></th>
			<th><?h($t('participant.form.player.email'))?></th>
			<th><?h($t('participant.form.player.phone'))?></th>
		</tr>
		<tr id="player_template_row">
			<td>
				<input name="player_name[]" class="duplicator"/>
			</td>
			<td>
				<input name="player_email[]" class="duplicator"/>
			</td>
			<td>
				<input name="player_phone[]" class="duplicator"/>
			</td>
		</tr>
	</table>
	
	<div>
		<label for="f_reg_number"><?h($t('participant.form.reg_number'))?></label>
		<input type="text" id="f_reg_number" name="reg_number" value=""/>
	</div>
	<div>
		<label for="f_car_type"><?h($t('participant.form.car_type'))?></label>
		<input type="text" id="f_car_type" name="car_type" value=""/>
	</div>
	<div>
		<label for="f_car_reg_number"><?h($t('participant.form.car_reg_number'))?></label>
		<input type="text" id="f_car_reg_number" name="car_reg_number" value=""/>
	</div>
	<?php if ($event->getInternational()) { ?>
		<div>
			<label for="f_country"><?h($t('participant.form.country'))?></label>
			<input type="text" id="f_country" name="country" value=""/>
		</div>
		<div>
			<label for="f_additional_guests"><?h($t('participant.form.additional_guests'))?></label>
			<input type="text" id="f_additional_guests" name="additional_guests" value=""/>
		</div>
	<?php } ?>
	<div>
		<label for="f_comment"><?h($t('participant.form.comment'))?></label>
		<input type="text" id="f_comment" name="comment" value=""/>
	</div>
	
	<input type="submit" value="<?h($t('general.save'))?>"/>
</form>

<script type="text/javascript">
$(document).ready(function(){
	$('tr#player_template_row input.duplicator').focus(function(){
		var templateRow = $('tr#player_template_row');
		var newRow = $('<tr>'+templateRow.html()+'</tr>');
		templateRow.before(newRow);
		newRow.find('input').first().focus();
	});
});
</script>
