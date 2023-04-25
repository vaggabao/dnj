
<script type="text/javascript" src=<?php echo LNK_ROOT . "/tenant/js/booking.js?" . md5(uniqid());?> ></script>
<link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/tenant/css/datepicker.css";?> />

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
                <span id="sp-title"><?php echo WORD_RENT_EDIT_TITLE;?></span>
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
				
				<input type="hidden" id="start-date" value=<?php echo $start_date; ?> />
				<input type="hidden" id="end-date" value=<?php echo $end_date; ?> />
				
				<?php					
					if (mysqli_num_rows($result_get_extension)) {
						include("views/extension_exists.php");
					} else {
						include("views/extension_requests.php");
					}
				?>
            </div>
        </div> <!-- end of div -->
    </div>
</div>