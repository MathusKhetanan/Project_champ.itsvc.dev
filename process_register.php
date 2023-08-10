<?php 
include 'config.php';

// Receive variable values from the form
$name = $_POST['user_fullname'];
$email = $_POST['user_email'];
$username = $_POST['user_username'];
$password = $_POST['user_password'];

// Validate input data
// Example: Check if email is in a valid format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo "<script>
    alert('Invalid email format');
    window.history.back();
  </script>";
  exit;
}

// Example: Check if password meets complexity requirements
if (strlen($password) < 6) {
  echo "<script>
    alert('Password must be at least 6 characters long');
    window.history.back();
  </script>";
  exit;
}

// Hash the password using PASSWORD_ARGON2ID if available, or fallback to PASSWORD_DEFAULT
if (defined('PASSWORD_ARGON2ID')) {
  $hashed_password = password_hash($password, PASSWORD_ARGON2ID);
} else {
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
}

$user_status = 1; // Set the user status value to 1

// Check if the email already exists in the database
$sql_check_email = "SELECT * FROM user WHERE user_email = ?";
$stmt_check_email = mysqli_prepare($conn, $sql_check_email);
mysqli_stmt_bind_param($stmt_check_email, "s", $email);
mysqli_stmt_execute($stmt_check_email);
$result_check_email = mysqli_stmt_get_result($stmt_check_email);

if (mysqli_num_rows($result_check_email) > 0) {
  echo "<script> alert('Email already exists in the database'); </script> ";
  echo "<script> window.history.back(); </script>";
  exit;
}

// Prepare the SQL statement using prepared statements
$sql = "INSERT INTO user (user_fullname, user_email, user_username, user_password, user_status) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssssi", $name, $email, $username, $hashed_password, $user_status);

// Execute the prepared statement
$result = mysqli_stmt_execute($stmt);

if($result){
    echo "<script> alert('บันทึกข้อมูลการสมัครสำเร็จ'); </script> ";
    echo "<script> window.location='login.php';  </script> ";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    echo "<script> alert('ไม่สามารถบันทึกข้อมูลได้'); </script> ";
}

// Close the prepared statement and database connection
mysqli_stmt_close($stmt);
mysqli_close($conn);