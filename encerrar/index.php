<?php
require_once "./../config/mysql.php";
logout();
header("X-Robots-Tag: none");

echo"<script>window.location.href='/'</script>";
?>