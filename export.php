<?php
/**
	* export.php
	*
	* Exports data from the database to a CSV file or displays the data in a textarea
	*
	* @author	Angus Vine <angus.vine@internode.on.net>
	* @version	1.0
	* @since	5.5	(The php version used)
*/

require_once 'core/init.php';
ob_start();
include 'includes/head.inc.php';
?>
<script>
/**
	* function
	*
	* Displays a calendar for easy date selection and displays in the correct format
*/	
	$(function() {
		$( "#start_date" ).datepicker({dateFormat: 'yy-mm-dd'});
		$( "#start_date" ).datepicker("setDate", new Date('yy-mm-dd'));
		
		$( "#end_date" ).datepicker({dateFormat: 'yy-mm-dd'});
		$( "#end_date" ).datepicker("setDate", new Date('yy-mm-dd'));
	});
</script>

<div class="sub-headerContainer">
	<div class="sub-header">
		<h2>Export Contacts</h2>
	</div>
</div>
<?php
//Check if POST exists
if (Input::exists()) {
	$validate = new Validation();
	//Validate data
	$validation = $validate->check($_POST, array(
		'start_date' => array(
			'required' => true,
			'before_end' => Input::get('end_date')
		),
		'end_date' => array(
			'required' => true,
		),
		'export_option' => array(
			'required' => true
		)
	));
	
	if($validation->passed()) {
		$contact = new Contact();
		
		try {
			//search data
			$results = $contact->export(Input::get('start_date'), Input::get('end_date'));
			if (!$results) {
				echo '<ul class="error"><li>No records were found.</li></ul>';
			} else {
				//Displays results in textarea
				if (Input::get('export_option') == 'web') {
?>		 		<div class="ta-div">
						<textarea name="notes" id="notes" class="ta-notes" readonly>
<?php					foreach ($results as $result)	{
								echo $result->email.'&#13;&#10;';
							}
?>						</textarea>
					</div>
<?php		//Exports data to a CSV file
				} else if (Input::get('export_option') == 'csv') {
					header('Content-Type: text/csv; charset=utf-8');
					header('Content-Disposition: attachment; filename="kindred_contacts.csv"');
					ob_end_clean();
					$fp = fopen('php://output', 'w');
					$a = objectToArray($results);
					fputcsv($fp, array_keys(reset($a)));
					foreach ( $results as $result ) {
						$array = objectToArray($result);
						fputcsv($fp, $array);
					}
					fclose($fp);
					exit();
				}
			}
		} catch (Exception $e) {
			Session::flash('home', $e->getMessage());
			Redirect::to('index.php'); //redirect the user to the home page and display the error
			exit();
		}
	} else {
		//Display validation errors
		echo '<ul class="error">';
		foreach($validation->errors() as $error) {
			echo '<li>' . $error . '</li>';
		}
		echo '</ul>';
	}
}

?>

<form id="contact-form" class="form" action="" method="post">

	<div class="formContainer">
		
		<div class="field">
			<label>
				<div class="floatLeft">
					<span class="inputLabel">Start Date</span>
				</div>
				<div class="floatRight">
					<input type="text" name="start_date" id="start_date" value="" autocomplete="off" />
				</div>
			</label>
		</div>
		
		<div class="clear"></div>
		
		<div class="field">
			<label>
				<div class="floatLeft">
					<span class="inputLabel">End Date</span>
				</div>
				<div class="floatRight">
					<input type="text" name="end_date" id="end_date" value="" autocomplete="off" />
				</div>
			</label>
		</div>
		
		<div class="clear"></div>
		<br />
		<span class="sub-header" style="border-bottom: 1px solid black; margin-bottom: 5px;">Select Output</span>
		<div class="field">
		<br />
		<br />
			<label>
					<input type="radio" name="export_option" id ="export_option" value="csv">CSV file
			</label>
			<br />
			<label>
					<input type="radio" name="export_option" id ="export_option" value="web" checked="checked">Print on screen
			</label>
		</div>
		
		
	</div>
		
		<div class="button-padding" >
			<div class="field-submit">	
				<input type="submit" name="export" value="Export">
			</div>
		</div>
	
	
</form>
<?php

include 'includes/foot.inc.php';
?>



			
