<table class="participant_list">
	<tr>
		<th><?h($t('participant.form.reg_number'))?></th>
		<?php if ($event->getInternational()) { ?>
			<th><?h($t('participant.form.country'))?></th>
		<?php } ?>
		<th><?h($t('participant.form.driver'))?></th>
		<th><?h($t('participant.form.navigator'))?></th>
		<th><?h($t('participant.form.passengers'))?></th>
	</tr>
	<?php foreach ($request->getData('participants') as $participant) { ?>
		<tr>
			<td><?h($participant->getRegNumber())?></td>
			<?php if ($event->getInternational()) { ?>
				<td><img src="resources/flags/<?h($participant->getCountry())?>.png"/></td>
			<?php } ?>
			<td><?h($participant->getDriver()->getName())?></td>
			<td><?php if ($participant->getDriver() !== $participant->getNavigator()) {
				h($participant->getNavigator()->getName());
			} ?></td>
			<td><?h(join(', ', $participant->getOtherPlayersName()))?></td>
		</tr>
	<?php } ?>
</table>
