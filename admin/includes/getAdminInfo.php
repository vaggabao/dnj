<?php
    error_reporting(0);
    require_once("../../config/config.php");
    require_once("../classes/Login.php");
    include("../translations/en.php");

    $login = new Login();

    $data = $login->getInfo();
    $data = objectToArray($data);

    $id = ucwords(strtolower($data['id']));
    $fname = ucwords(strtolower($data['fname']));
    $lname = ucwords(strtolower($data['lname']));
    $name = $fname . " " . $lname;
    $username = strtolower($data['username']);



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


<!-- View account information -->
<div id="account-info" class="panel panel-danger">
    <div class="panel-heading">
        <h3 class="panel-title pull-left">Account Information</h3>
        <button type="submit" id="btn-update-account" class="btn btn-danger btn-xs pull-right">update account</button>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label col-sm-3">Name :</label>
            <div class="col-sm-9">
                <p id="form-name" class="form-control-static"><span id="sp-name"><?php echo $name; ?></span></p>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-3">User Name :</label>
            <div class="col-sm-9">
                <p id="form-username" class="form-control-static"><span id="sp-username"><?php echo $username; ?></span></p>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-3">Password :</label>
            <div class="col-sm-9">
                <p id="form-pass" class="form-control-static"><span id="sp-pass">&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;</span></p>
            </div>
        </div>
    </div>
</div>

<!-- Edit account information -->

<div id="account-edit">
    <button id="btn-back" class="btn btn-default btn-sm">Back</button>
    <form method="POST">
    <div id="account-info-edit" class="panel panel-danger">
        <div class="panel-heading">
            <h3 class="panel-title pull-left">Edit Information</h3>
            <button type="submit" id="btn-update-info" class="btn btn-danger btn-xs pull-right">save</button>
            <div class="clearfix"></div>
        </div>

        <div class="panel-body">
            <div id="alert-info-div"></div>
            <div class="form-group">
                <label class="control-label col-sm-3">Name :</label>
                <div class="col-sm-9">
                    <input type="text" id="form-fname" class="form-control form-text" name="form-fname" value=<?php echo $fname; ?> />
                    <input type="text" id="form-lname" class="form-control form-text" name="form-lname" value=<?php echo $lname; ?> />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-3">User Name :</label>
                <div class="col-sm-9">
                    <input type="text" id="form-uname" class="form-control form-text" name="form-uname" value=<?php echo $username; ?> />
                </div>
            </div>
        </div>
    </div>
    </form>

    <form method="POST">
    <div id="password-edit" class="panel panel-danger">
        <div class="panel-heading">
            <h3 class="panel-title pull-left">Update Password</h3>

            <button type="submit" id="btn-update-pass" class="btn btn-danger btn-xs pull-right">update</button>
            <div class="clearfix"></div>
        </div> 

        <div class="panel-body">
            <div id="alert-pass-div"></div>
            <div class="form-group">
                <label class="control-label col-sm-3">Current Password :</label>
                <div class="col-sm-9">
                    <input type="password" id="form-current" class="form-control form-text" name="form-current" placeholder="current password" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-3">New Password :</label>
                <div class="col-sm-9">
                    <input type="password" id="form-password" class="form-control form-text" name="form-password" placeholder="new password" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-3">Repeat Password :</label>
                <div class="col-sm-9">
                    <input type="password" id="form-repeat" class="form-control form-text" name="form-repeat" placeholder="repeat password" />
                </div>
            </div>
        </div>
    </div>
    </form>

</div>