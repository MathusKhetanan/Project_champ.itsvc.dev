<?php 
  include('../config.php');

  if (!empty($_GET) && isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] === "delete") {
    try {
      $brand_id = $conn->real_escape_string($_GET['id']);
      $sql = "SELECT * FROM brands WHERE brand_id = ".$brand_id;
      $result = $conn->query($sql);
      if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $brand_image = $row['brand_image'];

        if ($brand_image != "" && file_exists("../".$brand_image) && !unlink("../".$brand_image)) { 
          echo "<script>
            alert('ลบรูปแบรนด์ไม่สำเร็จ');
            window.location.href = 'brands.php';
          </script>";
          exit();
        }

        $delete_sql = "DELETE FROM brands WHERE brand_id = ".$brand_id;
        if ($conn->query($delete_sql)) {
          echo "<script>
            alert('ลบข้อมูลแบรนด์สำเร็จ');
            window.location.href = 'brands.php';
          </script>";
        } else {
          echo "<script>
            alert('ลบข้อมูลแบรนด์ไม่สำเร็จ: ".$conn->error."');
            window.location.href = 'brands.php';
          </script>";
        }
      } else {
        echo "<script>
          alert('ไม่พบแบรนด์ที่ต้องการลบ');
          window.location.href = 'brands.php';
        </script>";
      }
    } catch (\Throwable $th) {
      echo "<script>
        alert('ลบข้อมูลแบรนด์ไม่สำเร็จ: ".$th->getMessage()."');
        window.location.href = 'brands.php';
      </script>";
    }
  }
?>
  