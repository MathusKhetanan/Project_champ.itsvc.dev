<!DOCTYPE html>
<html lang="en">
<head>
    <!-- เรียกใช้ไฟล์ SweetAlert ผ่าน CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
</head>
<body>
<?php
require '../../vendor/autoload.php';
include('../config.php');
session_start(); // เรียกใช้ session_start() สำหรับการใช้งาน $_SESSION

if (isset($_POST['credential'])) {
    $client = new Google\Client(['client_id' => "294100220871-ug9414mifqh6oo3pq61u64soddgl9l4m.apps.googleusercontent.com"]);
    $payload = $client->verifyIdToken($_POST['credential']);
    if ($payload) {
        if ($payload['email_verified'] == false) {
            // Email has not been verified by Google
            header("Location: ../login.php");
            exit;
        }

        $email = $payload['email'];

        // Check if this email exists in the database
        $sql = "SELECT * FROM user WHERE user_email = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            // User exists in the database
            $_SESSION['user_id'] = $user['user_id']; // Set user_id in the session
            echo '<script>
            Swal.fire({
                icon: "success",
                title: "Login Successful!",
                text: "เข้าสู่ระบบผู้ใช้สำเร็จ",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../index.php";
                }
            });
            </script>';
            exit;
        } else {
            // User doesn't exist in the database, create a new user
            $fullname = $payload['name'];
            createUser($email, $fullname);
            header("Location: index.php");
            exit;
        }

        $stmt->close();
    } else {
        // Error from Google API
        header("Location: login.php");
        exit;
    }
}

function createUser($email, $fullname) {
    global $conn;

    $sql = "INSERT INTO user (user_username, user_fullname, user_email, user_status, createdAt, updatedAt)
            VALUES (?, ?, ?, 1, NOW(), NOW())";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $username = $email;
    $password = password_hash("temporary_password", PASSWORD_DEFAULT);
    $address = $email;
    $tel = null;
    $pet = null;
    $fullname = $fullname;
    $email = $email;
    $username = $username;

    $stmt->bind_param("sss", $username, $fullname, $email);

    if ($stmt->execute()) {
        // User created successfully
        $_SESSION['user_id'] = $stmt->insert_id; // Set user_id in the session
        echo '<script>
        Swal.fire({
            icon: "success",
            title: "Login Successful!",
            text: "เข้าสู่ระบบผู้ใช้สำเร็จ.",
            confirmButtonColor: "#3085d6",
            confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../index.php";
            }
        });
        </script>';
        header("Location: ../index.php");
        exit;
    } else {
        // User creation failed
        echo '<script>
        Swal.fire({
            icon: "error",
            title: "Login Failed!",
            text: "เข้าสู้ระบบไม่สำเร็จโปรดสมัครบัญชีของคุณ",
            confirmButtonColor: "#d33",
            confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../login.php";
            }
        });
        </script>';
        header("Location: ../login.php");
        exit;
    }

    $stmt->close();
}
?>
</body>
</html>
