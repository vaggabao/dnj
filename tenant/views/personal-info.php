<div class="row">
    <div id="sidebar-div" class="col-md-3">
        <ul class="nav nav-pills nav-stacked">
            <li><a href="account?view=1"><?php echo WORD_ACCOUNT_INFO;?></a></li>
            <li class="active"><a href="account?view=2"><?php echo WORD_PERSONAL_INFO;?></a></li>
            <li><a href="account?view=3"><?php echo WORD_RENT_INFO;?></a></li>
        </ul>
    </div>

    <div id="account-div" class="col-md-9 form-horizontal">
        <div id="page-title-div">
            <h3>
                <?php echo WORD_PERSONAL_INFO_TITLE;?> <span id="sp-edit"><a class="btn btn-primary btn-xs" href="account?edit=2"><?php echo WORD_EDIT;?></a></span>
            </h3>
        </div>

        <!-- info div -->
        <div id="info-div">
            <div class="form-group">
                <label class="control-label col-sm-3"><?php echo WORD_PERSONAL_NAME;?></label>
                <div class="col-sm-9">
                    <p id="form-email" class="form-control-static"><span id="sp-name"><?php echo $fname . " " . $lname; ?></span></p>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-3"><?php echo WORD_PERSONAL_PHONE;?></label>
                <div class="col-sm-9">
                    <p id="form-email" class="form-control-static"><span id="sp-phone"><?php echo $phone; ?></span></p>
                </div>
            </div>
        </div> <!-- end of div -->
    </div>
</div>