<?php
session_start();
session_unset();
session_destroy();

header('Location: ../../Templates/login.html');
exit();
?>