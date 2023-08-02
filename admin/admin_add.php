<?php 
  include('../config.php');
  include('includes/authentication.php'); 
  include('includes/header.php'); 
 
     $sql = "SELECT * FROM seller";
  $result = $conn->query($sql);
?>

<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="./">หน้าหลัก</a></li>
        <li class="breadcrumb-item active"><a href="admin.php">จัดการแอดมิน
            </a></li>
        <li class="breadcrumb-item active">เพิ่มข้อมูลแอดมิน</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">
        เพิ่มข้อมูลแอดมิน
        <!-- <small>header small text goes here...</small> -->
    </h1>
    <!-- end page-header -->

    <!-- begin panel -->
    <form action="process_admin.add.php" method="POST" enctype="multipart/form-data" data-parsley-validate="true">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">แก้ไขข้อมูลร้าน</h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="seller_shop">ชื่อร้าน</label>
                            <input type="text" class="form-control" id="seller_shop" name="seller_shop"
                                placeholder="ชื่อร้านค้า" data-parsley-required="true">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="seller_detail">รายละเอียดร้าน</label>
                            <textarea class="form-control" id="seller_detail" name="seller_detail"
                                placeholder="รายละเอียดร้าน" data-parsley-required="true"></textarea>
                        </div>
                    </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="seller_address">ที่อยู่ร้าน</label>
                                <textarea class="form-control" id="seller_address" name="seller_address"
                                    placeholder="ที่อยู่ร้าน" data-parsley-required="true"></textarea>
                            </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">แก้ไขข้อมูลส่วนตัว</h4>
            </div>
            <div class="panel-body">
                <div class="row">
                <div class="col-4">
              <div class="form-group">
                <label for="seller_id">รหัสผู้ขาย</label>
                <input type="text" class="form-control" id="seller_id" name="seller_id" placeholder="รหัสผู้ขาย" readonly>
              </div>
            </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>ชื่อบัญชีผู้ขาย</label>
                            <input type="text" class="form-control" id="seller_name" name="seller_shop"
                                placeholder="ชื่อบัญชีผู้ขาย" data-parsley-required="true">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="seller_email">อีเมล</label>
                            <input type="text" class="form-control" id="seller_email" name="seller_email"
                                placeholder="อีเมล" data-parsley-required="true">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="seller_fullname">ชื่อ-สกุลผู้ขาย</label>
                           <input type="text" class="form-control" id="seller_fullname" name="seller_fullname"
                                placeholder="ชื่อ-สกุลผู้ขาย" data-parsley-required="true">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="seller_tel">เบอร์ติดต่อ</label>
                            <input type="text" class="form-control" id="seller_tel" name="seller_tel"
                                placeholder="เบอร์ติดต่อ" data-parsley-required="true">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="seller_bank_name">ชื่อธนาคาร</label>
                            <input type="text" class="form-control" id="seller_bank_name" name="seller_bank_name"
                                placeholder="ชื่อธนาคาร" data-parsley-required="true">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="seller_account_number">เลขที่บัญชี</label>
                            <input type="text" class="form-control" id="seller_account_number" name="seller_account_number"
                                placeholder="เลขที่บัญชี" data-parsley-required="true">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="seller_password">รหัสผ่าน (หากไม่เปลี่ยน โปรดปล่อยว่าง)</label>
                            <input type="password" id="seller_password" name="seller_password" placeholder="รหัสผ่าน"
                                class="form-control" data-parsley-equalto="#seller_password_confirm" />
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="seller_password_confirm">ยืนยันรหัสผ่าน (หากไม่เปลี่ยน โปรดปล่อยว่าง)</label>
                            <input type="password" id="seller_password_confirm" name="seller_password_confirm"
                                placeholder="ยืนยันรหัสผ่าน" class="form-control"
                                data-parsley-equalto="#seller_password" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer text-right">
                <a href="admin.php" class="btn btn-white btn-sm">ย้อนกลับ</a>
                <button type="submit" class="btn btn-success btn-sm m-l-5">เพิ่มข้อมูลแอดมิน</button>
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