<?php
session_start();
require_once(__DIR__ . '/../DBconnect.php');

// Get course and section from URL
// We use htmlspecialchars to prevent issues with the dash (-) in names like CS-101
$course  = isset($_GET['course']) ? $_GET['course'] : '';
$section = isset($_GET['section']) ? $_GET['section'] : '';

// search value (if any)
$search = "";
if (isset($_GET['studentid'])) {
    $search = $_GET['studentid'];
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Student</title>
<style>
body{background:#243447;color:#EFE7DA;font-family:Segoe UI;}
.box{width:650px;margin:40px auto;background:#5F7A92;padding:20px;border-radius:10px;}
table{width:100%;background:#AFC6D1;color:#243447;border-collapse:collapse;}
th,td{padding:8px;border:1px solid #243447;}
button{background:#243447;color:#EFE7DA;padding:6px 12px;border:none;cursor:pointer;}
input[type=text]{padding:6px;width:200px;}
a{color:#EFE7DA;text-decoration:none;}
.search{margin-bottom:15px;}
</style>
</head>

<body>
<div class="box">

<h2>Add Student to <?= htmlspecialchars($course) ?> (Section <?= htmlspecialchars($section) ?>)</h2>

<form method="get" class="search" action="faculty_add_course.php">
    <input type="hidden" name="course" value="<?= htmlspecialchars($course) ?>">
    <input type="hidden" name="section" value="<?= htmlspecialchars($section) ?>">
    <label>Search Student ID:</label>
    <input type="text" name="studentid" value="<?= htmlspecialchars($search) ?>">
    <button type="submit">Search</button>
</form>

<table>
<tr>
    <th>Student ID</th>
    <th>Name</th>
    <th>Action</th>
</tr>

<?php
$sql = "SELECT s.StudentID, u.Name FROM Student s JOIN User u ON s.UserID=u.UserID";

if ($search != "") {
    $sql .= " WHERE s.StudentID='$search'";
}

$q = mysqli_query($conn, $sql);

if (mysqli_num_rows($q) == 0) {
    echo "<tr><td colspan='3'>No student found</td></tr>";
}

while($r = mysqli_fetch_assoc($q)){
    echo "<tr>
        <td>{$r['StudentID']}</td>
        <td>{$r['Name']}</td>
        <td>
            <form method='post' action='../actions/faculty_add_course_action.php'>
                <input type='hidden' name='studentid' value='{$r['StudentID']}'>
                <input type='hidden' name='course' value='".htmlspecialchars($course)."'>
                <input type='hidden' name='section' value='".htmlspecialchars($section)."'>
                <button type='submit'>Add</button>
            </form>
        </td>
    </tr>";
}
?>
</table>

<br>
<a href="faculty_dashboard.php">⬅ Back to Dashboard</a>

</div>
</body>
</html>