<?php
session_start();
require_once(__DIR__ . '/../DBconnect.php');

// Only registrar allowed
if (!isset($_SESSION['userid']) || $_SESSION['userid'] !== 'reg') {
    header('Location: ../index.php');
    exit;
}

$studentid = $_POST['studentid'] ?? '';
$course = $_POST['course'] ?? '';

if ($studentid === '' || $course === '') {
    header('Location: ../views/register_dashboard.php');
    exit;
}

$studentid_e = mysqli_real_escape_string($conn, $studentid);
$course_e = mysqli_real_escape_string($conn, $course);

mysqli_query($conn, "DELETE FROM CoursesTaken WHERE StudentID='$studentid_e' AND CourseCode='$course_e'");

header('Location: ../views/register_view_student.php?userid=' . urlencode($_POST['userid'] ?? ''));
exit;
?>