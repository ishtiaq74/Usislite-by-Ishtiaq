<?php
session_start();
require_once(__DIR__ . '/../DBconnect.php');

if (!isset($_SESSION['userid'])) {
    header('Location: ../index.php');
    exit;
}

$studentid = $_POST['studentid'] ?? '';
$course    = $_POST['course'] ?? '';
$section   = $_POST['section'] ?? '';

if ($studentid === '' || $course === '' || $section === '') {
    header('Location: ../views/faculty_dashboard.php?status=missing');
    exit;
}

$studentid_e = mysqli_real_escape_string($conn, $studentid);
$course_e = mysqli_real_escape_string($conn, $course);
$section_e = mysqli_real_escape_string($conn, $section);

// Prevent duplicate
$check = mysqli_query($conn, "SELECT * FROM CoursesTaken WHERE StudentID='$studentid_e' AND CourseCode='$course_e'");
if ($check && mysqli_num_rows($check) == 0) {
    mysqli_query($conn, "INSERT INTO CoursesTaken (StudentID, CourseCode, SectionNo) VALUES ('$studentid_e', '$course_e', '$section_e')");
}

header('Location: ../views/faculty_dashboard.php?status=success');
exit;
?>