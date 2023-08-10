<?php
include('includes/authentication.php');
include('includes/header.php');
?>
<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="./">หน้าหลัก</a></li>
        <li class="breadcrumb-item active"><a href="brands.php">จัดการแบรนด์</a></li>
        <li class="breadcrumb-item active">เพิ่มข้อมูลแบรนด์</li>
    </ol>
    <!-- begin page-header -->
    <h1 class="page-header">
        เพิ่มข้อมูลแบรนด์
    </h1>
    <!-- begin panel -->
    <form action="process_brand.add.php" method="POST" enctype="multipart/form-data" data-parsley-validate="true">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">เพิ่มข้อมูลแบรนด์</h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="brand_id">รหัสแบรนด์</label>
                            <input type="text" class="form-control" id="brand_id" name="brand_id" placeholder="รหัสแบรนด์" readonly>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="brand_name">ชื่อแบรนด์</label>
                            <input type="text" class="form-control" id="brand_name" name="brand_name" placeholder="ชื่อแบรนด์" data-parsley-required="true">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="brand_image">รูปภาพ</label>
                            <input type="file" class="form-control" id="brand_image" name="brand_image" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer text-right">
                <a href="brands.php" class="btn btn-white btn-sm">ย้อนกลับ</a>
                <button type="submit" class="btn btn-success btn-sm m-l-5">เพิ่มข้อมูลแบรนด์</button>
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