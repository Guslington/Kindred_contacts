<?php
/**
	* DB.php
	*
	* Controls the connection and data flow between the database and the application
	*
	* @author	Angus Vine <angus.vine@internode.on.net>
	* @version	1.0
	* @since	5.5	(The php version used)
*/

class DB {
	private static $_instance = null;
	private $_pdo,
			$_query, 
			$_error = false, 
			$_results, 
			$_count = 0,
			$_duration,
			$_lastInsertId;

/**
	* Constructor
	*
	* Establishes a connection to the database using the configuration set in the init.php file
*/					
	private function __construct() {
		try {
			$this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . 
									';dbname=' . Config::get('mysql/db'),  
									Config::get('mysql/username'), 
									Config::get('mysql/password'), 
									array(PDO::MYSQL_ATTR_LOCAL_INFILE => true));
			//$this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(PDOException $e) {
			die($e->getMessage());
		}
	}

/**
	* getInstance
	*
	* creates a new instance of the DB class to connect to the MySQL database
*/			
	public static function getInstance() {
		if(!isset(self::$_instance)) {
			self::$_instance = new DB();
		}
		return self::$_instance;
	}
	
/**
	* query
	*
	* Prepares a statement for execution and binds the parameters to the query
	* Executes the query and returns the results and query time
	* 
	* @param sql string
	* @param params array()
*/			
	public function query($sql, $params = array()) {
		$this->_error = false;
		if($this->_query = $this->_pdo->prepare($sql)) {
			$x = 1;
			if(count($params)) {
				foreach($params as $param) {
					$this->_query->bindValue($x, $param); 
					$x++;
				}
			}
			
			$starttime = microtime(true);
			if($this->_query->execute()) {
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount();
				
			} else {
				$this->_error = true;
			}
			$endtime = microtime(true);
			$this->_duration = $endtime - $starttime;
		}
		return $this;
	}

/**
	* action
	*
	* Creates SQL query based on action required and return query
	* 
	* @param action string
	* @param table string
	* @param where array()
*/	
	private function action($action, $table, $where = array()) {
		if(count($where) === 3) {
			$operators = array('=', '>', '<', '>=', '<=');
			$field 		= $where[0];
			$operator 	= $where[1];
			$value 		= $where[2];
			
			if(in_array($operator, $operators)) {
			
				$sql = "{$action} FROM `{$table}` WHERE {$field} {$operator} ?";
				//echo $sql.'<br>';
				if (!$this->query($sql, array($value))->error()) {
					return $this;
				}
			}
		}
		return false;
	}
	
/**
	* get
	*
	* sets the SELECT function in the sql query 
	* 
	* @param table string
	* @param where string
*/	
	public function get($table, $where) {
		return $this->action('SELECT *', $table, $where);
	}

/**
	* delete
	*
	* sets the delete function in the sql query 
	* 
	* @param table string
	* @param where string
*/	
	public function delete($table, $where) {
		return $this->action('DELETE', $table, $where);
	}

/**
	* insert
	*
	* creates an INSERT SQL query and passes to the query function
	* returns true if successful
	* 
	* @param table string
	* @param fields array()
*/	
	public function insert($table, $fields = array()) {
		if(count($fields)) {
			$keys = array_keys($fields);
			$values = '';
			$x = 1;
			
			foreach($fields as $field) {
				$values .= '?';
				if($x < count($fields)) {
					$values .= ', ';
				}
				$x++;
			}
			
			$sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values})";
			//echo $sql;
			if(!$this->query($sql, $fields)->error()) {
				$this->_lastInsertId = $this->_pdo->lastInsertId();
				return true;
			}
		}
		return false;
	}

/**
	* update
	*
	* Creates UPDATE SQL query and passes to the query function
	* returns true if successful
	* 
	* @param action string
	* @param table string
	* @param field string
*/		
	public function update($table, $id, $fields) {
		$set = '';
		$x = 1;
		
		foreach($fields as $name => $value) {
			$set .= "{$name} = ?";
			if($x < count($fields)) {
				$set .= ', ';
			}
			$x++;
		}
		
		$sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
		//echo $sql;
		if(!$this->query($sql, $fields)->error()) {
			return true;
		}
		return false;
	}

/**
	* getBetweenDates
	*
	* Creates SELECT SQL query to search for results between to given dates and passes to the query function
	* returns true if successful
	* 
	* @param action string
	* @param table string
	* @param start_date date
	* @param end_date date 
*/		
	public function getBetweenDates($table, $field, $start_date, $end_date) {
		$sql = "SELECT * FROM {$table} WHERE {$field} BETWEEN {$start_date} AND {$end_date}";
		//echo $sql;
		if(!$this->query($sql)->error()) {
			return true;
		}
		return false;
	}

/**
	* searchDB
	*
	* Creates SELECT SQL query based on search keywords proved by the user
	* Searches multiple fields and sorts by most relevant match i.e. most field matches first 
	* 
	* @param keywords array()
	* @param start int
	* @param limit int
*/
	public function searchDB ($keywords, $start, $limit) {
		$key_str = "";
		$total_keywords = count($keywords);
		
		foreach ($keywords as $key=>$keyword) {
			$key_str .=  $keyword.'*';
			if ($key != ($total_keywords -1 )) {
				$key_str .= " ";
			}
		}
		
		
		$sql = "SELECT *,  MATCH (`Company`, `Band`, `first_name`, `last_name`, `email`) 
					AGAINST ('$key_str' IN BOOLEAN MODE) AS relevance FROM `contacts` 
					WHERE MATCH (`Company`, `Band`, `first_name`, `last_name`, `email`) 
					AGAINST ('$key_str' IN BOOLEAN MODE) ORDER BY relevance DESC";
		
		/*
		$sql = 	"SELECT * FROM `contacts` ".
					"WHERE `Company`AND `Band`AND `first_name`AND `last_name` AND `email` ".
					"LIKE $key_str";
		*/
		if ($limit != 0) {
			$sql .= " LIMIT $start, $limit";
		}
		
		//echo $sql;
		if(!$this->query($sql)->error()) {
			return $this;
		}
		return false;
	}

/**
	* searchDB
	*
	* Creates SELECT SQL query based on search keywords proved by the user in the advanced search
	* Searches multiple fields and sorts by most relevant match i.e. most field matches first 
	* 
	* @param fields array()
	* @param start int
	* @param limit int
*/	
	public function advancedSearchDB ($fields, $start, $limit) {
		
		$x = 1;
		$sql = "";
		
		$sql .= "SELECT * FROM `contacts` WHERE ";
		foreach ($fields as $key => $q) {
			$sql .= "`$key` LIKE '%$q%' ";
			if($x < count($fields)) {
					$sql .= "AND ";
				}
			$x++;
		}
		
		if ($limit != 0) {
			$sql .= " LIMIT $start, $limit";
		}
		
		//echo $sql;
		if(!$this->query($sql)->error()) {
			return $this;
		}
		return false;
	
	}

/**
	* results
	*
	* Returns all results from the SQL query 
*/			
	public function results() {
		return $this->_results;
	}

/**
	* first
	*
	* Returns the first result from the SQL query 
*/		
	public function first() {
		return $this->results()[0];
	}

/**
	* error
	*
	* Returns any errors recorded during the query
*/
	public function error() {
		return $this->_error;
	}

/**
	* count
	*
	* Returns the number of results from the query
*/
	public function count() {
		return $this->_count;
	}
	
/**
	* queryDuration
	*
	* Returns the time taken to query the database
*/
	public function queryDuration() {
		return $this->_duration;
	}
	
/**
	* rtnInstId
	*
	* Returns the last inserted contact into the database
*/
	public function rtnInstId() {
		return $this->_lastInsertId;
	}
}
?>