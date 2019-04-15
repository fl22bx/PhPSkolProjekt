<?php
namespace Controller;
/**
 * is always started first to nake sure if logged in or not
 * 
 */
class LogInHandler
{
	private $_layoutView;
	private $_logInView;
	private $_registerView;
	private $_logInDb;
	private $_loggedInUser;
	private $_exceptionHandlerview;


	
	function __construct(\View\LogInView\LoginView $logInView, \View\LayoutView $layoutView, \Model\LogInModel\LogInPercistency $logInDb, \View\ExceptionHandlerView $exceptionHandlerview, \View\Calender\RegisterView $registerView)
	{
			$this->_layoutView = $layoutView;
			$this->_logInView = $logInView;
			$this->_registerView = $registerView;
			$this->_exceptionHandlerview = $exceptionHandlerview;
			$this->_logInDb = $logInDb;
	}

	public function startLogInHandler() {
		try {		
			$this->_logInView->setIsSession($this->_logInDb->isSessionActive());	
			$this->handleLogOutRequest();
			$this->handleSession();
			$this->handleCookiesLogIn();
			$this->handleLogInTry();
			$this->handleWantsToRegister();
		} catch (\Exception $e) {
			$msg = $this->_exceptionHandlerview->handleErrorRendering($e);
		} finally {
			$viewToRender = $this->navigateLogInView();
			if(isset($msg))
				$viewToRender->setMessage($msg);
			
			return $viewToRender;
		}

	}

	private function navigateLogInView () : \View\IDivHtml {
		if ($this->_logInView->wantsToRegister())
			return $this->_registerView;
		else 
			return $this->_logInView;
	}

	private function handleWantsToRegister() : void {
		if($this->_registerView->wantsToCreateNewUser()) {
			$user = $this->_registerView->newUser();
			$this->_logInDb->setNewUser($user);
			$this->_logInView->redirect($user->GetName());
		}

	}

	private function handleSession () : void {
		$isSessionActive = $this->_logInDb->isSessionActive();
		if ($this->_logInDb->isSessionActive($isSessionActive)) {
			$user = $this->_logInDb->getSessionUser();
			$user->authenticate($this->_logInDb->isAuthenticated($user));
			$this->setUserInView($user);
		} 


	}

	private function handleLogOutRequest () {
		if ($this->_logInView->wantsToLogOut()){
			$this->_logInDb->endSession();
			$this->_logInView->unsetCookie();
		}
	}

	private function handleLogInTry () : void {
		$isLogInTry = $this->_logInView->isLogInTry();
		if($isLogInTry) {
			$user = $this->_logInView->logInTry();
			$user->authenticate($this->_logInDb->isAuthenticated($user));
			$this->setUserInView($user);
		if (!$user->isLoggedIn())
			throw new \Exception("not_auth", 21);
			
		$this->_logInDb->setSession($user);
		$this->handleKeepMeLoggedIn($user);
		}
	}

	private function handleKeepMeLoggedIn(\Model\LogInModel\User $user) : void {
		if ($this->_logInView->wantsToStayLoggedIn())
			$this->_logInView->stayLoggedIn($user->GetName(),$user->GetPassword());

	}


	private function handleCookiesLogIn() : void {
		if($this->_logInView->isCookieSet()) {
			$user = $this->_logInView->cookieLogInTry();
			$user->authenticate($this->_logInDb->isAuthenticated($user));
			if (!$user->isLoggedIn())
				throw new \Exception("wrong_cookies",31);
			
			$this->setUserInView($user);
			$this->_logInView->setCookieMessage();
		} 
	}

	private function setUserInView (\Model\LogInModel\User $user) : void {
		$this->_layoutView->setUser($user);
	}
}