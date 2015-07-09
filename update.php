<?php
/**
	* update.php
	*
	* Displays contact specified in the URL get value and allows user to modify the data
	*
	* @author	Angus Vine <angus.vine@internode.on.net>
	* @version	1.0
	* @since	5.5	(The php version used)
*/

require_once 'core/init.php';
// checks if user exists
if (Input::exists('get')) {
	$contact = new Contact();
	if ($contact->exists($_GET['id'])) {
			
		include 'includes/head.inc.php';
		?>
		<div class="sub-headerContainer">
			<div class="sub-header">
				<h2>Update Contact</h2>
			</div>
			<div class="sub-navigation">
				<span> 
					<a href="contact.php?id=<?php echo $contact->data()->id; ?>">Cancel</a>
				</span>
			</div>
		</div>

		<?php
		//Validates data
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
					'is_email' => true
				),
				'phone' => array(
					'max' => 64,
					'is_numeric' => true
				),
				'mobile' => array(
					'max' => 64,
					'is_numeric' => true
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
					//sends updated data to the database
					$contact->update(Input::get('id'), array(
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
						'date_modified' => date('Y-m-d H:i:s')
					));
					
					Session::flash('home', 'The <a href="contact.php?id=' . Input::get('id') . '">contact</a> has been updated successfully');
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
//Creates the form and displays the data
$form = array(
	'action' => 'update.php?id=' . $contact->data()->id,
	'method' => 'post',
	'id' => $contact->data()->id,
	'band' => $contact->data()->band,
	'first_name' => $contact->data()->first_name,
	'last_name' => $contact->data()->last_name,
	'email' => $contact->data()->email,
	'phone' => $contact->data()->phone,
	'mobile' => $contact->data()->mobile,
	'company' => $contact->data()->company,
	'add_line_1' => $contact->data()->add_line_1,
	'add_line_2' => $contact->data()->add_line_2,
	'show_state' => true,
	'state' => $contact->data()->state,
	'city' => $contact->data()->city,
	'post_code' => $contact->data()->post_code,
	'show_notes' => true,
	'notes' => $contact->data()->notes,
	'show_button' => true,
	'button' => 'Update',
	'read_only' => false
);
include 'includes/contact-form.php';
include 'includes/foot.inc.php';

	} else {
		header('Location: index.php');
	}
} else {
	header('Location: index.php');
}
?>
