<?php
session_start();
$_SESSION = [];
session_unset();
session_destroy();

header("location: ../web/login.php");
exit;
