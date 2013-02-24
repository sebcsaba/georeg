<?php

class ParticipantLoadServiceImpl extends DbServiceBase implements ParticipantLoadService {
	
	/**
	 * Returns the participants list for the given event.
	 * 
	 * @param Event $event
	 * @return array(Participant)
	 */
	public function loadParticipants(Event $event) {
		$allPlayers = $this->createPlayerDaoListForEvent($event);
		$query = QueryBuilder::create()
			->from('participant')
			->where('fk_event=?', $event->getId());
		$result = array();
		foreach ($this->db->query($query) as $row) {
			$participantPlayers = I($allPlayers, $row['id'], array());
			$result []= $this->createParticipantDao($row, $event, $participantPlayers);
		}
		return $result;
	}
	
	/**
	 * Loads the participant by the given id for the given event.
	 * If no participant exists with the given id, throws an exception.
	 * 
	 * @param Event $event
	 * @param integer $participantId
	 * @return Participant
	 * @throws Exception
	 */
	public function load(Event $event, $participantId) {
		$stmt = QueryBuilder::create()
			->from('participant')
			->where('fk_event=?', $event->getId())
			->where('id=?', $participantId);
		$row = $this->db->queryRow($stmt, true);
		if (is_null($row)) {
			throw new DataAccessException('no such participant with the given id for the event');
		} else {
			$participantPlayers = $this->createPlayerDaoListForParticipant($row['id']);
			return $this->createParticipantDao($row, $event, $participantPlayers);
		}
	}
	
	/**
	 * Creates a Participant object from the given database row
	 * 
	 * @param array $participantData
	 * @param Event $event
	 * @param array(playerId => Player) $players
	 * @return Participant
	 */
	private function createParticipantDao(array $participantData, Event $event, array $players) {
		return new Participant(
			$participantData['id'],
			$event,
			$players,
			$players[$participantData['fk_driver']],
			$players[$participantData['fk_navigator']],
			$players[$participantData['fk_technical_driver']],
			$participantData['reg_number'],
			$participantData['car_type'],
			$participantData['car_reg_number'],
			$participantData['country'],
			$participantData['additional_guests'],
			$participantData['comment'],
			Timestamp::parse($participantData['date']));
	}
	
	/**
	 * Creates a Player object from the given database row
	 * 
	 * @param array $playerData
	 * @return Player
	 */
	private function createPlayerDao(array $playerData) {
		return new Player(
			$playerData['id'],
			$playerData['name'],
			$playerData['email'],
			$playerData['phone']);
	}
	
	/**
	 * Returns a list of Player objects associated with the given event.
	 * The result is double indexed, first by the participant id, and then by the player id.
	 * 
	 * @param Event $event
	 * @return array(participantId => array(playerId => Player))
	 */
	private function createPlayerDaoListForEvent(Event $event) {
		$participantIdStmt = QueryBuilder::create()
			->from('participant')
			->select('id')
			->where('fk_event=?', $event->getId());
		$stmt = QueryBuilder::create()
			->from('player')
			->where('fk_participant IN ?', $participantIdStmt);
		$result = array();
		foreach ($this->db->query($stmt) as $row) {
			$participantId = $row['fk_participant'];
			$player = $this->createPlayerDao($row);
			$participantPlayers = I($result, $participantId, array());
			$participantPlayers[$player->getId()] = $player;
			$result[$participantId] = $participantPlayers;
		}
		return $result;
	}
	
	/**
	 * Returns a list of Player objects associated with the given participant id.
	 * The result is indexed by the player id.
	 * 
	 * @param integer $participantId
	 * @return array(playerId => Player)
	 */
	private function createPlayerDaoListForParticipant($participantId) {
		$stmt = QueryBuilder::create()
			->from('player')
			->where('fk_participant=?', $participantId);
		$result = array();
		foreach ($this->db->query($stmt) as $row) {
			$player = $this->createPlayerDao($row);
			$result[$player->getId()] = $player;
		}
		return $result;
	}
	
}

