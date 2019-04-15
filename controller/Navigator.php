<?php
namespace Controller;

class Navigator
{
	private $_layoutView;
	private $_logInHandler;
	private $_calenderHandler;
	private $_navigation;

	function __construct(\View\LayoutView $layoutView, 
		LogInHandler $logInHandler, CalenderHandler $calenderHandler, 
		\View\NavigatorView $navigation)
	{
		$this->_layoutView = $layoutView;
		$this->_logInHandler = $logInHandler;
		$this->_calenderHandler = $calenderHandler;
		$this->_navigation = $navigation;
	}

	public function Navigate () : void {
		$viewToRender = $this->_logInHandler->startLogInHandler();
		if($this->_navigation->wantsToViewCalendar())
			$viewToRender = $this->_calenderHandler->startCalender($this->_layoutView->getLoggedInUserName());
		

		
		$this->_layoutView->startView($viewToRender);
		}


	}
