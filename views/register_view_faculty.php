<?php
session_start();
require_once(__DIR__ . '/../DBconnect.php');

$userid=$_GET['userid'];

$faculty=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT f.Initials, u.Name
FROM Faculty f JOIN User u ON f.UserID=u.UserID
WHERE f.UserID='$userid'
"));
?>

<!DOCTYPE html>
<html>
<head>
<title>Faculty Courses</title>
<style>
body{background:#243447;color:#EFE7DA;font-family:Segoe UI;}
.box{width:700px;margin:40px auto;background:#5F7A92;padding:20px;border-radius:10px;}
table{width:100%;background:#AFC6D1;color:#243447;border-collapse:collapse;}
th,td{padding:8px;border:1px solid #243447;}
</style>
</head>

<body>
<div class="box">
<h2><?= $faculty['Name'] ?> (<?= $faculty['Initials'] ?>)</h2>

<table>
<tr><th>Course</th><th>Section</th></tr>

<?php
$q=mysqli_query($conn,"
SELECT CourseCode, SectionNo
FROM AssignedCourse
WHERE Initials='{$faculty['Initials']}'
");

while($r=mysqli_fetch_assoc($q)){
echo "<tr>
<td>{$r['CourseCode']}</td>
<td>{$r['SectionNo']}</td>
</tr>";
}
?>
</table>

<br>
<a href="register_dashboard.php">⬅ Back</a>
</div>
</body>
</html>
