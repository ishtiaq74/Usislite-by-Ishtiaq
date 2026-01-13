<?php
session_start();
require_once(__DIR__ . '/../DBconnect.php');

if ($_SESSION['userid'] !== 'reg') {
    header("Location: ../index.php");
    exit;
}

$search = "";
if (isset($_GET['userid'])) {
    $search = $_GET['userid'];
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register Dashboard</title>
<style>
body{background:#243447;color:#EFE7DA;font-family:Segoe UI;}
.box{width:950px;margin:40px auto;background:#5F7A92;padding:20px;border-radius:10px;}
table{width:100%;background:#AFC6D1;color:#243447;border-collapse:collapse;}
th,td{padding:8px;border:1px solid #243447;text-align:center;}
a{color:#243447;font-weight:bold;text-decoration:none;}
.search{margin-bottom:15px;}
input{padding:6px;}
button{padding:6px 10px;background:#243447;color:#EFE7DA;border:none;}
</style>
</head>

<body>
<div class="box">
<h2>Register Dashboard</h2>
<div class="actions" style="margin-bottom:20px;text-align:center;">
    <a href="view_students.php">
        <button style="padding:10px 15px;margin-right:10px;">View Students</button>
    </a>
    <a href="view_faculties.php">
        <button style="padding:10px 15px;">View Faculties</button>
    </a>
</div>

<form method="get" class="search">
    <label>Search UserID:</label>
    <input type="text" name="userid" value="<?= $search ?>">
    <button>Search</button>
</form>

<table>
<tr>
    <th>UserID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Role</th>
    <th>Action</th>
</tr>

<?php
$sql = "
SELECT u.UserID, u.Name, u.Email, u.PhoneNo,
IF(s.UserID IS NOT NULL,'Student',
IF(f.UserID IS NOT NULL,'Faculty','Unknown')) AS Role
FROM User u
LEFT JOIN Student s ON u.UserID=s.UserID
LEFT JOIN Faculty f ON u.UserID=f.UserID
WHERE u.UserID!='reg'
";

if ($search != "") {
    $sql .= " AND u.UserID='$search'";
}

$q = mysqli_query($conn, $sql);

while($r=mysqli_fetch_assoc($q)){
    $link = ($r['Role']=="Student")
        ? "register_view_student.php?userid={$r['UserID']}"
        : "register_view_faculty.php?userid={$r['UserID']}";

    echo "<tr>
        <td>{$r['UserID']}</td>
        <td>{$r['Name']}</td>
        <td>{$r['Email']}</td>
        <td>{$r['PhoneNo']}</td>
        <td>{$r['Role']}</td>
        <td><a href='$link'>View</a></td>
    </tr>";
}
?>
</table>
</div>
</body>
</html>
