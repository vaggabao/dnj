<link rel="stylesheet" type="text/css" href=<?php echo LNK_INTTELINPUT_CSS; ?> />
<script type="text/javascript" src=<?php echo LNK_INTTELINPUT_JS; ?> ></script>
<script type="text/javascript">
    $(function() {
        $( '#form-phone' ).intlTelInput({
            utilsScript: '../js/utils.js'
        });
        
        $( '.intl-tel-input' ).css(
            "display", "block"
        );
    });
</script>

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
                <span id="sp-title"><?php echo WORD_PERSONAL_EDIT_TITLE;?></span>
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
                
                <form role="form" action="" method="POST">
                    <div class="form-group">
                        <label for="form-fname" class="control-label col-sm-4"><?php echo WORD_PERSONAL_FNAME;?></label>
                        <div class="col-sm-8">
                            <input type="text" id="form-fname" class="form-control" name="fname" title="first name" value="<?php echo $fname; ?>" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="form-lname" class="control-label col-sm-4"><?php echo WORD_PERSONAL_LNAME;?></label>
                        <div class="col-sm-8">
                            <input type="text" id="form-lname" class="form-control" name="lname" title="last name" value="<?php echo $lname; ?>" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="form-phone" class="control-label col-sm-4"><?php echo WORD_PERSONAL_PHONE;?></label>
                        <div class="col-sm-8">
                            <input type="text" id="form-phone" class="form-control" name="phone" title="phone number" value="<?php echo $phone; ?>" required />
                        </div>
                    </div>

                    <div class="info-edit-footer">
                        <button type="submit" id="btn-save-personal" class="btn btn-primary btn-sm" name="update-personal"><?php echo WORD_SAVE;?></button>
                        <a id="btn-cancel-account" class="btn btn-default btn-sm" href="account?view=2"><?php echo WORD_BACK;?></a>
                    </div>
                </form>
            </div>
        </div> <!-- end of div -->
    </div>
</div>