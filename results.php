<?php
/**
	* results.php
	*
	* Displays results data from the quick search bar
	*
	* @author	Angus Vine <angus.vine@internode.on.net>
	* @version	1.0
	* @since	5.5	(The php version used)
*/

require_once 'core/init.php';

// check if search keywords exist
if (Input::exists('get') && !empty(Input::get('q'))) {

	$q = Input::get('q');
	$contact = new Contact();
	
	try {
		//search for keywords
		$results = $contact->quickSearch($q); //perform complete search to get time and result values
	} catch (Exception $e) {
		Session::flash('home', $e->getMessage());
		Redirect::to('index.php');
		exit();
	}
	
	if(isset($_GET['p'])) {
	$current_page = Input::get('p');
	} else {
		$current_page = 1; //set current page number if no page number exist in the get variable
		$_SESSION['query_dur'] = round($contact->data()->queryDuration(), 4); //get the query time
	}
	$results_per_page = 15; //set the amount of results displayed per page (to be moved to config page)
	$query_dur = $_SESSION['query_dur'];
	$total_results = $contact->data()->count(); // get total amount to results
	try {
		$page_results = $contact->quickSearch($q, $current_page, $results_per_page); //query specified amount and position of results
	} catch (Exception $e) {
		Session::flash('home', $e->getMessage());
		Redirect::to('index.php'); // redirect and display error messages
		exit();
	}
	$total_pages = ceil($total_results / $results_per_page); // set total pages of results found
		
	include 'includes/head.inc.php';
?>
<div class="sub-headerContainer">
	<div class="sub-header">
		<h2>Search Results</h2>
	</div>
	<div class="sub-navigation">
		<span class="stats">Search for 
			<span class="bold"><?php echo $q; ?></span> returned 
			<span class="bold"><?php echo $total_results; ?></span> results and took
			<span class="bold"><?php echo $query_dur; ?></span> seconds
		</span>
	</div>
</div>
<div class="resultsContainer">
	<ul class="ul-result">
<?php
		//Display results
		if (!$results) {
			echo "Your search returned no results!";
		} else {
			foreach($page_results as $result) {
?>
				<li>
					<a href="contact.php?id=<?php echo $result->id; ?>" class="contact-link">
						<div class="result">
							<div class="name"><span><?php echo $result->first_name." ".$result->last_name; ?></span></div>
							<div class="email"><span><?php echo $result->email; ?></span></div>
							<div class="phone"><span><?php echo $result->phone; ?></span></div>
							<div class="mobile"><span><?php echo $result->mobile; ?></span></div>
						</div>
					</a>
					<div class="clear"></div>
				</li>
<?php						
			}
		
?>
	</ul>
</div>

<div class="search-pages">
<?php
			// setup pagination
			if ($total_pages == 1) {
				$next_page = "disable";
				$prev_page = "disable";
			} else if ($current_page == 1) {
				$next_page = "enable";
				$prev_page = "disable";
			} else if ($total_pages == $current_page) {
				$next_page = "disable";
				$prev_page = "enable";
			} else {
				$next_page = "enable";
				$prev_page = "enable";
			}
			
			echo '<span><a class="'.$prev_page.'" href="results.php?q='.$q.'&p='.($current_page-1).'"><< Previous </a></span>';

			for ($i=1; $i <= $total_pages; $i++) {
				echo '<span class="page-num"><a href="results.php?q='.$q.'&p='.$i.'">'.$i.'</a></span>';
			}

			echo '<span><a class="'.$next_page.'" href="results.php?q='.$q.'&p='.($current_page+1).'"> Next >></a></span>';
?>

</div>

<?php
		}
	
	include 'includes/foot.inc.php';
	

} else {
	Redirect::to('index.php');
}
?>



			
