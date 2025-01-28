<?php 
session_start();
unset($_SESSION["user"]);

header("Location: /forms/login.php");