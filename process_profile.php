<?php 
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $user_fullname = $conn->real_escape_string($_POST['user_fullname']);
    $user_password = $conn->real_escape_string($_POST['user_password']);
    $user_password_confirm = $conn->real_escape_string($_POST['user_password_confirm']);
    $user_address = $conn->real_escape_string($_POST['user_address']);
    $user_tel = $conn->real_escape_string($_POST['user_tel']);
    $user_pet = $conn->real_escape_string(implode(',', $_POST['user_pet']));

    if (!empty($user_fullname) && !empty($user_address) && !empty($user_tel) && !empty($user_pet)) {
        if ($user_password != "" && $user_password_confirm != "" && $user_password == $user_password_confirm) {
            $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
            $sql = "UPDATE user SET user_fullname = '$user_fullname', user_address = '$user_address', user_tel = '$user_tel', user_password = '$hashed_password', user_pet = '$user_pet' WHERE user_id = $user_id";
        } else {
            $sql = "UPDATE user SET user_fullname = '$user_fullname', user_address = '$user_address', user_tel = '$user_tel', user_pet = '$user_pet' WHERE user_id = $user_id";
        }

        if ($conn->query($sql)) {
            $_SESSION['user_fullname'] = $user_fullname;
            $_SESSION['user_address'] = $user_address;
            $_SESSION['user_tel'] = $user_tel;
            $_SESSION['user_pet'] = $user_pet;

            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'บันทึกข้อมูลสำเร็จ',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = 'profile.php';
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'บันทึกข้อมูลไม่สำเร็จ',
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
                title: 'กรุณากรอกข้อมูลที่จำเป็น',
                text: 'กรุณากรอกข้อมูลที่จำเป็นให้ครบถ้วน'
            }).then(() => {
                window.history.back();
            });
        </script>";
    }
    exit();
}
?>
