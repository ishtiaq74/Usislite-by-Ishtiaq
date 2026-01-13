<?php
session_start();
require_once(__DIR__ . '/../DBconnect.php');

if (!isset($_SESSION['userid'])) {
    header("Location: ../index.php");
    exit;
}

$userid = $_SESSION['userid'];

$stu = mysqli_query($conn, "SELECT * FROM Student WHERE UserID='$userid'");
$fac = mysqli_query($conn, "SELECT * FROM Faculty WHERE UserID='$userid'");

if (mysqli_num_rows($stu) === 1) {
    header("Location: student_dashboard.php");
    exit;
}
elseif (mysqli_num_rows($fac) === 1) {
    header("Location: faculty_dashboard.php");
    exit;
}
else {
    echo "No role assigned.";
}

