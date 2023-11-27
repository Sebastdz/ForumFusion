<?php

$conn = mysqli_connect("localhost", "root", "", "forumfusion");

session_start();
session_unset();
session_destroy();

header('location:index.php');

?>