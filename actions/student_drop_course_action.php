<?php
session_start();
require_once(__DIR__ . '/../DBconnect.php');

if (!isset($_SESSION['userid'])) {
    header('Location: ../index.php');
    exit;
}

$userid = $_SESSION['userid'];
$course = $_POST['coursecode'] ?? '';

if ($course === '') {
    header('Location: ../views/student_dashboard.php');
    exit;
}

$userid_esc = mysqli_real_escape_string($conn, $userid);
$course_esc = mysqli_real_escape_string($conn, $course);

$student_q = mysqli_query($conn, "SELECT StudentID FROM Student WHERE UserID='$userid_esc'");
if (!$student_q || mysqli_num_rows($student_q) == 0) {
    header('Location: ../views/student_dashboard.php');
    exit;
}

$student = mysqli_fetch_assoc($student_q);
$studentid_e = mysqli_real_escape_string($conn, $student['StudentID']);

mysqli_query($conn, "DELETE FROM CoursesTaken WHERE StudentID='$studentid_e' AND CourseCode='$course_esc'");

header('Location: ../views/student_dashboard.php');
exit;
?>