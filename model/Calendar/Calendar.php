<?php
namespace Model\Calendar;


class Calendar
{
	private $_months = [];

	
	function __construct()
	{
		for($i = 1; $i <= 12; $i++ ) {
			$month = new Month($i);
			array_push($this->_months, $month);
		}
		
	}

	public function getMonth(int $month) : Month {
		return $this->_months[$month];
	}

}