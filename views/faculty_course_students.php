<?php
session_start();
require_once(__DIR__ . '/../DBconnect.php');

if (!isset($_SESSION['userid'])) {
    header('Location: ../index.php');
    exit;
}

// Read and sanitize inputs
$course_raw  = isset($_GET['course']) ? $_GET['course'] : '';
$section_raw = isset($_GET['section']) ? $_GET['section'] : '';

if ($course_raw === '' || $section_raw === '') {
    // missing required parameters
    header('Location: faculty_dashboard.php');
    exit;
}

$course  = mysqli_real_escape_string($conn, $course_raw);
$section = mysqli_real_escape_string($conn, $section_raw);

// search value (optional)
$search = "";
if (isset($_GET['studentid'])) {
    $search = $_GET['studentid'];
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Course Students</title>
<style>
body{background:#243447;color:#EFE7DA;font-family:Segoe UI;}
.box{width:850px;margin:40px auto;background:#5F7A92;padding:20px;border-radius:10px;}
table{width:100%;background:#AFC6D1;color:#243447;border-collapse:collapse;}
th,td{padding:8px;border:1px solid #243447;}
button{background:#8B0000;color:#EFE7DA;padding:6px 12px;border:none;cursor:pointer;}
input[type=text]{padding:6px;width:200px;}
a{color:#EFE7DA;text-decoration:none;}
.search{margin-bottom:15px;}
</style>
</head>

<body>
<div class="box">

<h2>Students – <?= $course ?> (Section <?= $section ?>)</h2>

<!-- SEARCH FORM -->
<form method="get" class="search">
    <input type="hidden" name="course" value="<?= $course ?>">
    <input type="hidden" name="section" value="<?= $section ?>">
    <label>Search Student ID:</label>
    <input type="text" name="studentid" value="<?= $search ?>">
    <button type="submit">Search</button>
</form>

<table>
<tr>
    <th>Student ID</th>
    <th>Name</th>
    <th>Action</th>
</tr>

<?php
$sql = "
SELECT s.StudentID, u.Name
FROM CoursesTaken ct
JOIN Student s ON ct.StudentID=s.StudentID
JOIN User u ON s.UserID=u.UserID
WHERE ct.CourseCode='$course'
AND ct.SectionNo='$section'
";

if ($search != "") {
    $sql .= " AND s.StudentID='$search'";
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
            <form method='post' action='../actions/faculty_drop_course_action.php'>
                <input type='hidden' name='studentid' value='{$r['StudentID']}'>
                <input type='hidden' name='course' value='$course'>
                <input type='hidden' name='section' value='$section'>
                <button type='submit'>Drop</button>
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
