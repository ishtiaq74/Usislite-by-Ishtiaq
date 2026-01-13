<?php
session_start();
require_once(__DIR__ . '/../DBconnect.php');

$userid = $_SESSION['userid'];

$student = mysqli_fetch_assoc(
    mysqli_query($conn,"
      SELECT s.StudentID, s.UserID, u.Name
      FROM Student s
      JOIN User u ON s.UserID=u.UserID
      WHERE s.UserID='$userid'")
);
?>

<!DOCTYPE html>
<html>
<head>
<title>Student Dashboard</title>
<style>
body{background:#243447;color:#EFE7DA;font-family:Segoe UI;}
.box{width:750px;margin:40px auto;background:#5F7A92;padding:20px;border-radius:10px;}
table{width:100%;background:#AFC6D1;color:#243447;border-collapse:collapse;}
th,td{padding:8px;border:1px solid #243447;}
a{color:#EFE7DA;text-decoration:none;}
button{background:#243447;color:#EFE7DA;padding:8px 12px;border:none;cursor:pointer;}
.actions{margin-top:15px;}
</style>
</head>

<body>
<div class="box">
<h2>Student Dashboard</h2>

<p><b>Name:</b> <?= $student['Name'] ?></p>
<p><b>User ID:</b> <?= $student['UserID'] ?></p>
<p><b>Student ID:</b> <?= $student['StudentID'] ?></p>

<h3>Courses Taken</h3>

<table>
<tr>
    <th>Course Code</th>
    <th>Course Name</th>
    <th>Section</th>
    <th>Time</th>
    <th>Days</th>
</tr>

<?php
$q = mysqli_query($conn,"
SELECT c.CourseCode, c.CourseName, c.Time, c.Weekdays, ct.SectionNo
FROM CoursesTaken ct
JOIN Course c ON ct.CourseCode=c.CourseCode
WHERE ct.StudentID='{$student['StudentID']}'
");

while($r=mysqli_fetch_assoc($q)){
    echo "<tr>
            <td>{$r['CourseCode']}</td>
            <td>{$r['CourseName']}</td>
            <td>{$r['SectionNo']}</td>
            <td>{$r['Time']}</td>
            <td>{$r['Weekdays']}</td>
          </tr>";
}
?>
</table>

<div class="actions">
    <a href="student_take_course.php">➕ Take Course</a> |
    <a href="student_drop_course.php">❌ Drop Course</a>
</div>

</div>
</body>
</html>
