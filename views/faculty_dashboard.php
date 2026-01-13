<?php
session_start();
require_once(__DIR__ . '/../DBconnect.php');

if (!isset($_SESSION['userid'])) {
    header('Location: ../index.php');
    exit;
}

$userid = $_SESSION['userid'];
$userid_esc = mysqli_real_escape_string($conn, $userid);
$faculty_q = mysqli_query($conn, "SELECT f.Initials, f.Department, u.Name FROM Faculty f JOIN User u ON f.UserID = u.UserID WHERE f.UserID='" . $userid_esc . "'");
if ($faculty_q && mysqli_num_rows($faculty_q) > 0) {
    $faculty = mysqli_fetch_assoc($faculty_q);
} else {
    $faculty = ['Name'=>'','Initials'=>'','Department'=>''];
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Faculty Dashboard</title>
<style>
body{background:#243447;color:#EFE7DA;font-family:Segoe UI;}
.box{width:750px;margin:40px auto;background:#5F7A92;padding:20px;border-radius:10px;}
table{width:100%;background:#AFC6D1;color:#243447;border-collapse:collapse;}
th,td{padding:8px;border:1px solid #243447;}
a{color:#EFE7DA;text-decoration:none;}
button{background:#243447;color:#EFE7DA;padding:6px 10px;border:none;cursor:pointer;}
</style>
</head>

<body>
<div class="box">
<h2>Faculty Dashboard</h2>

<p><b>Name:</b> <?= $faculty['Name'] ?></p>
<p><b>Initials:</b> <?= $faculty['Initials'] ?></p>
<p><b>Department:</b> <?= $faculty['Department'] ?></p>

<h3>Assigned Courses</h3>

<table>
<tr>
    <th>Course Code</th>
    <th>Section</th>
    <th>Action</th>
</tr>

<?php
$q = mysqli_query($conn,"
SELECT CourseCode, SectionNo
FROM AssignedCourse
WHERE Initials='{$faculty['Initials']}'
");

while($r=mysqli_fetch_assoc($q)){
    $course_param = urlencode($r['CourseCode']);
    $section_param = urlencode($r['SectionNo']);
    $course_html = htmlspecialchars($r['CourseCode']);
    $section_html = htmlspecialchars($r['SectionNo']);

    echo "<tr>\n" .
         "    <td>$course_html</td>\n" .
         "    <td>$section_html</td>\n" .
         "    <td>\n" .
         "        <a href='faculty_course_students.php?course={$course_param}&section={$section_param}'>View Students</a> | " .
         "<a href='faculty_add_course.php?course={$course_param}&section={$section_param}'>Add Student</a>\n" .
         "    </td>\n" .
         "</tr>\n";
}
?>
</table>

</div>
</body>
</html>
