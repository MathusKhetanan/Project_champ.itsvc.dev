<?php 
  include('config.php');

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $user_id = $_SESSION['user_id'];
    $review_title =  $conn->real_escape_string($_POST['review_title']);
    $review_message =  $conn->real_escape_string($_POST['review_message']);
    $order_id =  $conn->real_escape_string($_POST['order_id']);
    $product_id =  $conn->real_escape_string($_POST['product_id']);
    $sql = "SELECT * FROM orders WHERE order_id = $order_id AND user_id = $user_id AND order_status = 'successful'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
      $sql = "INSERT INTO product_review(product_id, user_id, review_title, review_message, order_id) VALUE($product_id, $user_id, '$review_title', '$review_message', $order_id)";
      if($conn->query($sql)){
        echo "<script>
          alert('บันทึกข้อมูลรีวิวสำเร็จ');
          window.location.href = 'product_detail.php?id=$product_id';
        </script>";
      }else{
        echo "<script>
          alert('บันทึกข้อมูลรีวิวไม่สำเร็จ คุณอาจจะเคยรีวิวสินค้านี้ไปแล้ว');
          window.location.href = 'product_detail.php?id=$product_id';
        </script>";
      }
    }else{
      echo "<script>
        alert('คุณไม่ได้ซื้อสินค้านี้');
        window.location.href = 'product_detail.php?id=$product_id';
      </script>";
    }
  }
