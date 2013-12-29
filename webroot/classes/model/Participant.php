<?php

class Participant {
	
	/**
	 * Identifier of the participant
	 * 
	 * @var integer or null
	 */
	private $id;
	
	/**
	 * The event what is this participant is registered for
	 * 
	 * @var Event
	 */
	private $event;
	
	/**
	 * List of all the players associcated with this participant
	 * 
	 * @var array(Player)
	 */
	private $players;
	
	/**
	 * Driver
	 * 
	 * @var Player
	 */
	private $driver;
	
	/**
	 * Navigator
	 * 
	 * @var Player
	 */
	private $navigator;
	
	/**
	 * Driver of the technical part
	 * 
	 * @var Player
	 */
	private $technicalDriver;
	
	/**
	 * Registration number
	 * 
	 * @var integer or null
	 */
	private $regNumber;
	
	/**
	 * Car type
	 * 
	 * @var string or null
	 */
	private $carType;
	
	/**
	 * Car registration number
	 * 
	 * @var string or null
	 */
	private $carRegNumber;
	
	/**
	 * Country code, for international events
	 * 
	 * @var string
	 */
	private $country;
	
	/**
	 * Number of the additional guests
	 * 
	 * @var integer
	 */
	private $additionalGuests;
	
	/**
	 * Additional comment
	 * 
	 * @var string or null
	 */
	private $comment;
	
	/**
	 * Application date
	 * 
	 * @var Timestamp
	 */
	private $date;
	
	public function __construct($id, Event $event, array $players, Player $driver,
		Player $navigator, Player $technicalDriver, $regNumber, $carType, $carRegNumber,
		$country, $additionalGuests, $comment, Timestamp $date
	) {
		$this->id = $id;
		$this->event = $event;
		$this->players = $players;
		$this->driver = $driver;
		$this->navigator = $navigator;
		$this->technicalDriver = $technicalDriver;
		$this->regNumber = $regNumber;
		$this->carType = $carType;
		$this->carRegNumber = $carRegNumber;
		$this->country = $country;
		$this->additionalGuests = $additionalGuests;
		$this->comment = $comment;
		$this->date = $date;
	}
	
	/**
	 * Returns the identifier of the participant
	 * 
	 * @return integer or null
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Returns the event what is this participant is registered for
	 * 
	 * @return Event
	 */
	public function getEvent() {
		return $this->event;
	}
	
	/**
	 * Returns the list of all the players associcated with this participant
	 * 
	 * @return array(Player)
	 */
	public function getPlayers() {
		return $this->players;
	}
	
	/**
	 * Returns the driver
	 * 
	 * @return Player
	 */
	public function getDriver() {
		return $this->driver;
	}
	
	/**
	 * Returns the navigator
	 * 
	 * @return Player
	 */
	public function getNavigator() {
		return $this->navigator;
	}
	
	/**
	 * Returns the driver of the technical part
	 * 
	 * @return Player
	 */
	public function getTechnicalDriver() {
		return $this->technicalDriver;
	}
	
	/**
	 * Returns the registration number
	 * 
	 * @return integer or null
	 */
	public function getRegNumber() {
		return $this->regNumber;
	}
	
	/**
	 * Returns the car type
	 * 
	 * @return string or null
	 */
	public function getCarType() {
		return $this->carType;
	}
	
	/**
	 * Returns the car registration number
	 * 
	 * @return string or null
	 */
	public function getCarRegNumber() {
		return $this->carRegNumber;
	}
	
	/**
	 * Returns the country code, for international events, or null
	 * 
	 * @return string
	 */
	public function getCountry() {
		return $this->country;
	}
	
	/**
	 * Returns the number of the additional guests
	 * 
	 * @return integer
	 */
	public function getAdditionalGuests() {
		return $this->additionalGuests;
	}
	
	/**
	 * Returns the additional comment
	 * 
	 * @return string or null
	 */
	public function getComment() {
		return $this->comment;
	}
	
	/**
	 * Returns the application date
	 * 
	 * @return Timestamp
	 */
	public function getDate() {
		return $this->date;
	}
	
	/**
	 * Returns the name of all players but driver and navigator
	 * 
	 * @return array of string
	 */
	public function getOtherPlayersName() {
		$result = array();
		foreach ($this->players as $player) {
			if ($player !== $this->getDriver() && $player !== $this->getNavigator()) {
				$result []= $player->getName();
			}
		}
		return $result;
	}
	
}
