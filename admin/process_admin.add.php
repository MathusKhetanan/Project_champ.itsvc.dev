<?php
include('../config.php');

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
    $stmt->bind_param("ssi", $seller_username,$hashed_password, $seller_status);

    if ($stmt->execute()) {
        echo "<script>
            alert('เพิ่มข้อมูลร้านค้าสำเร็จ');
            window.location.href = 'admin.php';
        </script>";
    } else {
        echo "<script>
            alert('เพิ่มข้อมูลร้านค้าไม่สำเร็จ');
            window.history.back();
        </script>";
    }
}
