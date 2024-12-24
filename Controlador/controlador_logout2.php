<?php
session_start();
session_unset();
session_destroy();
header("Location: ../Vista/vista_login_cliente.php");
exit();
?>