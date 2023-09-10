<?php
session_start();
// отключаем сессию
session_destroy();
header("Location: login.php");
