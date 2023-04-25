<div class="row">
    <div id="sidebar-div" class="col-md-3">
        <ul class="nav nav-pills nav-stacked">
            <li><a href="account?view=1"><?php echo WORD_ACCOUNT_INFO;?></a></li>
            <li><a href="account?view=2"><?php echo WORD_PERSONAL_INFO;?></a></li>
            <li class="active"><a href="account?view=3"><?php echo WORD_RENT_INFO;?></a></li>
        </ul>
    </div>

    <div id="account-div" class="col-md-9 form-horizontal">
        <div id="page-title-div">
            <h3>
                <?php echo WORD_RENT_INFO_TITLE;?> <span id="sp-edit"><a class="btn btn-primary btn-xs" href="account?edit=3"><?php echo WORD_EXTEND;?></a></span>
            </h3>
        </div>

        <!-- info div -->
        <div id="info-div">
            <div class="form-group">
                <label class="control-label col-sm-3"><?php echo WORD_RENT_ARRIVE;?></label>
                <div class="col-sm-9">
                    <p id="form-email" class="form-control-static"><span id="sp-start"><?php echo date("F d, Y", strtotime($start_date)); ?></span></p>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-3"><?php echo WORD_RENT_DEPART;?></label>
                <div class="col-sm-9">
                    <p id="form-email" class="form-control-static"><span id="sp-end"><?php echo date("F d, Y", strtotime($end_date)); ?></span></p>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-3"><?php echo WORD_RENT_TERM;?></label>
                <div class="col-sm-9">
                    <p id="form-email" class="form-control-static"><span id="sp-term"><?php echo $rent_term . " Term"; ?></span></p>
                </div>
            </div>
        </div> <!-- end of div -->
    </div>
</div>