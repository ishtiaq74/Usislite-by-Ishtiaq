<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once("DBconnect.php");

if (isset($_POST['username']) && isset($_POST['password'])) {

    $u = $_POST['username'];
    $p = $_POST['password'];

    // Check credentials
    $sql = "SELECT * FROM User WHERE UserID='$u' AND Password='$p'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) == 1) {

        // Save session
        $_SESSION['userid'] = $u;

        // ---------- ROLE CHECK ----------

        // Register user
        if ($u === 'reg') {
            header("Location: views/register_dashboard.php");
            exit;
        }

        // Student
        $student = mysqli_query($conn,
            "SELECT * FROM Student WHERE UserID='$u'"
        );

        if (mysqli_num_rows($student) == 1) {
            header("Location: views/student_dashboard.php");
            exit;
        }

        // Faculty
        $faculty = mysqli_query($conn,
            "SELECT * FROM Faculty WHERE UserID='$u'"
        );

        if (mysqli_num_rows($faculty) == 1) {
            header("Location: views/faculty_dashboard.php");
            exit;
        }

        // No role assigned
        echo "Login successful, but role not assigned.";

    } else {
        echo "Incorrect username or password.";
    }
}
?>
