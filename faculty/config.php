<?php
$protocol='http://';
$host='localhost';
$username='root';
$password='';
$dbname='if0_36775444_eattendance';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>