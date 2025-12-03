<?php
session_start();
require_once __DIR__ . '/../../config/gajah.php';
$_SESSION = array();
session_destroy();
header('Location: ' . BASE_URL . 'index.php'); 
exit();
?>