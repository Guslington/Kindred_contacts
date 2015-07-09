<?php
/**
	* Validation.php
	*
	* Handles validation of data
	*
	* @author	Angus Vine <angus.vine@internode.on.net>
	* @version	1.0
	* @since	5.5	(The php version used)
*/

class Validation {
	
	private $_passed = false,
			$_errors = array(),
			$_db = null;

/**
	* Constructor
	*
	* Initialises a connection to the database
*/		
	public function __construct() {
		$this->_db = DB::getInstance();
	}
	
/**
	* check
	*
	* Checks data against specified criteria and adds an error to the errors array if a match is made
	* 
	* @param source array()
	* @param items array()
*/	
	public function check($source, $items = array()) {
		foreach($items as $item => $rules) {
			foreach($rules as $rule => $rule_value) {
				$value = trim($source[$item]);
				if($rule === 'required' && empty($value)) {
					$this->addError(str_replace('_', ' ', $item)." is required");
				} else if(!empty($value)) {
					switch($rule) {
						case 'min':
							if(strlen($value) < $rule_value) {
								$this->addError("{$item} must be a minimum of {$rule_value} characters.");
							}
						break;
						case 'max':
							if(strlen($value) > $rule_value) {
								$this->addError(str_replace('_', ' ', $item)." has a maximum of {$rule_value} characters.");
							}
						break;
						case 'matches':
							if ($value != $source[$rule_value]) {
								$this->addError("{$rule_value} must match ".str_replace('_', ' ', $item));
							}
						break;
						case 'unique':
							$check = $this->_db->get($rule_value, array($item, '=', $value));
							if($check->count()) {
								$this->addError(str_replace('_', ' ', $item)." already exists.");
							}
						break;
						case 'is_email':
							if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
								$this->addError(str_replace('_', ' ', $item)." is not valid.");
							}
						break;
						case 'before_end':
							if (strtotime($value) > strtotime($rule_value)) {
								$this->addError(str_replace('_', ' ', $item)." must be before the end date.");
							}
						break;	
						case 'is_numeric':
							if (!is_numeric($value)) {
								$this->addError(str_replace('_', ' ', $item)." must be be a number.");
							}
						break;
					}
				}
			}
		}
		if(empty($this->_errors)) {
			$this->_passed = true;
		}
		return $this;
	}
	
/**
	* addError
	*
	* adds errors to the error array
*/			
	private function addError($error) {
		$this->_errors[] = $error;
	}
	
/**
	* errors
	*
	* returns the error array
*/		
	public function errors() {
		return $this->_errors;
	}
	
/**
	* passed
	*
	* returns true if validation has passed with no errors
*/		
	public function passed() {
		return $this->_passed;
	}
}
?>