<?php
if (!defined('NOMBRE_SITIO')) {
    include_once(__DIR__. '/../../config/config.php');
}

session_start();
session_destroy();
header("Location:" . URL_BASE . "admin/index.php");

exit;

?>