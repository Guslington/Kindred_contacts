<?php
/**
	* add.php
	*
	* Creates the form and searches the database for the specified contact
	*
	* @author	Angus Vine <angus.vine@internode.on.net>
	* @version	1.0
	* @since	5.5	(The php version used)
*/

require_once 'core/init.php';

include 'includes/head.inc.php';
?>
<script type="text/javascript">
/**
	* removeEmptyInput
	*
	* Removes any empty search fields from the POST before it is sent
*/		
	function removeEmptyInput()
	{
		var form = document.getElementById('contact-form');
		var allInputs = form.getElementsByTagName('input');
		var select = document.getElementById('state');
		var input, i;
		
		if(!select.options[select.selectedIndex].value) {
			select.setAttribute('name', '');
		}
		
		for(i = 0; input = allInputs[i]; i++) {
			if(input.getAttribute('name') && !input.value) {
				input.setAttribute('name', '');
			}
		}
	}
</script>
<div class="sub-headerContainer">
	<div class="sub-header">
		<h2>Advanced Search</h2>
	</div>
</div>

<?php
$form = array(
	'action' => 'advresults.php',
	'method' => 'get',
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
	'show_notes' => false,
	'notes' => '',
	'show_button' => true,
	'button' => 'Search',
	'read_only' => false
);
if(Session::exists('back')) {
	echo '<ul class ="error"><li>' . Session::flash('back') . '</li></ul>';
}
include 'includes/contact-form.php';
include 'includes/foot.inc.php';
?>



			
