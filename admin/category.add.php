  <?php
  include('includes/authentication.php');
  include('includes/header.php');
  ?>

  <!-- begin #content -->
  <div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
      <li class="breadcrumb-item"><a href="./">หน้าหลัก</a></li>
      <li class="breadcrumb-item active"><a href="categories.php">จัดการประเภทสินค้า</a></li>
      <li class="breadcrumb-item active">เพิ่มข้อมูลประเภทสินค้า</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">
      เพิ่มข้อมูลประเภทสินค้า
      <!-- <small>header small text goes here...</small> -->
    </h1>
    <!-- end page-header -->

    <!-- begin panel -->
    <form action="process_category.add.php" method="POST" data-parsley-validate="true">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">เพิ่มข้อมูลประเภทสินค้า</h4>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-4">
              <div class="form-group">
                <label for="category_id">รหัสประเภทสินค้า</label>
                <input type="text" class="form-control" id="category_id" name="category_id" placeholder="รหัสประเภทสินค้า" readonly>
              </div>
            </div>
            <div class="col-4">
              <div class="form-group">
                <label for="category_name">ชื่อประเภทสินค้า</label>
                <input type="text" class="form-control" id="category_name" name="category_name" placeholder="ชื่อประเภทสินค้า" data-parsley-required="true">
              </div>
            </div>
          </div>
        </div>
        <div class="panel-footer text-right">
          <a href="categories.php" class="btn btn-white btn-sm">ย้อนกลับ</a>
          <button type="submit" class="btn btn-success btn-sm m-l-5">เพิ่มข้อมูลประเภทสินค้า</button>
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