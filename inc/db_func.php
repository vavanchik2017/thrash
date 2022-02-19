<?php
function connect_db($db_param)
{
    $conn = mysqli_connect($db_param["server"], $db_param["user"], $db_param["pass"], $db_param["base"]);
    if ($conn)
      mysqli_set_charset($conn, "utf8");
    return $conn;
}

function getAllProductsInfo(){
    global $db_param;
    $conn = connect_db($db_param);
    if ($conn != null) {
        $query = "SELECT * FROM store order by id";
        $result = mysqli_query($conn, $query);
        if ( mysqli_num_rows($result) > 0) {
            $storeInfo=array();
            while($st=mysqli_fetch_array($result))
                $storeInfo[]=$st;
            return $storeInfo;}
        mysqli_free_result($result);
        return array();
    }
    return array();
}

// function getAllVarietes() {
//     global $db_param;
//     $conn = connect_db($db_param);
//     if ($conn != null) {
//         $query = "SELECT * FROM varietes order by id";
//         $result = mysqli_query($conn, $query);
//         if ( mysqli_num_rows($result) > 0) {
//             $varietesInfo=array();
//             while($vr=mysqli_fetch_array($result))
//                 $varietesInfo[]=$vr;
//             return $varietesInfo;}
//         mysqli_free_result($result);
//         return array();
//     }
//     return array();
// }

function getHouseInfo($idHouse)
{
    global $db_param;
    $status = array();
    if (!is_numeric($idHouse)) {
        $status["houseInfo"] = null;
        $status["status_string"] = "Некорректный идентификатор здания";
        return $status;
    }
    $conn = connect_db($db_param);
    if ($conn != null) {
        $query = "select * from houses where id=$idHouse";
        $result = mysqli_query($conn, $query);
        echo($result);
        if (mysqli_num_rows($result) > 0) {
            $status["houseInfo"] = mysqli_fetch_assoc($result);
            $status["status_string"]="ok";
        }
        else {
            {
                $status["houseInfo"] = null;
                $status["status_string"] = "Нет такого здания";
            }
        }
        mysqli_free_result($result);
        mysqli_close($conn);
        return $status;
    }
        $status["houseInfo"] = null;
        $status["status_string"] = "Нет соединения с базой данных";
        return $status;

}

function checkRegExp($str, $template, $maxLen=0)
{
    switch($template)
    {
        case "login":
            return preg_match("/^[a-zA-Z0-9_]{1,10}$/u", $str);

        case "pass":
            return preg_match("/^[a-zA-Z0-9_]{1,10}$/u",$str);

        case "mail":
            return preg_match("/^[\-\._a-z0-9]+@(?:[a-z0-9][\-a-z0-9]+\.)+[a-z]{2,6}$/u",$str);

        case "fio":
            return preg_match("/^[А-ЯЁ][а-яё]+ [А-ЯЁ][а-яё]+ [А-ЯЁ][а-яё]+$/u",$str);
        case "cyrReg_1":
            return preg_match("/^[а-яА-ЯёЁ0-9_ ]{1,$maxLen}$/u", $str);
        case "cyrAddr":
            return preg_match("/^[а-яА-ЯёЁ0-9_\-,. ]{1,50}$/u", $str);
        case "cyrReg_2":
            return preg_match("/^[а-яА-ЯёЁ0-9_\-\/,.<>a-zA-Z\n\r ]{1,$maxLen}$/u", $str);
       default:
            return false;

    }


}

//Проверяем логин-парль пользователя по MySQLбазе
function checkLogInfo($log, $pas)
{

    global $db_param;
    $status = array();
    if (!checkRegExp($log, "login") || !checkRegExp($pas, "pass")) {
        $status["logStatus"] = false;
        $status["status_string"] = "Некорректные логин или пароль";
        return $status;
    }
    $conn = connect_db($db_param);
    if ($conn != null) {
        $query = "select id from users where login=\"$log\" and pass=sha1(\"$pas\")";
        $result = mysqli_query($conn, $query);
        //считать данные о пользователе
        if (mysqli_num_rows($result) > 0)
                 $status["logStatus"] = true;
        else {
            $status["logStatus"] = false;
            $status["status_string"] = "Неверный пароль";
        }
        mysqli_free_result($result);
        mysqli_close($conn);
        return $status;
    }
}



//Извлекаем данные о пользловател с указанным логином. Теперь из MySQL-базы
function getUserInfo($logUser)
{
    global $db_param;

    if (!checkRegExp($logUser, "login"))
        return null;

    $conn = connect_db($db_param);
    $query = "select * from users where login=\"$logUser\"";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0)
     {  $userInfo= mysqli_fetch_assoc($result);
        if($userInfo["img"]==null)

                $userInfo["img"]="noname.png";
            }
    else {
      $userInfo=null;
    }

    mysqli_free_result($result);
    mysqli_close($conn);
    return $userInfo;

}

//Сохранить информацию о пользлователе в БД
function saveUserInfo($userInfo)
{
    global $db_param;

    $conn = connect_db($db_param);
    if ($conn != null) {
        $imgStrTo="";$imgStrVal="";
        if (isset($_FILES["foto"]) && is_uploaded_file($_FILES['foto']['tmp_name'])) {
            $filename = $_FILES['foto']['name'];
             $imgStrTo=" ,img"; $imgStrVal=" ,\"$filename\"";
            move_uploaded_file($_FILES['foto']['tmp_name'], $_SERVER["DOCUMENT_ROOT"] ."/img/users/" . $_FILES['foto']['name']);
        }
        $query = "insert into users  (login, fio, mail, pass $imgStrTo) values (\"{$userInfo["login"]}\", \"{$userInfo["fio"]}\",
        \"{$userInfo["mail"]}\", sha1(\"{$userInfo["pass"]}\") $imgStrVal)";
        return mysqli_query($conn, $query);

    }
    return false;



}

function getLastBuildings($count)
{
    global $db_param;
    if (!is_numeric($count))
        return null;
    $conn = connect_db($db_param);
    if ($conn != null) {
        $query = "SELECT * FROM houses order by id desc limit $count";
        $result = mysqli_query($conn, $query);
    if ( mysqli_num_rows($result) > 0) {
        $housesInfo=array();
        while($hi=mysqli_fetch_array($result))
           $housesInfo[]=$hi;
        mysqli_free_result($result);
        return $housesInfo;}


      return null;

    }
    return null;

}


function getAllBuildingsInfo()
{
    global $db_param;
    $conn = connect_db($db_param);

    if ($conn != null) {
        $query = "SELECT * FROM houses order by id";
        $result = mysqli_query($conn, $query);
        if ( mysqli_num_rows($result) > 0) {
            $buildingsInfo=array();
            while($bi=mysqli_fetch_array($result))
                $buildingsInfo[]=$bi;
            return $buildingsInfo;}
        mysqli_free_result($result);
        return array();
    }
    return array();

}

//Сохранить информацию о здании в БД
function saveBuildInfo($buildInfo)
{

    global $db_param;

    $conn = connect_db($db_param);
    if ($conn != null) {


     $filename = $_FILES['bFoto']['name'];
//удаляем из описания все теги, кроме <br> (у <br> удаляем также все атрибуты)

  /*  $buildInfo["bDesc"] = preg_replace("/(<.*?>)/", "", $buildInfo["bDesc"]);*/
      $buildInfo["bDesc"] =strip_tags($buildInfo["bDesc"]);
      $buildInfo["bDesc"] = preg_replace("/(\n)/", "<br>", $buildInfo["bDesc"]);

       $query = "insert into houses  (buildType, address, price, descr, img ) values (\"{$buildInfo["bType"]}\", \"{$buildInfo["bAddr"]}\",
        \"{$buildInfo["bCost"]}\", \"{$buildInfo["bDesc"]}\", \"$filename\")";
       if (mysqli_query($conn, $query))
       {
           $ext = ".".substr($_FILES['bFoto']['name'], 1 + strrpos($_FILES['bFoto']['name'], "."));
           $idNewBuild=mysqli_insert_id($conn);
           $filename="houseImg_".$idNewBuild.$ext;
           $query = "update  houses set img=\"$filename\" where id=$idNewBuild";
           mysqli_query($conn, $query);
           move_uploaded_file($_FILES['bFoto']['tmp_name'], $_SERVER["DOCUMENT_ROOT"] . "/img/houses/houseImg_" .$idNewBuild.$ext);
           return true;
       }
       else return false;
    }
    return false;

}

