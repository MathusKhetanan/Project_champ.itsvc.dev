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
include('../config.php'); // รวมไฟล์ config.php เพื่อเชื่อมต่อฐานข้อมูล

if (isset($_POST['credential'])) {
    $client = new Google\Client(['client_id' => "294100220871-ug9414mifqh6oo3pq61u64soddgl9l4m.apps.googleusercontent.com"]);
    $payload = $client->verifyIdToken($_POST['credential']);
    if ($payload) {
        if ($payload['email_verified'] == false) {
            // Email has not been verified by Google
            header("Location: ../login.php"); // ไปยังหน้า login.php
            exit;
        }

        $email = $payload['email'];

        // ตรวจสอบว่าอีเมลนี้มีในฐานข้อมูลหรือไม่
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
            // พบผู้ใช้ในฐานข้อมูล ให้ทำการล็อกอิน
            // ทำการล็อกอินผู้ใช้ตามต้องการ
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
            // ไม่พบอีเมลนี้ในฐานข้อมูล
            // หรือสร้างบัญชีผู้ใช้ใหม่ด้วยข้อมูลจาก Google
            $fullname = $payload['name']; // คุณอาจต้องแก้ไขตามความเหมาะสม
            createUser($email, $fullname); // สร้างผู้ใช้ใหม่
            header("Location: index.php"); // ไปยังหน้า index.php
            exit;
        }

        $stmt->close();
    } else {
        // เกิดข้อผิดพลาดจาก Google API
        header("Location: login.php"); // ไปยังหน้า login.php
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
        // สร้างผู้ใช้สำเร็จ
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
        // สร้างผู้ใช้ไม่สำเร็จ
        echo '<script>
        Swal.fire({
            icon: "error",
            title: "Login Failed!",
            text: "เข้าสู้ระบบไม่สําเร็จโปรดสมัครบัญชีของคุณ",
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
