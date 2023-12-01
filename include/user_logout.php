<?php
session_start();
$_SESSION['user_id'] = $user_id;
session_destroy();
header("Location: /index.php");
exit();
?>