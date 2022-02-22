<?php

$dbhost = "localhost";
$dbuser = "root_user";
$dbpwd = ":Lc+z{9UH*9qZ[aV";
$dbname = "bills";

$conn = mysqli_connect("$dbhost", "$dbuser", "$dbpwd", "$dbname");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
