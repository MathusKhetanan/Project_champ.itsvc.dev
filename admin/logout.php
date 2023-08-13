<!DOCTYPE html>
<html lang="en">
<head>
    <!-- เรียกใช้ไฟล์ SweetAlert ผ่าน CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
</head>
<body>

<?php
  session_start();
  session_unset();
  session_destroy();

  // เพิ่มคำสั่งสร้าง JavaScript เพื่อแสดง SweetAlert
  echo '<script>
    // แสดง SweetAlert เมื่อ session ถูกล้างและทำลาย
    Swal.fire({
      title: "สำเร็จ!",
      text: "คุณได้ทำการออกจากการเชื่อมต่อและถูกนำกลับสู่หน้าหลัก",
      icon: "success",
      confirmButtonText: "ตกลง",
    }).then(() => {
      // เปลี่ยนเส้นทางไปยัง index.php
      window.location.href = "index.php";
    });
  </script>';

  exit();
?>
</body>
</html>
