<?php
$mysqli = new mysqli("localhost", "root", "", "student_db");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
