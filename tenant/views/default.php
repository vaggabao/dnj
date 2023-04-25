<?php
    require_once("classes/Account.php"); 
    $account = new Account();
    
    // fetch tenant info
    $data = $account->getAccountInfo();
    $data = objectToArray($data);

    // set tenant info variables
    $tenant_id = $data['tenant_id'];
    $email = $data['email'];
    $fname = ucwords(strtolower($data['fname']));
    $lname = ucwords(strtolower($data['lname']));
    $phone = $data['phone'];
    $start_date = $data['start_date'];
    $end_date = $data['end_date'];
    $dates_stay = date("F d, Y", strtotime($start_date)) . " to " . date("F d, Y", strtotime($end_date));
    $rent_term = ucwords(strtolower($data['rent_term']));
    $registration_date = strtotime($data['registration_datetime']);

    
    // get existing housekeeping request
    $sql_housekeeping = "SELECT h.billing_id, h.housekeeping_date, h.is_paid FROM tbl_housekeeping h, tbl_tenant t WHERE t.id = h.tenant_id AND t.user_id = $user_id AND h.is_cancelled = 0 AND h.is_done = 0";
    $result_housekeeping = mysqli_query($conn, $sql_housekeeping);

    if ($rs = $result_housekeeping->fetch_array(MYSQLI_ASSOC)) {
        $housekeeping_date = date("F d, Y", strtotime($rs['housekeeping_date']));

        $content_cleaning = WORD_DEFAULT_EXIST_CLEANING_CONTENT_1 . $housekeeping_date . WORD_DEFAULT_EXIST_CLEANING_CONTENT_2;
        $content_cleaning .= "<div class='clearfix'></div>
                    <div class='pull-right'>
                        <a class='btn btn-primary btn-xs' href=" . LNK_ROOT . "/tenant/dashboard/home?view=2>" . WORD_VIEW . "</a>
                    </div>
                    <div class='clearfix'></div>"
        ;
    } else {
        $content_cleaning = WORD_DEFAULT_CLEANING_CONTENT;
        $content_cleaning .= "<div class='clearfix'></div>
                    <div class='pull-right'>
                        <a class='btn btn-primary btn-xs' href=" . LNK_ROOT . "/tenant/dashboard/home?view=2>" . WORD_REQUEST ."</a>
                    </div>
                    <div class='clearfix'></div>"
        ;
    }
    
    // get existing extension. if there is
    $sql_get_extension = "SELECT * FROM tbl_extension WHERE tenant_id = $tenant_id AND is_accepted = 0 AND is_cancelled = 0";
    $result_get_extension = mysqli_query($conn, $sql_get_extension);
    
    if ($rs = $result_get_extension->fetch_array(MYSQLI_ASSOC)) {
        $extension_date = date("F d, Y", strtotime($rs['extension_date']));
    
        $content_extend = WORD_DEFAULT_EXIST_EXT_CONTENT_1 . $extension_date . WORD_DEFAULT_EXIST_EXT_CONTENT_2;
        $content_extend .= "<div class='clearfix'></div>
                    <div class='pull-right'>
                        <a class='btn btn-primary btn-xs' href=" . LNK_ROOT . "/tenant/dashboard/account?edit=3>" . WORD_VIEW . "</a>
                    </div>
                    <div class='clearfix'></div>"
        ;
    } else {
        $content_extend = WORD_DEFAULT_EXT_CONTENT;
        $content_extend .= "<div class='clearfix'></div>
                    <div class='pull-right'>
                        <a class='btn btn-primary btn-xs' href=" . LNK_ROOT . "/tenant/dashboard/account?edit=3>" . WORD_REQUEST . "</a>
                    </div>
                    <div class='clearfix'></div>"
        ;
    }
    
    function objectToArray($d) {
        if (is_object($d)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $d = get_object_vars($d);
        }
 
        if (is_array($d)) {
            /*
            * Return array converted to object
            * Using __FUNCTION__ (Magic constant)
            * for recursive call
            */
            return array_map(__FUNCTION__, $d);
        }
        else {
            // Return array
            return $d;
        }
    }
?>

<script type="text/javascript" src=<?php echo LNK_ROOT . "/tenant/js/jquery.autogrow-textarea.js"; ?> ></script>
<script type="text/javascript">
    var tenant_id = <?php echo $tenant_id; ?>;

    $( '#message-textarea' ).autogrow();
</script>
<script type="text/javascript" src=<?php echo LNK_ROOT . "/tenant/js/sendMessage.js"; ?> ></script>

<div id="page-title-div">
    <h3>
        <?php echo WORD_WELCOME . ucwords(strtolower($_SESSION['tenant_fname'] . " " . $_SESSION['tenant_lname'])); ?>!
    </h3>
</div>

<div class="row">
    <div id="home-div" class="col-sm-8">
        <!-- Account overview div -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <?php  echo WORD_DEFAULT_ACCOUNT_TITLE;?>
                        </h4>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label col-sm-4"><?php echo WORD_DEFAULT_ACCOUNT_LABEL_1;?></label>
                            <div class="col-sm-8">
                                <p id="form-name" class="form-control-static"><span id="sp-name"><?php echo $fname . " " . $lname; ?></span></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4"><?php echo WORD_DEFAULT_ACCOUNT_LABEL_2;?></label>
                            <div class="col-sm-8">
                                <p id="form-email" class="form-control-static"><span id="sp-email"><?php echo $email; ?></span></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4"><?php echo WORD_DEFAULT_ACCOUNT_LABEL_3;?></label>
                            <div class="col-sm-8">
                                <p id="form-dates" class="form-control-static"><span id="sp-dates"><?php echo $dates_stay; ?></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of account overview -->

        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <?php echo WORD_DEFAULT_REQUEST_TITLE;?>
                        </h4>
                    </div>

                    <div id="extension-div" class="panel-body">
                        <?php echo $content_extend; ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">
							<?php echo WORD_DEFAULT_CLEANING_TITLE;?>
                        </h4>
                    </div>

                    <div id="housekeeping-div" class="panel-body">
                        <?php echo $content_cleaning; ?>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- end of div -->

    <div id="sidebar-div" class="col-sm-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title">
					<?php echo WORD_DEFAULT_MESSAGE_TITLE;?>
                </h4>
            </div>

            <div class="panel-body">
                <div id="chat-div">
                    
                </div>


                <div class="form-group row">
                    <div id="message-text" class="col-sm-8">
                        <textarea id="message-textarea" class="form-control" placeholder="<?php echo WORD_DEFAULT_MESSAGE_PLACEHOLDER;?>"></textarea>
                    </div>
                    
                    <div class="col-sm-4">
                        <button type="submit" id="btn-send" class="btn btn-primary" name="send"><?php echo WORD_SEND;?></button>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>