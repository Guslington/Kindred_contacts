<?php
/**
	* delete.php
	*
	* Removes the contact from the database
	*
	* @author	Angus Vine <angus.vine@internode.on.net>
	* @version	1.0
	* @since	5.5	(The php version used)
*/

require_once 'core/init.php';
//check if get variable exists
if (Input::exists('get')) {
	$contact = new Contact();
	//check if contact exists
	if ($contact->exists($_GET['id'])) {
		try {
			$id = $_GET['id'];
			$contact->delete($id); //remove contact
			Session::flash('home', 'The contact has been deleted successfully'); 
			Redirect::to('index.php'); //redirect the user to the home page and display the message
					
		} catch (Exception $e) {
			die($e->getMessage());
			Session::flash('home', $e->getMessage());
			Redirect::to('index.php'); //redirect the user to the home page and display the error
			exit();
		}
	} else {
		Redirect::to('index.php');
	}
} else {
	Redirect::to('index.php');
}
?>



			
