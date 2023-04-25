<?php
    require_once("../../config/config.php");
    require_once("../classes/Tenant.php");
    include("../translations/en.php");

    $tenant = new Tenant();

    $tenant->updateTenantActivity;
?>