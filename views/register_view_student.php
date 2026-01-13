<?php
session_start();
require_once(__DIR__ . '/../DBconnect.php');

$userid = $_GET['userid'];

$student = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT s.StudentID, u.Name
FROM Student s JOIN User u ON s.UserID=u.UserID
WHERE s.UserID='$userid'
"));
?>

<!DOCTYPE html>
<html>
<head>
<title>Student Courses</title>
<style>
body{background:#243447;color:#EFE7DA;font-family:Segoe UI;}
.box{width:800px;margin:40px auto;background:#5F7A92;padding:20px;border-radius:10px;}
table{width:100%;background:#AFC6D1;color:#243447;border-collapse:collapse;}
th,td{padding:8px;border:1px solid #243447;}
</style>
</head>

<body>
<div class="box">
<h2><?= $student['Name'] ?> (<?= $student['StudentID'] ?>)</h2>

<table>
<tr>
<th>Course</th><th>Section</th><th>Action</th>
</tr>

<?php
$q=mysqli_query($conn,"
SELECT CourseCode, SectionNo
FROM CoursesTaken
WHERE StudentID='{$student['StudentID']}'
");

while($r=mysqli_fetch_assoc($q)){
echo "<tr>
<td>{$r['CourseCode']}</td>
<td>{$r['SectionNo']}</td>
<td>
<form method='post' action='../actions/register_drop_course.php'>
<input type='hidden' name='studentid' value='{$student['StudentID']}'>
<input type='hidden' name='course' value='{$r['CourseCode']}'>
<input type='hidden' name='userid' value='{$userid}'>
<button>Drop</button>
</form>
</td>
</tr>";
}
?>
</table>

<br>
<a href="register_dashboard.php">⬅ Back</a>
</div>
</body>
</html>
