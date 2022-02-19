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
<body >
    <?
    include_once($_SERVER["DOCUMENT_ROOT"]."/maket/header.php");
    // include($_SERVER["DOCUMENT_ROOT"]."/maket/menu.php");
    ?>
    <div style='padding-top:30px; display:flex; justify-content:center'>
        <form  method="post" id="frmReg" enctype="multipart/form-data" action="/actions/registerUser.php" onsubmit="return check_form();">
            <p style='font-size: 18px'>Форма регистрации пользователей</p>
            <div style="display: flex; flex-direction:column; width: 500px; justify-content:space-around; padding-top:15px;">
                <input  class='register-content' id="login" name="login" type="text" placeholder="Логин *" autofocus required/>
                <input class='register-content' id="fio" name="fio" type="text" placeholder="ФИО *"  required/>
                <input class='register-content' size='20' id="mail" name="mail" placeholder="e-mail" type="email"/>
                <input class='register-content' id="pass" name="pass" type="password" placeholder="Пароль *" required/>
                <input class='register-content' id="pass_confirm" name="pass_confirm" type="password" placeholder="Подтверждение пароля *" required/>
                <input class='register-content' id="foto" name="foto" type="file" placeholder="фотография *" accept="image/jpeg, image/png"/>
                <input class='register-content' type="submit" value="Зарегистрироваться" />
            </div>
        </form>
    </div>
        <?
        if(isset($_GET['status']))
          echo "<div class='divErr'>Неверно заданы поля: ".$_GET["status"]."</div>";
        ?>
    <?
    // include_once($_SERVER["DOCUMENT_ROOT"]."/maket/footer.php");
    ?>
</body>
</html>