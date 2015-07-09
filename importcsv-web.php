<?php
/**
	* importcsv-web.php
	*
	* Allows importation of a CSV file that has been exported from the kindred.com database or formatted to suit
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
		<h2>Import CSV from Website</h2>
	</div>
	<div class="sub-navigation">
		<span><span class="bold">Import CSV from:</span> 
			<a href="importcsv-myob.php">MYOB</a>
		</span>
	</div>
</div>
<?php
//Check if POST data sent
if (isset($_POST['submit'])) {
	$file_tmp_path 	= $_FILES['csv']['tmp_name'];
	$file_name 		= $_FILES['csv']['name'];
	$file_ext 			= explode('.', $file_name);
	$file_ext			= strtolower(end($file_ext)); //get file extension
	$new_file_path	= '/tmp/'.$file_name; //move uploaded file to tmp dir
	
	$validate = new Validation();
	//Check if file extension is csv
	$validation = $validate->check($_POST, array(
		'csv' => array(
			'required' => true,
		)
	));
	
	if ($validation->passed() && $file_ext == 'csv') {
		//Open file and read contents
		if (($csv_file = fopen($file_tmp_path, "r")) !== false) {
			$row = $exist = $new = 0;
			while (($line = fgetcsv($csv_file, 1000, ",")) !== FALSE) {
				$num = count($line);
				if($row == 0){ $row++; continue; }
				
				$contact = new Contact();
				//check if contact exists based on email address
				if ($contact->exists($line[2], '=', '`email`')) {
					$exist++;
				} else {
					$name = explode(" ", $line[0], 2);
					try {
						//Add Contact to the database
						$contact->create(array(
							'company' => '',
							'band' => '',
							'first_name' => $name[0],
							'last_name' => (!empty($name[1]) ? $name[1] : ''),
							'email' => $line[2],
							'add_line_1' => $line[4],
							'add_line_2' => '',
							'state' => $line[5],
							'city' => $line[6],
							'post_code' => $line[7],
							'phone' => $line[3],
							'mobile' => '',
							'notes' => '',
							'date_created' => date('d-m-Y'),
							'date_modified' => date('d-m-Y')
						));
						$new++;
					} catch (Exception $e) {
						Session::flash('home', '<span class="bold">' . $row . '</span> record'.($row > 1 ? 's were' : ' was').' found. <span class="bold">' . $new . '</span> record'.($new > 1 ? 's were' : ' was').' added<br /> The following error occurred: <span class="bold">' . $e->getMessage().'</span>');
						Redirect::to('index.php'); //Redirect user and display error
						exit();
					}
				}

				$row++;
			}
			fclose($csv_file);
			Session::flash('home', 'The CSV was imported successfully.<br /><span class="bold">'.$row.'</span> record'.($row > 1 ? 's were' : ' was').' were found. <span class="bold">'.$new.'</span> record'.($new > 1 ? 's were' : ' was').' added and <span class="bold">'.$exist.'</span> record'.($exist > 1 ? 's' : '').' already existed');
			Redirect::to('index.php'); //Redirect user and display message
		}

	} else {
		echo '<ul class="error"><li>Please select a file with an extension of .csv</li></ul>';
	}
}
?>
 <form action="" method="post" enctype="multipart/form-data" >
	<div class="formContainer">
		<div class="input-group">
			<span class="input-group-btn">
				<span class="btn btn-primary btn-file">
					Browse<input type="file" name="csv" required />
				</span>
			</span>
			<input type="text" name="csv" class="form-control" readonly>
		</div>
		<div class="field-submit">
			<input type="submit" name="submit" value="Upload" />
		</div>
	</div>
</form>

<?php
include 'includes/foot.inc.php';
?>



			
