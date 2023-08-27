<!DOCTYPE html>
<html lang="en">
<head>
    <!-- เรียกใช้ไฟล์ SweetAlert ผ่าน CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
</head>
<body>
<?php
include('config.php');  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['user_username']);
    $password = $conn->real_escape_string($_POST['user_password']);

    // Check for user login
    $user_sql = "SELECT * FROM user WHERE user_username = '$username' AND user_status = 1";
    $result = $conn->query($user_sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $stored_password = $row['user_password'];

        if (password_verify($password, $stored_password)) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_username'] = $row['user_username'];
            $_SESSION['user_fullname'] = $row['user_fullname'];
            $_SESSION['user_email'] = $row['user_email'];
            $_SESSION['user_address'] = $row['user_address'];
            $_SESSION['user_tel'] = $row['user_tel'];
            

            // Redirect to the appropriate dashboard with a success message
            $dashboard_url = "index.php"; // Change to your user dashboard URL
            $success_message = "เข้าสู่ระบบผู้ใช้สำเร็จ";
            redirectToDashboardWithMessage($dashboard_url, $success_message);
        }
    }

    // Check for admin login
    $admin_sql = "SELECT * FROM admin WHERE admin_username = '$username' AND admin_status = 1";
    $result = $conn->query($admin_sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $stored_password = $row['admin_password'];

        if (password_verify($password, $stored_password)) {
            $_SESSION['admin_id'] = $row['admin_id'];
            $_SESSION['admin_username'] = $row['admin_username'];
            $_SESSION['admin_fullname'] = $row['admin_fullname'];
            $_SESSION['admin_email'] = $row['admin_email'];
            $_SESSION['admin_bank_name'] = $row['admin_bank_name'];
            $_SESSION['admin_address'] = $row['admin_address'];
            $_SESSION['admin_tel'] = $row['admin_tel'];
            $_SESSION['admin_account_number'] = $row['admin_account_number'];

            // Redirect to the appropriate dashboard with a success message
            $dashboard_url = "admin/index.php"; // Change to your admin dashboard URL
            $success_message = "เข้าสู่ระบบแอดมินสำเร็จ";
            redirectToDashboardWithMessage($dashboard_url, $success_message);
        }
    }

    // If neither user nor admin login succeeds, display an error message
    $error_message = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้องหรือบัญชีถูกปิดใช้งาน";
    displayErrorMessage($error_message);
}

// Function to redirect to a dashboard with a success message
function redirectToDashboardWithMessage($dashboard_url, $success_message) {
    echo '<script>
        Swal.fire({
            title: "สำเร็จ!",
            text: "' . $success_message . '",
            icon: "success",
            confirmButtonText: "ตกลง"
        }).then(() => {
            window.location.href = "' . $dashboard_url . '";
        });
    </script>';
    exit();
}

// Function to display an error message and redirect back to the login page
function displayErrorMessage($error_message) {
    echo '<script>
        Swal.fire({
            title: "ผิดพลาด",
            text: "' . $error_message . '",
            icon: "error",
            confirmButtonText: "ตกลง"
        }).then(() => {
            window.location.href = "login.php";
        });
    </script>';
    exit();
}
?>


</body>
</html>