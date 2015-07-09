<?php
/**
	* Input.php
	*
	* Checks and returns POST and GET variables
	*
	* @author	Angus Vine <angus.vine@internode.on.net>
	* @version	1.0
	* @since	5.5	(The php version used)
*/

Class Input {

/**
	* exists
	*
	* checks to see if a post or get variable empty
	* 
	* @param type string
*/			
	public static function exists($type = 'post') {
		switch($type) {
			case 'post':
				return (!empty($_POST)) ? true : false;
			break;
			case 'get':
				return (!empty($_GET)) ? true : false;
			break;
			default:
				return false;
			break;
		}
	}

/**
	* get
	*
	* Returns get or post variables
	* 
	* @param item string
*/			
	public static function get($item) {
		if(isset($_POST[$item])) {
			return $_POST[$item];
		} else if(isset($_GET[$item])) {
			return $_GET[$item];
		}
		return '';
	}
	
}
?>