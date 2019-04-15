<?php
namespace View\LogInView;
require_once('view/IDivHtml.php');

class LoginView implements \View\IDivHtml {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private static $registerView = 'register';
	
	private $registerSucess = "username";
	private $_message = "";
	private $_loggedInUser;
	private $_isSession;

	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response() {
		if($this->userIsLoggedIn()) {
			$this->setWelcomeMessage();
			$response = $this->generateLogoutButtonHTML();
		} else {
			$response = $this->generateLoginFormHTML();
		}
		return $response;
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/

	private function generateLogoutButtonHTML() {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">'. $this->getMessage() .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML() {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">'. $this->getMessage() . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="'. $this->triedUsername() .'" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
					<a href="?' . self::$registerView . '">Register a new user</a>
		';
	}
	
	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	public function isLogInTry() : bool {
		$logInTrytUsername = isset($_POST[self::$name]);
		$logInTrytPassword = isset($_POST[self::$password]);
		if ($logInTrytUsername || $logInTrytPassword) {
			// sätt i en validate funktion
			if($_POST[self::$name] == "") 
				throw new \Exception("name_missing", 10);
			if($_POST[self::$password] == "")
				throw new \Exception("password_missing", 11);
			return true;
		} else
			return false;
	}

	private function getMessage() : string {
		if (isset($_GET[$this->registerSucess]) && !$this->_isSession)
			$this->setMessage("Registered new user.");
		return $this->_message;
	}

	public function setIsSession(bool $isSession) : void {
		$this->_isSession = $isSession;
	}

	public function triedUsername() : string {
		if (isset($this->_loggedInUser))
			return $this->_loggedInUser->GetName();
		else if (isset($_POST[self::$name]))
			return $_POST[self::$name];
		else if (isset($_GET[$this->registerSucess]))
			return $_GET[$this->registerSucess];
		else
			return "";
	}

	private function userIsLoggedIn() : bool {
    	if (isset($this->_loggedInUser))
     	 return $this->_loggedInUser->isLoggedIn();
    	else
     	 return false;
  }


	public function setMessage (string $message) : void {
		$this->_message = $message;
	}

	public function setWelcomeMessage () : void {
		if(!$this->_isSession && !$this->isCookieSet())
			$this->setMessage("Welcome");
	}

	public function setByeMessage () : void {
	if($this->_isSession)
		$this->setMessage("Bye bye!");
	}

		public function setCookieMessage () : void {
		if(!$this->_isSession)
			$this->setMessage("Welcome back with cookie");
	}

	 public function setUser(\Model\LogInModel\User $user = null) : void {
	 	$this->_loggedInUser = $user;
	 }

	public function logInTry() : \Model\LogInModel\User {
		$username =  $_POST[self::$name];
		$password = $_POST[self::$password];
		$user = new \Model\LogInModel\User($username, password_hash($password, PASSWORD_DEFAULT));
		return $user;
	}

		public function isCookieSet() : bool {
		$bool = isset($_COOKIE[self::$cookieName]);
		return $bool;
	}

		public function cookieLogInTry () : \Model\LogInModel\User {
		$username = $_COOKIE[self::$cookieName];
		$password = $_COOKIE[self::$cookiePassword];
		return new \Model\LogInModel\User($username, $password);
	}

	public function wantsToLogOut() : bool {
		$logOutBool = isset($_POST[self::$logout]);
		if($logOutBool)
			$this->setByeMessage();
		return $logOutBool;
	}

	public function wantsToStayLoggedIn () : bool {
		return isset($_POST[self::$keep]);
	}

		public function stayLoggedIn (string $username, string $password) : void {
		setcookie(self::$cookieName, $username, time()+60);
		setcookie(self::$cookiePassword, $password, time()+60);
	}

	public function unsetCookie() : void {
		if($this->isCookieSet()){
			unset($_COOKIE[self::$cookieName]);
			unset($_COOKIE[self::$cookiePassword]);
			setcookie(self::$cookieName);
			setcookie(self::$cookiePassword);
		}

	}
	public function wantsToRegister() : bool {
		return isset($_GET[self::$registerView]);
	}
	public function redirect(string $userName) : void {
		header("Location:/?$this->registerSucess=$userName");
	}

	}
	
