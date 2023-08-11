<?php
include('config.php');
// login.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_username = $conn->real_escape_string($_POST['user_username']);
    $user_password = $conn->real_escape_string($_POST['user_password']);

    $sql = "SELECT * FROM user WHERE user_username = '$user_username' AND user_status = 1";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $stored_password = $row['user_password'];

        if (password_verify($user_password, $stored_password)) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_username'] = $row['user_username'];
            $_SESSION['user_fullname'] = $row['user_fullname'];
            $_SESSION['user_email'] = $row['user_email'];
            $_SESSION['user_address'] = $row['user_address'];
            $_SESSION['user_tel'] = $row['user_tel'];
            $_SESSION['user_pet'] = $row['user_pet'];
            // Clear POST variables to prevent misuse
            unset($_POST['user_username']);
            unset($_POST['user_password']);

            header("Location: index.php");
            exit();
        } else {
            $error_message = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง";
        }
    } else {
        $seller_username = $conn->real_escape_string($_POST['user_username']);
        $seller_password = $conn->real_escape_string($_POST['user_password']);
        $sql = "SELECT * FROM seller WHERE seller_username = '$seller_username' AND seller_status = 1";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $stored_password = $row['seller_password'];

            if (password_verify($seller_password, $stored_password)) {
                $_SESSION['seller_id'] = $row['seller_id'];
                $_SESSION['seller_shop'] = $row['seller_shop'];
                $_SESSION['seller_detail'] = $row['seller_detail'];
                $_SESSION['seller_username'] = $row['seller_username'];
                $_SESSION['seller_fullname'] = $row['seller_fullname'];
                $_SESSION['seller_email'] = $row['seller_email'];
                $_SESSION['seller_bank_name	'] = $row['seller_bank_name'];
                $_SESSION['seller_address'] = $row['seller_address'];
                $_SESSION['seller_tel'] = $row['seller_tel'];
                $_SESSION['seller_account_number'] = $row['seller_account_number'];

                header("Location: admin/index.php");
            } else {
                echo "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง";
                header("Location: login.php");
            }
        } else {
            echo "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง";
            header("Location: login.php");
        }
    }
}
