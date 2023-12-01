<?php
session_start();
$_SESSION['admin_id'] = $admin_id;
session_destroy();
header("Location: /admin/pages/admin.php");
?>