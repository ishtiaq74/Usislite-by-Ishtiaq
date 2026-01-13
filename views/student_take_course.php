<?php
session_start();
require_once(__DIR__ . '/../DBconnect.php');

$userid = $_SESSION['userid'];
$student = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT StudentID FROM Student WHERE UserID='$userid'"));
?>

<!DOCTYPE html>
<html>
<head>
<title>Take Course</title>
<style>
body{background:#243447;color:#EFE7DA;font-family:Segoe UI;}
.box{width:850px;margin:40px auto;background:#5F7A92;padding:20px;border-radius:10px;}
table{width:100%;background:#AFC6D1;color:#243447;border-collapse:collapse;}
th,td{padding:8px;border:1px solid #243447;}
button{background:#243447;color:#EFE7DA;padding:6px 10px;border:none;cursor:pointer;}
a{color:#EFE7DA;}
</style>
</head>

<body>
<div class="box">
<h2>Available Courses</h2>

<table>
<tr>
    <th>Course Code</th>
    <th>Course Name</th>
    <th>Section</th>
    <th>Time</th>
    <th>Days</th>
    <th>Action</th>
</tr>

<?php
$q = mysqli_query($conn,"
SELECT a.CourseCode, a.SectionNo, c.CourseName, c.Time, c.Weekdays
FROM AssignedCourse a
JOIN Course c ON a.CourseCode=c.CourseCode
");

while($r=mysqli_fetch_assoc($q)){
    echo "<tr>
        <td>{$r['CourseCode']}</td>
        <td>{$r['CourseName']}</td>
        <td>{$r['SectionNo']}</td>
        <td>{$r['Time']}</td>
        <td>{$r['Weekdays']}</td>
        <td>
            <form method='post' action='student_take_course_action.php'>
                <input type='hidden' name='coursecode' value='{$r['CourseCode']}'>
                <input type='hidden' name='section' value='{$r['SectionNo']}'>
                <button type='submit'>Take</button>
            </form>
        </td>
    </tr>";
}
?>
</table>

<br>
<a href="student_dashboard.php">⬅ Back to Dashboard</a>
</div>
</body>
</html>
