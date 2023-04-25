<!-- Valid registration code -->

<?php
    include_once "includes/getRegistrationInfo.php";
?>

<link rel="stylesheet" type="text/css" href=<?php echo LNK_INTTELINPUT_CSS; ?> />
<script type="text/javascript" src=<?php echo LNK_INTTELINPUT_JS; ?> ></script>
<script type="text/javascript">
	var err_fields_empty = "<?php echo ERR_REGISTER_FIELDS_EMPTY; ?>";
	var err_passwords_unmatch = "<?php echo ERR_REGISTER_PASSWORDS_NOT_MATCH; ?>";
	var err_passwords_req = "<?php echo ERR_PASSWORD_REQ; ?>";
    $(function() {
        $( '#form-phone' ).intlTelInput({
            utilsScript: '../js/utils.js'
        });
        
        $( '.intl-tel-input' ).css(
            "display", "block"
        );
    });
</script>
<script type="text/javascript" src=<?php echo LNK_ROOT . "/tenant/js/validate-reg-form.js?" . md5(uniqid()); ?> ></script>

<!-- tenant form div -->
<div id="registration-div">
    <div id="page-title-div" class="text-center">
        <h3>
            <?php echo WORD_REGISTRATION_TITLE;?>
        </h3>
        <p><?php echo date("F d, Y", $start_date) . " to " . date("F d, Y", $end_date); ?></p>
        <p><?php echo strtoupper($rent_term); ?> TERM</p>
    </div>

    <div id="alert-div" class="alert alert-danger" role="alert">
        
    </div>

    <?php
        if ($registration->errors) {
            $content = "<div id='alerts-div' class='alert alert-danger' role='alert'>";
            
            foreach ($registration->errors as $error) {
                $content .= "<p>" . $error . "</p>";
            }

            $content .= "</div>";
            echo $content;
        }
    ?>

    <form class="form-horizontal" role="form" method="POST">
        <input type="hidden" name="k" value="<?php echo $_GET['k']; ?>" />
        <input type="hidden" name="email" value="<?php echo $email; ?>" />
        <input type="hidden" name="start-date" value="<?php echo $start_date; ?>" />
        <input type="hidden" name="end-date" value="<?php echo $end_date; ?>" />
        <input type="hidden" name="term" value="<?php echo $rent_term; ?>" />

        <div>
            <div class="page-header">
                <h4>
                    <?php echo WORD_REGISTRATION_ACCOUNT_TITLE;?>
                </h4>
            </div>

            <div class="fields-div">
                <div class="form-group">
                    <label class="control-label col-sm-3"><?php echo WORD_REGISTRATION_ACCOUNT_LABEL_1;?></label>
                    <div class="col-sm-8 col-sm-offset-1">
                        <p id="form-email" class="form-control-static"><span id="sp-email"><?php echo strtolower($email); ?></span></p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="form-password" class="control-label col-sm-3"><?php echo WORD_REGISTRATION_ACCOUNT_LABEL_2;?></label>
                    <div class="col-sm-8 col-sm-offset-1">
                        <input type="password" id="form-password" name="password" class="form-control" placeholder="<?php echo WORD_REGISTRATION_ACCOUNT_LABEL_2;?>" value=""/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="form-confirm" class="control-label col-sm-3"><?php echo WORD_REGISTRATION_ACCOUNT_LABEL_3;?></label>
                    <div class="col-sm-8 col-sm-offset-1">
                        <input type="password" id="form-confirm" name="confirm" class="form-control" placeholder="<?php echo WORD_REGISTRATION_ACCOUNT_LABEL_3;?>" value=""/>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="page-header">
                <h4>
                    <?php echo WORD_REGISTRATION_PERSONAL_TITLE;?>
                </h4>
            </div>

            <div class="fields-div">
                <div class="form-group">
                    <label for="form-fname" class="control-label col-sm-3"><?php echo WORD_REGISTRATION_PERSONAL_LABEL_1;?></label>
                    <div class="col-sm-8 col-sm-offset-1">
                        <input type="text" id="form-fname" name="fname" class="form-control" placeholder="<?php echo WORD_REGISTRATION_PERSONAL_LABEL_1;?>" value="<?php echo ucwords(strtolower($fname)); ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="form-lname" class="control-label col-sm-3"><?php echo WORD_REGISTRATION_PERSONAL_LABEL_2;?></label>
                    <div class="col-sm-8 col-sm-offset-1">
                        <input type="text" id="form-lname" name="lname" class="form-control" placeholder="<?php echo WORD_REGISTRATION_PERSONAL_LABEL_2;?>" value="<?php echo ucwords(strtolower($lname)); ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="form-lname" class="control-label col-sm-3"><?php echo WORD_REGISTRATION_PERSONAL_LABEL_3;?></label>
                    <div class="col-sm-8 col-sm-offset-1">
                        <input type="text" id="form-phone" name="phone" class="form-control" value="<?php echo $phone; ?>" />
                    </div>
                </div>
            </div>
        </div>

        <div class="fields-div text-right">
            <button class="btn btn-primary" id="btn-register" name="register"><?php echo WORD_REGISTER;?></button>
        </div>
    </form>
</div> <!-- end of div -->