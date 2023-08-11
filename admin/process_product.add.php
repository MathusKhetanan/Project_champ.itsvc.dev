<?php 
  include('../config.php');

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seller_id = $_SESSION['seller_id'];
    $category_id = $conn->real_escape_string($_POST['category_id'] );
    $brand_id = $conn->real_escape_string($_POST['brand_id'] );
    $product_name = $conn->real_escape_string($_POST['product_name']) ;
    $product_price = $conn->real_escape_string($_POST['product_price'] );
    $product_qty = $conn->real_escape_string($_POST['product_qty']);
    $product_detail = $conn->real_escape_string($_POST['product_detail']);
    $product_use = $conn->real_escape_string($_POST['product_use']);

    $sql = "INSERT INTO product(seller_id, category_id, brand_id, product_name, product_detail, product_price, product_qty, product_use) VALUE($seller_id, $category_id, $brand_id, '$product_name', '$product_detail', $product_price, $product_qty, $product_use)";
    if(file_exists($_FILES['product_image']['tmp_name']) || is_uploaded_file($_FILES['product_image']['tmp_name'])) {
      $extension = pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION);
      $pathImage = "dist/img/product/".md5(time()).".".$extension;
      if(move_uploaded_file($_FILES['product_image']['tmp_name'], "../".$pathImage)){
        $sql = "INSERT INTO product(seller_id, category_id, brand_id, product_name, product_detail, product_price, product_qty, product_image, product_use) VALUE($seller_id, $category_id, $brand_id, '$product_name', '$product_detail', $product_price, $product_qty, '$pathImage', $product_use)";
      }else{
        echo "<script>
          alert('อัพโหลดรูปภาพสินค้าไม่สำเร็จ');
          window.history.back();
        </script>";
        exit();
      }
    }
    if($conn->query($sql)){
      echo "<script>
        alert('เพิ่มข้อมูลสินค้าสำเร็จ');
        window.location.href = 'product.php';
      </script>";
    }else{
      echo "<script>
        alert('เพิ่มข้อมูลสินค้าไม่สำเร็จ');
        window.history.back();
      </script>";
    }
  }
?>