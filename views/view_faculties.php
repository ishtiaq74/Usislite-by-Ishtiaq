<?php
session_start();
require_once(__DIR__ . '/../DBconnect.php');

if (!isset($_SESSION['userid']) || $_SESSION['userid'] !== 'reg') {
    header("Location: ../index.php");
    exit;
}

$search = "";
if (isset($_GET['initials'])) {
    $search = $_GET['initials'];
}
?>

<!DOCTYPE html>
<html>
<head>
<title>View Faculties</title>
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
<h2>Faculties</h2>

<form method="get" class="search">
    <label>Search by Initials:</label>
    <input type="text" name="initials" value="<?= $search ?>">
    <button type="submit">Search</button>
</form>

<table>
<tr>
    <th>UserID</th>
    <th>Initials</th>
    <th>Name</th>
    <th>Department</th>
    <th>Email</th>
    <th>Phone</th>
</tr>

<?php
$sql = "
SELECT f.UserID, f.Initials, f.Department, u.Name, u.Email, u.PhoneNo
FROM Faculty f
JOIN User u ON u.UserID = f.UserID
";

if ($search != "") {
    $sql .= " WHERE f.Initials='$search'";
}

$q = mysqli_query($conn, $sql);

if (mysqli_num_rows($q) == 0) {
    echo "<tr><td colspan='6'>No faculty found</td></tr>";
}

while ($row = mysqli_fetch_assoc($q)) {
    echo "<tr>
        <td><a href='register_view_faculty.php?userid={$row['UserID']}'>{$row['UserID']}</a></td>
        <td>{$row['Initials']}</td>
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
