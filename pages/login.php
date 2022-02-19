<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/inc/config.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/inc/db_func.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/inc/service_func.php");


if(isset($_GET["login"]) && isset($_GET["pass"])) {
    $logConfirm=checkLogInfo($_GET["login"], $_GET["pass"]);
}
  
else
    $logConfirm=false;

if(is_array($logConfirm) && $logConfirm['logStatus']==true) {
    $_SESSION["logUser"]=$_GET["login"];
    header("Location: $FULL_SITE_PATH");
}
else {
    if(is_array($logConfirm))
        $errorStr=$logConfirm["status_string"];
    else
        $errorStr="Не заданы логин и пароль";
    include($_SERVER["DOCUMENT_ROOT"]."/pages/errorlog.php");
    unset($_SESSION["logUser"]);
}

?>