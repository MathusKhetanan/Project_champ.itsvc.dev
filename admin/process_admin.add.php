<?php
include('../config.php');
include('includes/header.php');
// Function to hash the password using SHA-512
function hashPassword($password) {
    return hash('sha512', $password);
}

// เพิ่มข้อมูลร้านค้าใหม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seller_username = $_POST['seller_username'];
    $seller_password = $_POST['seller_password'];

    // Hash the password before storing it in the database
    $hashed_password = hashPassword($seller_password);

    // Using a prepared statement to insert the data
    $stmt = $conn->prepare("INSERT INTO seller (seller_username,seller_password, seller_status) VALUES (?,?,?)");
    $seller_status = 1; // Set seller_status to 1
    $stmt->bind_param("ssi", $seller_username, $hashed_password, $seller_status);

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
<?php include('includes/footer.php'); ?>