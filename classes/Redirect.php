<?php
/**
	* Redirect.php
	*
	* Handles redirection of pages 
	*
	* @author	Angus Vine <angus.vine@internode.on.net>
	* @version	1.0
	* @since	5.5	(The php version used)
*/

class Redirect {

/**
	* to
	*
	* Redirects user to specified location
	* 
	* @param location string
*/		
	public static function to($location = null) {
		if($location) {
			if(is_numeric($location)) {
				switch($location) {
					case 404:
						header('HTTP/1.0 404 Not Found');
						include 'includes/errors/404.php';
						exit();
					break;
				}
			}
			header('Location: ' . $location);
			exit();
		}
	}

}
?>