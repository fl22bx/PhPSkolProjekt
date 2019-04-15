<?php
namespace View;

class NavigatorView {
	private static $calendar = "calendar";

	public function show() {
		

		return '
			<a href="/">Home |</a>
			<a href="?' . self::$calendar . '">Calendar</a>

		';
	}

	public function wantsToViewCalendar() : bool {
		return isset($_GET[self::$calendar]);
	}
}