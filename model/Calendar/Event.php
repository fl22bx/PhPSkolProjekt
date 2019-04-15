<?php
namespace Model\Calendar;


class Event
{
	private $_day;
	private $_month;
	private $_name;
	private $_place;
	private $_description;
	private $_owner;
	
	function __construct(string $day, string $month, string $place, 
		string $name, string $description)
	{
		$this->setDay($day);
		$this->setMonth($month);
		$this->setPlace($place);
		$this->setName($name);
		$this->setDescription($description);

	}

	private function setDay(string $value) : void {
		if($value == "")
			throw new \Exception("date_missing", 51);

		$this->_day = $value;
			
	}

	public function getDay() : int {
		return $this->_day;
	}

	private function setMonth(string $value) : void {
		if($value == "")
			throw new \Exception("date_missing", 52);
		$this->_month = $value;
	}

		public function getMonth() : int {
		return $this->_month;
	}

	private function setName(string $value) : void {
		if($value == "")
			throw new \Exception("event_name_missing", 53);
		$this->_name = $value;		
	}

		public function getName() : string {
		return $this->_name;
	}

	private function setPlace(string $value) : void {
		if($value == "")
			throw new \Exception("place_missing", 54);
		$this->_place = $value;
	}

		public function getPlace() : string {
		return $this->_place;
	}

	private function setDescription(string $value) : void {
		if($value == "")
			throw new \Exception("description_missing", 55);
		$this->_description = $value;	
	}

		public function getDescription() : string {
		return $this->_description;
	}

	public function setOwner(string $name) : void {
		$this->_owner = $name;
	}

		public function getOwner() : string {
		return $this->_owner;
	}

}
