<?php
session_start();
if(!isset($_SESSION['ser'])){
    header("Location: login.php");
}
?>
