<?
// //Извлекаем данные о здании с указанным идентификатором. Пока из XML-файла...
// function getHouseInfo($idHouse)
// {
//     global $LOCAL_PATH;
//     $xmlStr = simplexml_load_file($LOCAL_PATH . '/inc/houses.xml');
//     $houses = $xmlStr->xpath("house[@id=\"$idHouse\"]");
//     if (count($houses) == 1)
//         return $houses[0];
//     else {
//         $nohouses = $xmlStr->xpath("house[@id=\"-1\"]");
//         return $nohouses[0];
//     }
// }
// //Проверяем логин-парль пользователя по базе в xml-файле
// function checkLogInfo($log, $pas)
//  {
//      global $LOCAL_PATH;
//      $xmlStr = simplexml_load_file($LOCAL_PATH . '/inc/userInfo.xml');
//      $users = $xmlStr->xpath("user[login=\"$log\"]");
//      if (count($users) == 1 && $users[0]->pass==sha1($pas))
//             return true;
//      return false;
//  }
// //Извлекаем данные о пользловател с указанным логином. Пока из XML-файла...
// function getUserInfo($logUser)
// {
//     global $LOCAL_PATH;
//     $xmlStr = simplexml_load_file($LOCAL_PATH . '/inc/userInfo.xml');
//     $users = $xmlStr->xpath("user[login=\"$logUser\"]");
//     if (count($users) == 1)
//         return $users[0];
//     else {
//         $nouser = $xmlStr->xpath("user[login=\"noname\"]");
//         return $nouser[0];
//     }
// }

function checkRegUserInfo($regInfo)
{
    global  $LOCAL_PATH;;
    $status = "";
    if (!isset($regInfo["login"]) || isset($regInfo["login"]) && !preg_match("/^[a-zA-Z0-9_]{1,10}$/u", $regInfo["login"]))
        $status = "логин, ";
    if (!isset($regInfo["fio"]) || isset($regInfo["fio"]) && !preg_match("/^[А-ЯЁ][а-яё]+ [А-ЯЁ][а-яё]+ [А-ЯЁ][а-яё]+$/u", $regInfo["fio"]))
        $status .= "ФИО, ";
    if (isset($regInfo["mail"]) && $regInfo["mail"]!="" && !preg_match("/^[\-\._a-z0-9]+@(?:[a-z0-9][\-a-z0-9]+\.)+[a-z]{2,6}$/u", $regInfo["mail"]))
        $status .= "адрес почты, ";
    if (!isset($regInfo["pass"]) || isset($regInfo["pass"]) && !preg_match("/^[a-zA-Z0-9_]{1,10}$/u", $regInfo["pass"]))
        $status .= "пароль, ";
    if (!isset($regInfo["pass_confirm"]) || !isset($regInfo["pass"]) || isset($regInfo["pass_confirm"]) &&
        isset($regInfo["pass"]) && $regInfo["pass_confirm"] != $regInfo["pass"])
           $status .= "неверное подтверждение пароля, ";
    global $FULL_SITE_PATH;
    if (isset($regInfo["login"])){
         $xmlStr = simplexml_load_file($LOCAL_PATH . '/inc/userInfo.xml');
         $users = $xmlStr->xpath("user[login=\"" . $regInfo["login"] . "\"]");
         if (count($users) > 0)
            $status .= "уже есть такой логин, ";
           }
   // Проверка загруженного изображения
    $max_image_size	= 3 * 1024 * 1024* 1024;
    $max_image_width	= 300;
    $max_image_height	= 300;
    $valid_types = array("jpg", "png", "jpeg");

    if (isset($_FILES["foto"]) && is_uploaded_file($_FILES['foto']['tmp_name'])) {
            $filename = $_FILES['foto']['tmp_name'];
            $ext = substr($_FILES['foto']['name'], 1 + strrpos($_FILES['foto']['name'], "."));
            if (filesize($filename) > $max_image_size) {
                $status.="слишком большой файл, ";
            }
            elseif (!in_array($ext, $valid_types)) {
                $status.="неверный фомат файла, ";
            } else {
                $size = GetImageSize($filename);
                if (!($size) || ($size[0] > $max_image_width) || ($size[1] > $max_image_height)) {
                    $status.="неверный размер изображения, ";
                    }
                  }
            }


    if($status=="")
       return "ok";
    else
        return substr($status,0,-2);
}

// function checkRegExp($str, $template, $maxLen=0)
// {
//     switch($template)
//     {
//         case "login":
//             return preg_match("/^[a-zA-Z0-9_]{1,10}$/u", $str);

//         case "pass":
//             return preg_match("/^[a-zA-Z0-9_]{1,10}$/u",$str);

//         case "mail":
//             return preg_match("/^[\-\._a-z0-9]+@(?:[a-z0-9][\-a-z0-9]+\.)+[a-z]{2,6}$/u",$str);

//         case "fio":
//             return preg_match("/^[А-ЯЁ][а-яё]+ [А-ЯЁ][а-яё]+ [А-ЯЁ][а-яё]+$/u",$str);
//         case "cyrReg_1":
//             return preg_match("/^[а-яА-ЯёЁ0-9_ ]{1,$maxLen}$/u", $str);
//         case "cyrAddr":
//             return preg_match("/^[а-яА-ЯёЁ0-9_\-,. ]{1,50}$/u", $str);
//         case "cyrReg_2":
//             return preg_match("/^[а-яА-ЯёЁ0-9_\-\/,.<>a-zA-Z\n\r ]{1,$maxLen}$/u", $str);
//        default:
//             return false;

//     }


// }

// function saveUserInfo($userInfo)
// {

//     global $LOCAL_PATH;
//     $xmlStr = simplexml_load_file($LOCAL_PATH . '/inc/userInfo.xml');
//     $newUser = $xmlStr->addChild('user');
//     $newUser->addChild('login', $userInfo["login"]);
//     $newUser->addChild('fio', $userInfo["fio"]);
//     $newUser->addChild('mail', $userInfo["mail"]);
//     $newUser->addChild('pass', sha1($userInfo["pass"]));
//     if (isset($_FILES["foto"]) && is_uploaded_file($_FILES['foto']['tmp_name'])) {
//         $filename = $_FILES['foto']['name'];
//         $newUser->addChild('img', $filename);
//         move_uploaded_file($_FILES['foto']['tmp_name'], "../img/users/".$_FILES['foto']['name']);
//     }
//     $dom = new DOMDocument("1.0","utf-8");
//     $dom->preserveWhiteSpace = false;
//     $dom->formatOutput = true;
//     $dom->loadXML($xmlStr->asXML());
//     $dom->save($LOCAL_PATH."/inc/userInfo.xml");

// //    $xmlStr->asXML($LOCAL_PATH."/inc/userInfo.xml");



// }
?>