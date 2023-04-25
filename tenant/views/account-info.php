<div class="row">
    <div id="sidebar-div" class="col-md-3">
        <ul class="nav nav-pills nav-stacked">
            <li class="active"><a href="account?view=1"><?php echo WORD_ACCOUNT_INFO;?></a></li>
            <li><a href="account?view=2"><?php echo WORD_PERSONAL_INFO;?></a></li>
            <li><a href="account?view=3"><?php echo WORD_RENT_INFO;?></a></li>
        </ul>
    </div>

    <div id="account-div" class="col-md-9 form-horizontal">
        <div id="page-title-div">
            <h3>
                <span id="sp-title"><?php echo WORD_ACCOUNT_INFO_TITLE;?></span> <span id="sp-edit"><a class="btn btn-primary btn-xs" href="account?edit=1"><?php echo WORD_EDIT_PASS;?></a></span>
            </h3>
        </div>
        
        <!-- info div -->
        <div id="info-div">
            <div id="info-view-div">
                <div class="form-group">
                    <label class="control-label col-sm-4"><?php echo WORD_EMAIL_ADDRESS;?></label>
                    <div class="col-sm-8">
                        <p id="form-email" class="form-control-static"><span id="sp-email"><?php echo strtolower($email); ?></span></p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-4"><?php echo WORD_REGISTRATION_DATE;?></label>
                    <div class="col-sm-8">
                        <p id="form-email" class="form-control-static"><span id="sp-email"><?php echo date("F d, Y h:i:s a", $registration_date); ?></span></p>
                    </div>
                </div>
            </div>
        </div> <!-- end of div -->
    </div>
</div>