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
                <span id="sp-title"><?php echo WORD_UPDATE_PASS;?></span>
            </h3>
        </div>
        
        <!-- info div -->
        <div id="info-div">
            <div id="info-edit-div">
                <?php
                    if ($account->errors) {
                        $content = "<div id='info-edit-error-div' class='alert alert-danger alert-dismissable' role='alert'>
                                    <button type='button' class='close' data-dismiss='alert'>
                                        <span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span>
                                    </button>";
                        foreach ($account->errors as $error) {
                            $content .= "<p>" . $error . "</p>";
                        }
                        $content .= "</div>";
                        echo $content;
                    } elseif ($account->messages) {
                        $content = "<div id='info-edit-msg-div' class='alert alert-success alert-dismissable' role='alert'>
                                    <button type='button' class='close' data-dismiss='alert'>
                                        <span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span>
                                    </button>";
                        foreach ($account->messages as $message) {
                            $content .= "<p>" . $message . "</p>";
                        }
                        $content .= "</div>";
                        echo $content;
                    }
                ?>

                <form role="form" method="POST">
                    <div class="form-group">
                        <label for="form-password" class="control-label col-sm-4"><?php echo WORD_CURRENT_PASS;?></label>
                        <div class="col-sm-8">
                            <input type="password" id="form-password" class="form-control" name="old-password" value="<?php echo $_POST['old-password']; ?>" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="form-new-password" class="control-label col-sm-4"><?php echo WORD_NEW_PASS;?></label>
                        <div class="col-sm-8">
                            <input type="password" id="form-new-password" class="form-control" name="new-password" value="<?php echo $_POST['new-password']; ?>" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="form-re-password" class="control-label col-sm-4"><?php echo WORD_RETYPE_PASS;?></label>
                        <div class="col-sm-8">
                            <input type="password" id="form-re-password" class="form-control" name="re-password" value="<?php echo $_POST['re-password']; ?>" />
                        </div>
                    </div>

                    <div class="info-edit-footer">
                        <button type="submit" id="btn-save-account" class="btn btn-primary btn-sm" name="update-pass"><?php echo WORD_UPDATE_PASS;?></button>
                        <a id="btn-cancel-account" class="btn btn-default btn-sm" href="account?view=1"><?php echo WORD_BACK; ?></a>
                    </div>
                </form>
            </div>
        </div> <!-- end of div -->
    </div>
</div>