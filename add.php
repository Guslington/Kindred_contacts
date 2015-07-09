<?php
/**
	* add.php
	*
	* Creates the form and adds a new contact to the database
	*
	* @author	Angus Vine <angus.vine@internode.on.net>
	* @version	1.0
	* @since	5.5	(The php version used)
*/

require_once 'core/init.php';

include 'includes/head.inc.php';
?>
<div class="sub-headerContainer">
	<div class="sub-header">
		<h2>Add Contacts</h2>
	</div>
	<div class="sub-navigation">
		<span><span class="bold">Import CSV from:</span>  
			<a href="importcsv-myob.php">MYOB</a> | 
			<a href="importcsv-web.php">Web Site</a> 
		</span>
	</div>
</div>
<?php

if (Input::exists()) {
	$validate = new Validation();
	$validation = $validate->check($_POST, array(
		'band' => array(
			'max' => 64
		),
		'first_name' => array(
			'max' => 64
		),
		'last_name' => array(
			'max' => 64
		),
		'email' => array(
			'required' => true,
			'max' => 1024,
			'is_email' => true,
			'unique' => 'contacts'
		),
		'phone' => array(
			'max' => 64,
			'is_numeric' => true
		),
		'mobile' => array(
			'max' => 64,
			'is_numeric' => true,
			'unique' => 'contacts'
		),
		'company' => array(
			'max' => 64
		),
		'add_line_1' => array(
			'max' => 128
		),
		'add_line_2' => array(
			'max' => 128
		),
		'state' => array(
			'max' => 128
		),
		'city' => array(
			'max' => 128
		),
		'post_code' => array(
			'max' => 128,
			'is_numeric' => true
		)
	));
	
	if($validation->passed()) {
		$contact = new Contact();
		try {
			$contact->create(array(
				'company' => Input::get('company'),
				'band' => Input::get('band'),
				'first_name' => Input::get('first_name'),
				'last_name' => Input::get('last_name'),
				'email' => Input::get('email'),
				'add_line_1' => Input::get('add_line_1'),
				'add_line_2' => Input::get('add_line_2'),
				'state' => Input::get('state'),
				'city' => Input::get('city'),
				'post_code' => Input::get('post_code'),
				'phone' => Input::get('phone'),
				'mobile' => Input::get('mobile'),
				'notes' => Input::get('notes'),
				'date_created' => date('d-m-Y'),
				'date_modified' => date('d-m-Y')
			));
			
			Session::flash('home', 'The <a href="contact.php?id=' . $contact->db()->rtnInstId() . '">contact</a> has been created successfully');
			Redirect::to('index.php');
			
		} catch (Exception $e) {
			Session::flash('home', $e->getMessage());
			Redirect::to('index.php');
			exit();
		}
	} else {
		echo '<ul class="error">';
		foreach($validation->errors() as $error) {
			echo '<li>' . $error . '</li>';
		}
		echo '</ul>';
	}
}

$form = array(
	'action' => '',
	'method' => 'post',
	'id' => '',
	'band' => '',
	'first_name' => '',
	'last_name' => '',
	'email' => '',
	'phone' => '',
	'mobile' => '',
	'company' => '',
	'add_line_1' => '',
	'add_line_2' => '',
	'show_state' => true,
	'state' => '',
	'city' => '',
	'post_code' => '',
	'show_notes' => true,
	'notes' => '',
	'show_button' => true,
	'button' => 'Add Contact',
	'read_only' => false
);
include 'includes/contact-form.php';
include 'includes/foot.inc.php';
?>
