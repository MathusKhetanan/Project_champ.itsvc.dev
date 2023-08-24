<!DOCTYPE html>
<html lang="en">

<head>
    <!-- เรียกใช้ไฟล์ SweetAlert ผ่าน CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
</head>

<body>
    <?php
    include('../config.php');
    include('includes/authentication.php');
    include('includes/header.php');

    // Function to hash the password using SHA-512
    function hashPassword($password)
    {
        return hash('sha512', $password);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get and sanitize the data from the form
        $admin_shop = $_POST['admin_shop'];
        $admin_detail = $_POST['admin_detail'];
        $admin_address = $_POST['admin_address'];
        $admin_username = $_POST['admin_username'];
        $admin_email = $_POST['admin_email'];
        $admin_fullname = $_POST['admin_fullname'];
        $admin_tel = $_POST['admin_tel'];
        $admin_bank_name = $_POST['admin_bank_name'];
        $admin_account_number = $_POST['admin_account_number'];
        $admin_password = $_POST['admin_password'];
        $admin_password_confirm = $_POST['admin_password_confirm'];

        // Check if passwords match
        if ($admin_password !== $admin_password_confirm) {
            echo "รหัสผ่านไม่ตรงกัน";
            exit(); // Stop further execution
        }

        // Hash the password before storing it in the database
        $hashed_password = hashPassword($admin_password);

        // Validate email format
        if (!filter_var($admin_email, FILTER_VALIDATE_EMAIL)) {
            echo "รูปแบบอีเมลไม่ถูกต้อง";
            exit();
        }

        // Using a prepared statement to insert the data
        $stmt = $conn->prepare("INSERT INTO admin (admin_shop, admin_detail, admin_address, admin_username, admin_email, admin_fullname, admin_tel, admin_bank_name, admin_account_number, admin_password, admin_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Set admin_status to 1
        $admin_status = 1;

        $stmt->bind_param("sssssssssss", $admin_shop, $admin_detail, $admin_address, $admin_username, $admin_email, $admin_fullname, $admin_tel, $admin_bank_name, $admin_account_number, $hashed_password, $admin_status);

        if ($stmt->execute()) {
            echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'เพิ่มข้อมูลร้านค้าสำเร็จ',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                window.location.href = 'admin.php';
            });
        </script>";
        } else {
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'เพิ่มข้อมูลร้านค้าไม่สำเร็จ',
                text: 'กรุณาลองใหม่อีกครั้ง',
            }).then(() => {
                window.history.back();
            });
        </script>";
        }
    }
    ?>

    <!-- ... ส่วนที่เหลือของ HTML ... -->



    <script>
        $(document).ready(function() {
            $(".default-select2").select2();
        });
    </script>
    <?php include('includes/footer.php'); ?>
</body>

</html>