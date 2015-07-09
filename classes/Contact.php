<?php
/**
	* Contact.php
	*
	* Controls contact data between the DB class and the application
	*
	* @author	Angus Vine <angus.vine@internode.on.net>
	* @version	1.0
	* @since	5.5	(The php version used)
*/

class Contact {
	private 	$_db,
					$_data;
	
/**
	* Constructor
	*
	* Initialises a connection to the database
*/		
	public function __construct() {
		$this->_db = DB::getInstance();
	}

/**
	* create
	*
	* passes the data of a new contact to the DB class to create a new entry to the database
	* 
	* @param fields array()
*/		
	public function create($fields = array()) {
		if(!$this->_db->insert('contacts', $fields)) {
			throw new Exception('There was a problem adding the contact...');
		}
	}

/**
	* update
	*
	* passes the new data of an existing contact to the DB class to be updated
	* 
	* @param id int contacts ID
	* @param fields array()
*/		
	public function update($id, $fields = array()) {
		if (!$this->_db->update('contacts', $id, $fields)) {
			throw new Exception('There was a problem updating the contact...');
		}
	}
	
 /**
	* delete
	*
	* passes the ID of an existing contact to the DB class to delete the contact data
	* 
	* @param id int contacts ID
*/	
	public function delete($id) {
		$id = (int)$id;
		if (!$this->_db->delete('contacts', array('id', '=' , $id))) {
			throw new Exception('There was a problem deleting the contact...');
		}
	}

/**
	* csvWeb
	*
	* passes the uploaded csv from the kindred.com database to the DB class 
	* 
	* @param file *.csv file
*/
	public function csvWeb($file) {
		if(!$this->_db->loadDataWeb('contacts', $file)) {
			throw new Exception('There was a problem inserting the CSV file...');
		}
	}

/**
	* export
	*
	* returns data to be exported specified by the date range
	* 
	* @param start date
	* @param end date
*/		
	public function export($start, $end) {
		if (!$this->_db->getBetweenDates('contacts', 'date_created', str_replace('-', '', $start), str_replace('-', '', $end))) {
			throw new Exception('There was a problem searching the database...');
		}
		if ($this->_db->count()) {
			return $this->_db->results();
		}
		return false;
	}

/**
	* quickSearch
	*
	* passes search keywords from the top search bar to the DB class. 
	* returns the results specified by the page number and the limit of results shown per page
	*
	* @param keywords array()
	* @param page_number int
	* @param limit int
*/	
	public function quickSearch($keywords = array(), $page_number = 0, $limit = 0) {
		$keywords = preg_split('/[\s]+/', $keywords);
		$page_number = (int) (($page_number * $limit) - $limit);
		
		if(!$this->_data = $this->_db->searchDB($keywords, $page_number, $limit)) {
			throw new Exception('There was a problem searching the database...');
		}
		if ($this->_db->count()) {
			return $this->_db->results();
		}
		return false;
	}
	
/**
	* advancedSearch
	*
	* passes search keywords from the advance search page to the DB class. 
	* returns the results specified by the page number and the limit of results shown per page
	*
	* @param keywords array()
	* @param page_number int
	* @param limit int
*/	
	public function advancedSearch($fields = array(), $page_number = 0, $limit = 0) {
		$page_number = (int) (($page_number * $limit) - $limit);
		
		if(!$this->_data = $this->_db->advancedSearchDB($fields, $page_number, $limit)) {
			throw new Exception('There was a problem searching the database...');
		}
		if ($this->_db->count()) {
			return $this->_db->results();
		}
		return false;
	}

/**
	* advancedSearch
	*
	* passes data to the DB class to check to see if a record exists in the contacts table. 
	* returns true or false
	*
	* @param item array()
	* @param op string
	* @param field string
*/	
	public function exists($item,  $op = '=', $field = 'id') {
		$data = $this->_db->get('contacts', array($field, $op , $item));
		
		if ($data->count()) {
			$this->_data = $data->first();
			return true;
		}
		return false;
	}

/**
	* data
	*
	* returns the retrieved data from the database
*/		
	public function data() {
		return $this->_data;
	}

/**
	* db
	*
	* returns the database connection instance
*/			
	public function db() {
		return $this->_db;
	}
	
}
?>