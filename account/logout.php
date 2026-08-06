<?php

session_start();

/* ---------------- LOGOUT ---------------- */

$_SESSION = [];

session_destroy();

/* ---------------- REDIRECT ---------------- */

header("Location: login.php");

exit();

?>