<p><?php echo WORD_HOUSEKEEPING_CONTENT;?></p>
<br />

<!-- home div -->
<div id="home-div" class="text-center">
	<input type="hidden" id="start-date" value=<?php echo $start_date; ?> />
	<input type="hidden" id="end-date" value=<?php echo $end_date; ?> />

	<form role="form" action="" method="POST">
		<div class="form-group form-inline">
			<label class="control-label" for="housekeeping-date"><?php echo WORD_HOUSEKEEPING_LABEL_1;?></label>
			<input type="text" name="housekeeping_date" id="housekeeping-date" class="form-control text-center" placeholder="YYYY-MM-DD" readonly="readonly" />
		</div>
		<button type="submit" name="request_housekeeping" class="btn btn-primary btn-sm"><?php echo WORD_REQUEST;?></button>
	</form>
</div> <!-- end of div -->