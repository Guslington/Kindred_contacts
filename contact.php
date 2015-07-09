<?php
/**
	* contact.php
	*
	* Displays contact specified in the URL get value
	*
	* @author	Angus Vine <angus.vine@internode.on.net>
	* @version	1.0
	* @since	5.5	(The php version used)
*/

require_once 'core/init.php';

//Check to see if the contact exists
if (Input::exists('get')) {
	$contact = new Contact();
	if ($contact->exists($_GET['id'])) {
	
include 'includes/head.inc.php';
?>

<script type="text/javascript">
function confirm_alert(node) {
    return confirm("Are you sure you want to DELETE this record?\nIt will be erased from the database...");
}
</script>

<div class="sub-headerContainer">
	<div class="sub-header">
		<h2><?php echo $contact->data()->first_name . " " . $contact->data()->last_name?></h2>
	</div>
	<div class="sub-navigation">
		<span> 
			<a href="update.php?id=<?php echo $contact->data()->id; ?>">Update</a> |
			<a href="delete.php?id=<?php echo $contact->data()->id; ?>" onclick="return confirm_alert(this);">Delete</a> 
		</span>
	</div>
</div>

<?php
//Creates the form and display the data
$form = array(
	'action' => '',
	'method' => '',
	'band' => $contact->data()->band,
	'id' => $contact->data()->id,
	'first_name' => $contact->data()->first_name,
	'last_name' => $contact->data()->last_name,
	'email' => $contact->data()->email,
	'phone' => $contact->data()->phone,
	'mobile' => $contact->data()->mobile,
	'company' => $contact->data()->company,
	'add_line_1' => $contact->data()->add_line_1,
	'add_line_2' => $contact->data()->add_line_2,
	'show_state' => false,
	'state' => $contact->data()->state,
	'city' => $contact->data()->city,
	'post_code' => $contact->data()->post_code,
	'show_notes' => true,
	'notes' => $contact->data()->notes,
	'show_button' => false,
	'button' => '',
	'read_only' => true
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
