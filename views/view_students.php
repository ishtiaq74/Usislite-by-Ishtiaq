<?php
session_start();
require_once(__DIR__ . '/../DBconnect.php');

if (!isset($_SESSION['userid']) || $_SESSION['userid'] !== 'reg') {
    header("Location: ../index.php");
    exit;
}

$search = "";
if (isset($_GET['studentid'])) {
    $search = $_GET['studentid'];
}
?>

<!DOCTYPE html>
<html>
<head>
<title>View Students</title>
<style>
body{background:#243447;color:#EFE7DA;font-family:Segoe UI;}
.box{width:950px;margin:40px auto;background:#5F7A92;padding:20px;border-radius:10px;}
table{width:100%;border-collapse:collapse;background:#AFC6D1;color:#243447;}
th,td{border:1px solid #243447;padding:8px;text-align:center;}
th{background:#243447;color:#EFE7DA;}
a{color:#243447;font-weight:bold;text-decoration:none;}
.search{margin-bottom:15px;}
input{padding:6px;}
button{padding:6px 12px;background:#243447;color:#EFE7DA;border:none;}
</style>
</head>

<body>
<div class="box">
<h2>Students</h2>

<form method="get" class="search">
    <label>Search by Student ID:</label>
    <input type="text" name="studentid" value="<?= $search ?>">
    <button type="submit">Search</button>
</form>

<table>
<tr>
    <th>UserID</th>
    <th>Student ID</th>
    <th>Name</th>
    <th>Department</th>
    <th>Email</th>
    <th>Phone</th>
</tr>

<?php
$sql = "
SELECT s.UserID, s.StudentID, s.Department, u.Name, u.Email, u.PhoneNo
FROM Student s
JOIN User u ON u.UserID = s.UserID
";

if ($search != "") {
    $sql .= " WHERE s.StudentID='$search'";
}

$q = mysqli_query($conn, $sql);

if (mysqli_num_rows($q) == 0) {
    echo "<tr><td colspan='6'>No student found</td></tr>";
}

while ($row = mysqli_fetch_assoc($q)) {
    echo "<tr>
        <td><a href='register_view_student.php?userid={$row['UserID']}'>{$row['UserID']}</a></td>
        <td>{$row['StudentID']}</td>
        <td>{$row['Name']}</td>
        <td>{$row['Department']}</td>
        <td>{$row['Email']}</td>
        <td>{$row['PhoneNo']}</td>
    </tr>";
}
?>
</table>

<br>
<a href="register_dashboard.php">⬅ Back to Register Dashboard</a>
</div>
</body>
</html>
