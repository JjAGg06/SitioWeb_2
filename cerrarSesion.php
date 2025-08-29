<?php
session_start();
session_unset();
session_destroy();

// redirigir al inicio público
header("Location: index.php");
exit;
