<?
session_start();
if ( !ini_get( 'display_errors' ) ) {
    ini_set( 'display_errors', 1 );
}
ini_set( 'log_errors', 0 );

$SITE_PATH="";
$FULL_SITE_PATH="/";
$LOCAL_PATH=$_SERVER["DOCUMENT_ROOT"];

$db_param=array();
$db_param["server"]="database";
$db_param["base"]="fullcalendar";
$db_param["user"]="root";
$db_param["pass"]="tiger";
?>