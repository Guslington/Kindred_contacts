<?php
/**
	* functions.php
	*
	* Other functions required
	*
	* @author	Angus Vine <angus.vine@internode.on.net>
	* @version	1.0
	* @since	5.5	(The php version used)
*/

/**
	* escape
	*
	* Sanitizes the data before being passed to the database
*/
function escape($string) {
	return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

/**
	* objectToArray
	*
	* Converts an object to an array
	* return the array
	*
	*@Param d Object
*/
function objectToArray($d) {
		if (is_object($d)) {
			// Gets the properties of the given object
			// with get_object_vars function
			$d = get_object_vars($d);
		}
 
		if (is_array($d)) {
			/*
			* Return array converted to object
			* Using __FUNCTION__ (Magic constant)
			* for recursive call
			*/
			return array_map(__FUNCTION__, $d);
		}
		else {
			// Return array
			return $d;
		}
	}