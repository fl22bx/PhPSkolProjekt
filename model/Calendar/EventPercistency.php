<?php
namespace Model\Calendar;


class EventPercistency
{
	private $_sqlDatabase;
	
	function __construct(\DatabaseMySQL $SqlDatabase)
	{
		$this->_sqlDatabase = $SqlDatabase;
	}

	public function setNewEvent(Event $event) {
		$this->_sqlDatabase->connect();
		$day = $event->getDay();
		$month = $event->getMonth();
		$name = $event->getName();
		$place = $event->getPlace();
		$description = $event->getDescription();
		$owner = $event->getOwner();

		$sql = "INSERT INTO Events (day, month, name, place, description, owner)
			VALUES('$day', '$month', '$name', '$place', '$description', '$owner')
		";
		$conn = $this->_sqlDatabase->getConnection();
		$conn->query($sql);
		$this->_sqlDatabase->stopDb();
	}

	public function getEvents(string $userName, int $month) : Array {
		$this->_sqlDatabase->connect();
		$sql = " SELECT * from Events 
		WHERE owner = '$userName' AND
		month = '$month';
		";

		$result = mysqli_query($this->_sqlDatabase->getConnection(), $sql);
		$array = [];
		$data = mysqli_fetch_all($result,MYSQLI_ASSOC);
		$this->_sqlDatabase->stopDb();
		foreach ($data as $event) {
			$event = new Event($event["day"],$event["month"],$event["place"],$event["name"],$event["description"]);
			array_push($array, $event);	
		};
		return $array;
	}
}