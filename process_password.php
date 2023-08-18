
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
    $user_id = $_SESSION['user_id'];
    $user_password = $conn->real_escape_string($_POST['user_password']);
    $user_password_confirm = $conn->real_escape_string($_POST['user_password_confirm']);

    if ($user_password != "" && $user_password_confirm != "" && $user_password == $user_password_confirm) {
        $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
        $sql = "UPDATE user SET user_password = '$hashed_password' WHERE user_id = $user_id";

        if ($conn->query($sql)) {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'เปลี่ยนรหัสผ่านสำเร็จ',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = 'password.php';
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'ไม่สามารถเปลี่ยนรหัสผ่านได้',
                    text: 'กรุณาลองใหม่อีกครั้ง'
                }).then(() => {
                    window.history.back();
                });
            </script>";
        }
    } else {
        echo "<script>
            Swal.fire({
                icon: 'warning',
                title: 'รหัสผ่านไม่ตรงกัน',
                text: 'กรุณากรอกรหัสผ่านให้ตรงกันทั้งสองครั้ง'
            }).then(() => {
                window.history.back();
            });
        </script>";
    }
    exit();
}
?>
</body>
</html>