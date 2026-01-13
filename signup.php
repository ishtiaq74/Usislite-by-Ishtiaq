<?php
session_start();
require_once("DBconnect.php");

if (
    isset($_POST['username'], $_POST['password'], $_POST['name'],
          $_POST['email'], $_POST['phoneno'], $_POST['role'])
) {
    $u = $_POST['username'];
    $p = $_POST['password'];
    $n = $_POST['name'];
    $e = $_POST['email'];
    $ph = $_POST['phoneno'];
    $role = $_POST['role'];

    // Insert into User table
    mysqli_query($conn,"
        INSERT INTO User (UserID, Name, Email, Password, PhoneNo)
        VALUES ('$u','$n','$e','$p','$ph')
    ");

    // Assign role
    if ($role == "student") {
        $sid = "S" . rand(100,999);
        mysqli_query($conn,"
            INSERT INTO Student (UserID, StudentID, Department)
            VALUES ('$u','$sid','Computer Science')
        ");
        $_SESSION['userid'] = $u;
        header("Location: views/student_dashboard.php");
        exit;
    }

    if ($role == "faculty") {
        $init = strtoupper(substr($n,0,2));
        mysqli_query($conn,"
            INSERT INTO Faculty (UserID, Initials, Department)
            VALUES ('$u','$init','Computer Science')
        ");
        $_SESSION['userid'] = $u;
        header("Location: views/faculty_dashboard.php");
        exit;
    }
}
?>
