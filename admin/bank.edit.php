<?php 
  include('../config.php');
  include('includes/authentication.php'); 
  include('includes/header.php'); 

  $product_id = $conn->real_escape_string($_GET['id']);
  $sql = "SELECT * FROM product WHERE product_id = $product_id AND seller_id = ".$_SESSION['seller_id'];
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();

  $sql = "SELECT * FROM brands";
  $resultBrand = $conn->query($sql);

  $sql = "SELECT * FROM categories";
  $resultCategory = $conn->query($sql);
?>

<!-- begin #content -->
<div id="content" class="content">
  <!-- begin breadcrumb -->
  <ol class="breadcrumb float-xl-right">
    <li class="breadcrumb-item"><a href="./">หน้าหลัก</a></li>
    <li class="breadcrumb-item active"><a href="product.php">จัดการสินค้า</a></li>
    <li class="breadcrumb-item active">แก้ไขข้อมูลสินค้า</li>
  </ol>
  <!-- end breadcrumb -->
  <!-- begin page-header -->
  <h1 class="page-header">
    แก้ไขข้อมูลสินค้า 
    <!-- <small>header small text goes here...</small> -->
  </h1>
  <!-- end page-header -->

  <!-- begin panel -->
  <form action="process_product.edit.php" method="POST" enctype="multipart/form-data" data-parsley-validate="true">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">แก้ไขข้อมูลสินค้า</h4>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-4">
            <div class="form-group">
              <label for="product_id">รหัสสินค้า</label>
              <input type="text" class="form-control" id="product_id" name="product_id" placeholder="รหัสสินค้า" value="<?php echo $row['product_id']; ?>" readonly>
            </div>
          </div>
          <div class="col-4">
            <div class="form-group">
              <label for="category_id">ประเภทสินค้า</label>
              <select class="default-select2 form-control" id="category_id" name="category_id" data-parsley-required="true">
                <?php foreach ($resultCategory as $r){ ?>
                <option value="<?php echo $r['category_id']; ?>" <?php echo ($r['category_id'] === $row['category_id'])?"selected": ""; ?> ><?php echo $r['category_name']; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-4">
            <div class="form-group">
              <label for="brand_id">แบรนด์</label>
              <select class="default-select2 form-control" id="brand_id" name="brand_id" data-parsley-required="true">
                <?php foreach ($resultBrand as $r){ ?>
                <option value="<?php echo $r['brand_id']; ?>" <?php echo ($r['brand_id'] === $row['brand_id'])?"selected": ""; ?> ><?php echo $r['brand_name']; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-4">
            <div class="form-group">
              <label for="product_name">ชื่อสินค้า</label>
              <input type="text" class="form-control" id="product_name" name="product_name" placeholder="ชื่อสินค้า" data-parsley-required="true" value="<?php echo $row['product_name']; ?>">
            </div>
          </div>
          <div class="col-4">
            <div class="form-group">
              <label for="product_price">ราคา</label>
              <input type="text" class="form-control" id="product_price" name="product_price" placeholder="ราคา" data-parsley-required="true" data-parsley-type="number" data-parsley-min="0" value="<?php echo $row['product_price']; ?>"> 
            </div>
          </div>
          <div class="col-4">
            <div class="form-group">
              <label for="product_qty">จำนวน</label>
              <input type="text" class="form-control" id="product_qty" name="product_qty" placeholder="จำนวน" data-parsley-required="true" data-parsley-type="digits" value="<?php echo $row['product_qty']; ?>">
            </div>
          </div>
          <div class="col-4">
            <div class="form-group">
              <label for="product_use">ระยะเวลาการใช้ (หน่วยเป็นวัน)</label>
              <input type="text" class="form-control" id="product_use" name="product_use" placeholder="ระยะเวลาการใช้ (หน่วยเป็นวัน)" data-parsley-required="true" data-parsley-type="digits" value="<?php echo $row['product_use']; ?>">
            </div>
          </div>
          <div class="col-4">
            <div class="form-group">
              <label for="product_detail">รายละเอียดสินค้า</label>
              <textarea class="form-control" id="product_detail" name="product_detail" placeholder="รายละเอียดสินค้า" data-parsley-required="true"><?php echo $row['product_detail']; ?></textarea>
            </div>
          </div>
          <div class="col-4">
            <div class="form-group">
              <label for="product_image">รูปภาพ</label>
              <input type="file" class="form-control" id="product_image" name="product_image" accept="image/*">
            </div>
          </div>
        </div>
      </div>
      <div class="panel-footer text-right">
        <a href="product.php" class="btn btn-white btn-sm">ย้อนกลับ</a>
        <button type="submit" class="btn btn-warning btn-sm m-l-5">แก้ไขข้อมูลสินค้า</button>
      </div>
    </div>
  </form>
  <!-- end panel -->

</div>
<!-- end #content -->

<?php include('includes/footer.php'); ?>

<script>
  $(document).ready(function() {
    $(".default-select2").select2();
  });
</script>
