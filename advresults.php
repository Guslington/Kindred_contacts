<?php
/**
	* advresults.php
	*
	* Displays the results of the advanced serach
	*
	* @author	Angus Vine <angus.vine@internode.on.net>
	* @version	1.0
	* @since	5.5	(The php version used)
*/

require_once 'core/init.php';

if (Input::exists('get')) {

	$q = $_GET;
	unset($q['p']);
	$q = array_filter($q);
	
	$contact = new Contact();
	
	try {
		$results = $contact->advancedSearch($q);
	} catch (Exception $e) {
		Session::flash('home', $e->getMessage());
		Redirect::to('index.php');
		exit();
	}
	
	if (isset($_GET['p'])) {
	$current_page = Input::get('p');
	} else {
		$current_page = 1;
		$_SESSION['query_dur'] = round($contact->data()->queryDuration(), 4);
	}
	$results_per_page = 15;
	$query_dur = $_SESSION['query_dur'];
	$total_results = $contact->data()->count();
	try {
		$page_results = $contact->advancedSearch($q, $current_page, $results_per_page);
	} catch (Exception $e) {
		Session::flash('home', $e->getMessage());
		Redirect::to('index.php');
		exit();
	}
	$total_pages = ceil($total_results / $results_per_page);
		
	include 'includes/head.inc.php';
?>
<div class="sub-headerContainer">
	<div class="sub-header">
		<h2>Search Results</h2>
	</div>
	<div class="sub-navigation">
		<span class="stats">Your 
			<span class="bold"> Advanced Search</span> returned 
			<span class="bold"><?php echo $total_results; ?></span> results and took
			<span class="bold"><?php echo $query_dur; ?></span> seconds
		</span>
	</div>
</div>
<div class="resultsContainer">
	<ul class="ul-result">
<?php
		
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
// Sets up the pagination
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
			
			$q = http_build_query($q);
			echo '<span><a class="'.$prev_page.'" href="advresults.php?'.$q.'&p='.($current_page-1).'"><< Previous </a></span>';

			for ($i=1; $i <= $total_pages; $i++) {
				echo '<span class="page-num"><a href="advresults.php?'.$q.'&p='.$i.'">'.$i.'</a></span>';
			}

			echo '<span><a class="'.$next_page.'" href="advresults.php?'.$q.'&p='.($current_page+1).'"> Next >></a></span>';
?>

</div>

<?php
		}
	
	include 'includes/foot.inc.php';
} else {
	Session::flash('back', 'Please enter a search query');
	Redirect::to('advancedsearch.php');
}
?>



			
