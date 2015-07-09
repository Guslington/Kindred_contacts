<?php
/**
	* Config.php
	*
	* Returns configuration variables
	*
	* @author	Angus Vine <angus.vine@internode.on.net>
	* @version	1.0
	* @since	5.5	(The php version used)
*/

class Config {
	
/**
	* get
	*
	* returns the configuration setting for specified configuration path ie. mysql/username
	* 
	* @param path
*/	
	public static function get($path = null) {
		if($path) {
			$config = $GLOBALS['config'];
			$path = explode('/', $path);
			
			foreach($path as $bit) {
				if(isset($config[$bit])) {
					$config = $config[$bit];
				}
			}
			return $config;
		}
	}
}


?>