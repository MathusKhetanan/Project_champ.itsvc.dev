<?php 
  include('config.php');

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    try {
      require_once dirname(__FILE__).'/Omise/lib/Omise.php';
      define('OMISE_API_VERSION', '2019-05-29');
      define('OMISE_PUBLIC_KEY', 'pkey_test_5r0gn5997jah59d6ns1');
      define('OMISE_SECRET_KEY', 'skey_test_5r0gn599f16unthb4cs');

      $charge = OmiseCharge::create(array(
        'amount' =>  $_POST['amount'],
        'currency' => 'thb',
        'card' => $_POST['omiseToken']
      ));
      echo "<pre>";
      if($charge['status'] === "successful"){
        $ref = substr(md5(rand().time()), 0, 8);
        $items = json_decode($_POST['items'], true);
        $conn->begin_transaction();
        foreach($items as $item){
          $user_id = $_SESSION['user_id'];
          $seller_id = $conn->real_escape_string($item['key']);
          $sql = "INSERT INTO orders(user_id, seller_id, order_status, order_ref) VALUES ($user_id, $seller_id, 'paid', '$ref')";
          $conn->query($sql);
          $order_id = $conn->insert_id;
          $sumTotal = 0;
          foreach($item['order'] as $order){
            $product_id = $conn->real_escape_string($order['id']);
            $product_name = $conn->real_escape_string($order['name']);
            $product_price = $conn->real_escape_string($order['price']);
            $order_qty = $conn->real_escape_string($order['qty']);
            $order_subtotal = (float)$product_price*(float)$order_qty;
            $sumTotal += $order_subtotal;
            $sql = "SELECT product_qty FROM product WHERE product_id = $product_id";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            if($row['product_qty'] < $order_qty){
              throw new Exception("สินค้า ".$product_name." ไม่คงเหลือ ".$row['product_qty']." ชิ้น กรุณาอัพเดทตะกร้าของคุณ");
            }
            $free = ($sumTotal * $charge['transaction_fees']['fee_rate'])/100;
            $free_vat = ($free * $charge['transaction_fees']['vat_rate'])/100;
            $order_total_free = number_format($free, 2);
            $order_total_free_vat = number_format($free_vat, 2);
            $order_total_net = $sumTotal - ($order_total_free + $order_total_free_vat);

            // Save transaction_fees
            $order_total_free = $charge['transaction_fees']['fee_rate'];
            $order_total_free_vat = $charge['transaction_fees']['vat_rate'];

            $sql = "UPDATE orders SET order_total = $sumTotal, order_total_net = $order_total_net, order_total_free = $order_total_free, order_total_free_vat = $order_total_free_vat WHERE order_id = $order_id";
            $conn->query($sql);
            $sql = "UPDATE product SET product_qty = product_qty - ".(int)$order_qty." WHERE product_id = $product_id";
            $conn->query($sql);
            $sql = "INSERT INTO order_detail(order_id, product_id, product_name, product_price, order_qty, order_subtotal) VALUES ($order_id, $product_id, '$product_name', $product_price, $order_qty, $order_subtotal)";
            $conn->query($sql);
          }
          $conn->commit();
          echo '<script>
            window.location = "order.php";
            localStorage.removeItem("items");
            alert("บันทึกข้อมูลชำระเงินสำเร็จ");
          </script>';
        }
      } 
    }catch (Exception $e) {
      $conn->Rollback();
      echo '<script>
        alert("'.$e->getMessage().'");
        window.history.back();
      </script>';
    }
  }
?>