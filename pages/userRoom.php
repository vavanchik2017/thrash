<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/inc/config.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/inc/db_func.php");
if($_SESSION["logUser"])
{
    $userInfo=getUserInfo($_SESSION["logUser"]);
}
else
    header("Location: $FULL_SITE_PATH");
?>
<!DOCTYPE html>
<html>
    <?
    require_once($_SERVER["DOCUMENT_ROOT"]."/maket/htmlHeader.php");
    ?>
<body>

    <?
    include_once($_SERVER["DOCUMENT_ROOT"]."/maket/header.php");
    include($_SERVER["DOCUMENT_ROOT"]."/maket/infoBlocks/userInfo.php");
    ?>
    

</body>
</html>



