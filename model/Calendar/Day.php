<?php
namespace Model\Calendar;

class Day
{
	private $_date;
	private $_isRed;
	private $_hollidayName = "";
	
	function __construct(int $date)
	{
		$this->_date = $date;
	}

	public function setHollidayStatus () : void {
		$this->_isRed = $isRed;
		$this->_hollidayName = $specialName;
	}

	public function getHollidayName() : string {
		return $this->_hollidayName;
	}

	public function isRed() : bool {
		return $this->_isRed;
	}

	public function getDate() : int {
		return $this->_date;
	}
}