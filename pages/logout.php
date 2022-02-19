<?php
  require_once($_SERVER["DOCUMENT_ROOT"]."/inc/config.php");
  unset($_SESSION["logUser"]);
  header("Location: $FULL_SITE_PATH");
?>