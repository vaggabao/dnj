<!-- 
  - Housekeeping request is made
 -->

<?php
	if ($billing_paid == 0) {
		$content = "<p>" . WORD_HOUSEKEEPING_EXIST_CONTENT_1 . date('F d, Y', strtotime($housekeeping_date)) . WORD_HOUSEKEEPING_EXIST_CONTENT_2 . "</p>
					<br />
					<div class='text-right'>
						<form method='POST'>
							<a class='btn btn-primary btn-sm' href='bills'>" . WORD_PAY . "</a>
							<button type='submit' name='cancel_housekeeping' class='btn btn-danger btn-sm'>" . WORD_CANCEL . "</button>
						</form>
					</div>";
	} else if ($billing_paid == 1) {
		$content = "<p>" . WORD_HOUSEKEEPING_EXIST_CONTENT_3 . " (" . date('F d, Y', strtotime($housekeeping_date)) . ").</p>";
	}
?>

<!-- home div -->
<div id="home-div">
	<?php 
		echo $content;
	?>
</div> <!-- end of div -->
