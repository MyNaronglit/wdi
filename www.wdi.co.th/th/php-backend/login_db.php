<?php
session_start();
require_once('server.php');

// สร้างอ็อบเจ็กต์สำหรับการเชื่อมต่อฐานข้อมูล
$db = new server();
$ierp = $db->connect_sql(); // เชื่อมต่อฐานข้อมูล

$errors = array();

if (isset($_POST['submit'])) {
    // เปลี่ยนจาก `$conn` เป็น `$ierp`
    $email = mysqli_real_escape_string($ierp, $_POST['email']);
    $password = $_POST['password']; // ไม่ต้อง Escape password

    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
        // ใช้ prepared statement เพื่อป้องกัน SQL Injection
        $query = "SELECT * FROM user WHERE email = ?";
        $stmt = mysqli_prepare($ierp, $query);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) == 1) {
                $user = mysqli_fetch_assoc($result);
                
                // เช็คว่ารหัสผ่านถูกต้องหรือไม่
                if (password_verify($password, $user['password'])) {
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role']; // เก็บสิทธิ์ของผู้ใช้ใน session
                    $_SESSION['success'] = "You are now logged in";

                    // ตรวจสอบสิทธิ์แล้วเปลี่ยนเส้นทางไปยังหน้าที่กำหนด
                    if ($user['role'] == 'admin' || $user['role'] == 'employee') {
                        header('location: /wdi/www.wdi.co.th/th/adminkit-dev/static/index.php');

                    } else {
                        header('location: index.php');
                    }
                    exit;
                } else {
                    header('location: login.php?error=wrong_password');
                    exit;
                }
            } else {
                header('location: login.php?error=user_not_found');
                exit;
            }

            mysqli_stmt_close($stmt);
        } else {
            header('location: login.php?error=stmt_failed');
            exit;
        }
    } else {
        header('location: login.php?error=validation_error');
        exit;
    }
}
?>
