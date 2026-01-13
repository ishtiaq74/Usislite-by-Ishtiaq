<?php
session_start();
require_once(__DIR__ . '/../DBconnect.php');

// Ensure user is logged in
if (!isset($_SESSION['userid'])) {
    header('Location: ../index.php');
    exit;
}

$studentid = $_POST['studentid'] ?? '';
$course = $_POST['course'] ?? '';
$section = $_POST['section'] ?? '';

// Basic validation: redirect back if required params missing
if ($studentid === '' || $course === '' || $section === '') {
    header('Location: ../views/faculty_course_students.php?course=' . urlencode($course) . '&section=' . urlencode($section));
    exit;
}

// Escape values and execute delete
$studentid_e = mysqli_real_escape_string($conn, $studentid);
$course_e = mysqli_real_escape_string($conn, $course);
$section_e = mysqli_real_escape_string($conn, $section);

mysqli_query($conn, "DELETE FROM CoursesTaken WHERE StudentID='$studentid_e' AND CourseCode='$course_e' AND SectionNo='$section_e'");

// Return to the course students page so faculty sees updated list
header('Location: ../views/faculty_course_students.php?course=' . urlencode($course) . '&section=' . urlencode($section));
exit;
?>
