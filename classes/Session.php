<?php
/**
	* Contact.php
	*
	* Handles session variables and data
	*
	* @author	Angus Vine <angus.vine@internode.on.net>
	* @version	1.0
	* @since	5.5	(The php version used)
*/

class Session {

/**
	* exists
	*
	* checks to see if a session exists
	* 
	* @param name array()
*/		
	public static function exists($name) {
		return (isset($_SESSION[$name])) ? true : false;
	}

/**
	* put
	*
	* Sets the session variable to a value
	* 
	* @param name array()
	* @param value
*/
	public static function put($name, $value) {
		return $_SESSION[$name] = $value;
	}

/**
	* exists
	*
	* Returns the session variable
	* 
	* @param name array()
*/
	public static function get($name) {
		return $_SESSION[$name];
	}
	
/**
	* delete
	*
	* Deletes the session variable
	* 
	* @param name array()
*/
	public static function delete($name) {
		if(self::exists($name)) {
			unset($_SESSION[$name]);
		}
	}

/**
	* put
	*
	* Sets the session variable to a value and removes the value from the variable
	* 
	* @param name array()
	* @param string string
*/
	public static function flash($name, $string = '') {
		if(self::exists($name)) {
			$session = self::get($name);
			self::delete($name);
			return $session;
		} else {
			self::put($name, $string);
		}
	}
	
}
?>