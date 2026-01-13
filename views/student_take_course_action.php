<?php
session_start();
require_once(__DIR__ . '/../DBconnect.php');

$userid = $_SESSION['userid'];
$course = $_POST['coursecode'];
$section = $_POST['section'];

$student = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT StudentID FROM Student WHERE UserID='$userid'")
);

mysqli_query($conn,"
INSERT INTO CoursesTaken (StudentID, CourseCode, SectionNo)
VALUES ('{$student['StudentID']}', '$course', '$section')
");

header("Location: student_dashboard.php");
exit;
?>
