<form role="form" action="" method="POST">
	<div class="form-group">
		<label class="control-label col-sm-4" ><?php echo WORD_EXT_EXIST_LABEL_1;?></label>
		<div class="col-sm-8">
			<p class="form-control-static"><?php echo date("F d, Y", strtotime($end_date)); ?></p>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-sm-4" ><?php echo WORD_EXT_EXIST_LABEL_2;?></label>
		<div class="col-sm-8">
			<p class="form-control-static"><?php echo date("F d, Y", strtotime($extension_date)); ?></p>
		</div>
	</div>
	
	<div class="info-edit-footer">
		<button type="submit" name="cancel_extension" class="btn btn-danger btn-sm"><?php echo WORD_CANCEL;?></button>
		<a class="btn btn-default btn-sm" href="account?view=3"><?php echo WORD_BACK;?></a>
	</div>
</form>