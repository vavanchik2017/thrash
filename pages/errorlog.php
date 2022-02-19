<?
require_once($_SERVER["DOCUMENT_ROOT"]."/inc/config.php");
?>
<!DOCTYPE html>
<html>
    <?
    $pageTitle="Строительная компания Техностройкоттедж";
    $actItem=-1;
    require_once($_SERVER["DOCUMENT_ROOT"]."/maket/htmlHeader.php");
    ?>
<body class='content'>

    <?
    include_once($_SERVER["DOCUMENT_ROOT"]."/maket/header.php");
    ?>
    <div class='errorlog-content'>
        <img src="/img/error.png" alt=""/>
        <p style="margin:30px;  color: #293946; font-size:24px">
            Переданы неверные аутентификационные данные
        </p>
    </div>


</body>
</html>