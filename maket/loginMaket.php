
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
    <div class='authorisation'>
      <?
        if(!isset($_SESSION["logUser"]))
        {
        ?>
      <form method="get" action="/pages/login.php">
        <div>
          <p class='auth-title'>ПОЛЬЗОВАТЕЛЬ</p>
          <input name="login" />
        </div>
        <div class='password-container'>
          <p class='auth-title'>ПАРОЛЬ</p>
          <input type="password" name='pass' />
          <button>ВХОД</button>
        </div>
        <div class='register-butt'>
          <a class='register-title' href="/pages/register.php">Регистрация</a>
        </div>
      </form>
      <?
        }
        else {
        ?>
      <div>
        <div class='exit-container'>
          <img src="../img/user_icon.png" alt='userIcon' class="icon" />
          <a href="/pages/userroom.php" class='exit-login-title'>
            <? echo $_SESSION["logUser"];?></a>
        </div>
        <div class='exit-login-button-container'>
          <a href="/pages/logout.php" class='exit-login-button'>Выйти</a>
        </div>
      </div>

      <?
        }
        ?>
    </div>

</body>
</html>