<?php
include('../config.php');
include('includes/authentication.php');
include('includes/header.php');

// Function to hash the password using SHA-512
function hashPassword($password) {
    return hash('sha512', $password);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize the data from the form
    $seller_shop = $_POST['seller_shop'];
    $seller_detail = $_POST['seller_detail'];
    $seller_address = $_POST['seller_address'];
    $seller_username = $_POST['seller_username'];
    $seller_email = $_POST['seller_email'];
    $seller_fullname = $_POST['seller_fullname'];
    $seller_tel = $_POST['seller_tel'];
    $seller_bank_name = $_POST['seller_bank_name'];
    $seller_account_number = $_POST['seller_account_number'];
    $seller_password = $_POST['seller_password'];
    $seller_password_confirm = $_POST['seller_password_confirm'];

    // Check if passwords match
    if ($seller_password !== $seller_password_confirm) {
        echo "รหัสผ่านไม่ตรงกัน";
        exit(); // Stop further execution
    }

    // Hash the password before storing it in the database
    $hashed_password = hashPassword($seller_password);

    // Validate email format
    if (!filter_var($seller_email, FILTER_VALIDATE_EMAIL)) {
        echo "รูปแบบอีเมลไม่ถูกต้อง";
        exit();
    }

    // Using a prepared statement to insert the data
    $stmt = $conn->prepare("INSERT INTO seller (seller_shop, seller_detail, seller_address, seller_username, seller_email, seller_fullname, seller_tel, seller_bank_name, seller_account_number, seller_password, seller_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Set seller_status to 1
    $seller_status = 1;

    $stmt->bind_param("sssssssssss", $seller_shop, $seller_detail, $seller_address, $seller_username, $seller_email, $seller_fullname, $seller_tel, $seller_bank_name, $seller_account_number, $hashed_password, $seller_status);

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