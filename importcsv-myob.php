<?php
/**
	* importcsv-myob.php
	*
	* Allows importation of a CSV file that has been exported from the kindred MYOB database or formatted to suit
	* NOTE: Not yet implemented
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
		<h2>Import CSV from MYOB</h2>
	</div>
	<div class="sub-navigation">
		<span><span class="bold">Import CSV from:</span> 
			<a href="importcsv-web.php">Web Site</a> 
		</span>
	</div>
</div>

<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>

 <form action="" method="post" enctype="multipart/form-data" >
	<div class="formContainer">
		<div class="input-group">
			<span class="input-group-btn">
				<span class="btn btn-primary btn-file">
					Browse<input type="file" name="csv" required />
				</span>
			</span>
			<input type="text" class="form-control" readonly>
		</div>
		<div class="field-submit">
			<input type="submit" name="submit" value="Upload" />
		</div>
	</div>
</form>

<?php
include 'includes/foot.inc.php';
?>



			
