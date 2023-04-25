<form role="form" action="" method="POST">
	<div id="extension-alert-div" class="alert alert-info">
		<p><?php echo WORD_EXT_CONTENT;?></p>
	</div>
	<div class="form-group">
		<label for="extension-date" class="control-label col-sm-4" ><?php echo WORD_EXT_LABEL_1;?></label>
		<div class="col-sm-8">
			<input type="text" name="extension_date" id="extension-date" class="form-control" placeholder="YYYY-MM-DD" value="" readonly="readonly" required />
		</div>
	</div>
	
	<div class="info-edit-footer">
		<button type="submit" name="request_extension" class="btn btn-primary btn-sm"><?php echo WORD_REQUEST;?></button>
		<a class="btn btn-default btn-sm" href="javascript:history.back()"><?php echo WORD_BACK;?></a>
	</div>
</form>