<?php
/**
	* index.php
	*
	* Home page
	* Displays error and user messages
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
		<h2>Home</h2>
	</div>
</div>
<?php
//Displayed the messages. Once page has refreshed the messages are removed
if(Session::exists('home')) {
	echo '<div class="flash"><span>' . Session::flash('home') . '</span></div>';
}

include 'includes/foot.inc.php';
?>



			
