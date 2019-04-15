<?php
namespace View\Calender;

class EventView
{
	
	public function renderEvent(array $userEvents, int $day) : string {
		    	return '<div class="registerevent eventdet">	
    		    	<a href="?calendar" class="closeevent">X</a>
    		    	'.$this->events($userEvents,$day).'

				</div>';

	 		}
	

	private function events(array $userEvents, int $day) : string {
		$html = '';
		foreach ($userEvents as $event) {
	 		if($event->getDay() == $day) {
	 			$html .= '
	 			<p>Name: '.$event->getName().'</p>
	 			<p>Place: Plats: '.$event->getPlace().'</p>
	 			<p>Description: '.$event->getDescription().'</p>
	 			<p>-----------------------------------------</p>
	 			';
	 		}

	 	}

	 	return $html;
	}
}