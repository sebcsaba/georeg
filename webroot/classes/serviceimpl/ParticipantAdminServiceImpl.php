<?php

class ParticipantAdminServiceImpl extends DbServiceBase implements ParticipantAdminService {
	
	/**
	 * Stores the given new participant to the event referenced in it.
	 * If registration period is over, throws an exception.
	 * Returns the id of the new participant
	 * 
	 * @param GeoUser $user
	 * @param Participant $participant
	 * @return int
	 * @throws Exception
	 */
	public function createParticipant(GeoUser $user, Participant $participant) {
		if ($participant->getEvent()->getEventDate()->isBefore(new Timestamp())) {
			throw new DataAccessException('the registration period is over');
		}
		$stmt = InsertBuilder::create()
			->into('participant')
			->set('fk_event', $participant->getEvent()->getId())
			->set('reg_number', $participant->getRegNumber())
			->set('car_type', $participant->getCarType())
			->set('car_reg_number', $participant->getCarRegNumber())
			->set('country', $participant->getCountry())
			->set('additional_guests', $participant->getAdditionalGuests())
			->set('comment', $participant->getComment())
			->set('date', $participant->getDate());
		$participantId = $this->db->insert($stmt);
		$upd = UpdateBuilder::create()
			->update('participant')
			->where('id=?', $participantId);
		$this->insertPlayersForParticipant($participant, $upd);
		$this->db->exec($upd);
		return $participantId;
	}
	
	/**
	 * Updates the given participant.
	 * If the current user has no right to update the given participant, throws an exception.
	 * 
	 * @param GeoUser $user
	 * @param Participant $participant
	 * @throws Exception
	 */
	public function updateParticipant(GeoUser $user, Participant $participant) {
		if (!$user->isAdmin()) {
			throw new DataAccessException('only admin can update a participant');
		}
		$this->removePlayerReferences($participant);
		$existingPlayerIds = $this->collectNotNullPlayedIds($participant->getPlayers());
		$delPl = DeleteBuilder::create()
			->from('player')
			->where('fk_participant=?',$participant->getId())
			->where('not (id in (?))', join(',', $existingPlayerIds));
		$this->db->exec($delPl);
		$upd = UpdateBuilder::create()
			->update('participant')
			->set('reg_number', $participant->getRegNumber())
			->set('car_type', $participant->getCarType())
			->set('car_reg_number', $participant->getCarRegNumber())
			->set('country', $participant->getCountry())
			->set('additional_guests', $participant->getAdditionalGuests())
			->set('comment', $participant->getComment())
			->where('id=?', $participantId);
		$this->insertPlayersForParticipant($participant, $upd);
		$this->db->exec($upd);
	}
	
	/**
	 * Removes the given participant.
	 * If the current user has no right to remove the given participant, throws an exception.
	 * 
	 * @param GeoUser $user
	 * @param Participant $participant
	 * @throws Exception
	 */
	public function removeParticipant(GeoUser $user, Participant $participant) {
		if (!$user->isAdmin()) {
			throw new DataAccessException('only admin can remove a participant');
		}
		$this->removePlayerReferences($participant);
		$delPl = DeleteBuilder::create()
			->from('player')
			->where('fk_participant=?',$participant->getId());
		$this->db->exec($delPl);
		$delAppl = DeleteBuilder::create()
			->from('participant')
			->where('id=?',$participant->getId());
		$this->db->exec($delAppl);
	}
	
	/**
	 * Inserts a Player for the given participant.
	 * If The player does already have an id, returns that, and doesn't insert.
	 * 
	 * @param Player $player
	 * @param Participant $participant
	 * @return integer The id of the new player
	 */
	private function insertPlayer(Player $player, Participant $participant) {
		if (!is_null($player->getId())) {
			return $player->getId();
		}
		$stmt = InsertBuilder::create()
			->into('player')
			->set('fk_participant', $participant->getId())
			->set('name', $player->getName())
			->set('email', $player->getEmail())
			->set('phone', $player->getPhone());
		return $this->db->insert($stmt);
	}
	
	/**
	 * Goes over the players assigned for the participant, and:
	 * - inserts it to the database if needed,
	 * - sets it's id to the given driver, etc. fields in the update buidler
	 * 
	 * @param Participant $participant
	 * @param UpdateBuilder $upd
	 */
	private function insertPlayersForParticipant(Participant $participant, UpdateBuilder $upd) {
		foreach ($participant->getPlayers() as $player) {
			$plid = $this->insertPlayer($player, $participant);
			if ($player == $participant->getDriver()) {
				$upd->set('fk_driver', $plid);
			}
			if ($player == $participant->getNavigator()) {
				$upd->set('fk_navigator', $plid);
			}
			if ($player == $participant->getTechnicalDriver()) {
				$upd->set('fk_technical_driver', $plid);
			}
		}
	}
	
	/**
	 * Removed all the player references from the participant record
	 * 
	 * @param Participant $participant
	 */
	private function removePlayerReferences(Participant $participant) {
		$upd = UpdateBuilder::create()
			->update('participant')
			->set('fk_driver', null)
			->set('fk_navigator', null)
			->set('fk_technical_driver', null)
			->where('id=?',$participant->getId());
		$this->db->exec($upd);
	}
	
	/**
	 * Returns the ids of the given players.
	 * 
	 * @param array(Player) $players
	 * @return array(integer)
	 */
	private function collectNotNullPlayedIds(array $players) {
		$result = array();
		foreach ($players as $player) {
			if (!is_null($player->getId())) {
				$result []= $player->getId();
			}
		}
		return $result;
	}
	
}
