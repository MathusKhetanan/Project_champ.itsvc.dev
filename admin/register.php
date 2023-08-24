<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="icon" href="../dist/img/logo/icon.png" type="image/icon type">
  <title>ระบบตลาดกลางอาหารสัตว์เลี้ยง | สมัครเป็นผู้ขาย</title>
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
  <meta content="" name="description" />
  <meta content="" name="author" />

  <!-- ================== BEGIN BASE CSS STYLE ================== -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=K2D:wght@200&display=swap" rel="stylesheet">
  <link href="../dist/css/default/app.min.css" rel="stylesheet" />
  <!-- ================== END BASE CSS STYLE ================== -->
</head>

<body class="pace-top" style="font-family: 'K2D';">
  <!-- begin #page-loader -->
  <div id="page-loader" class="fade show">
    <span class="spinner"></span>
  </div>
  <!-- end #page-loader -->

  <!-- begin login-cover -->
  <div class="login-cover">
    <div class="login-cover-image" style="background-image: url(../dist/img/login-bg/login-bg-17.jpg)" data-id="login-cover-image"></div>
    <div class="login-cover-bg"></div>
  </div>
  <!-- end login-cover -->

  <!-- begin #page-container -->
  <div id="page-container" class="fade">
    <!-- begin login -->
    <div class="login login-v2" data-pageload-addclass="animated fadeIn">
      <!-- begin brand -->
      <div class="login-header">
        <div class="brand">
          <img src="../dist/img/logo/icon.png" style="width: 40px; height: 40px;"> <b>ลงทะเบียน</b> ผู้ขาย
          <small>ระบบตลาดกลางอาหารสัตว์เลี้ยง</small>
        </div>
        <div class="icon">
          <i class="fa fa-lock"></i>
        </div>
      </div>
      <!-- end brand -->
      <!-- begin login-content -->
      <div class="login-content">
        <form action="process_register.php" method="POST" class="margin-bottom-0" data-parsley-validate="true">
          <div class="form-group m-b-20">
            <input type="text" class="form-control form-control-lg" name="admin_fullname" placeholder="ชื่อ-สกุล" data-parsley-required="true" />
          </div>
          <div class="form-group m-b-20">
            <input type="email" class="form-control form-control-lg" name="admin_email" placeholder="อีเมล" data-parsley-required="true" data-parsley-type="email" />
          </div>
          <div class="form-group m-b-20">
            <input type="text" class="form-control form-control-lg" name="admin_username" placeholder="ชื่อผู้ใช้" data-parsley-required="true" />
          </div>
          <div class="form-group m-b-20">
            <input type="password" class="form-control form-control-lg" name="admin_password" placeholder="รหัสผ่าน" data-parsley-required="true" />
          </div>
          <div class="login-buttons">
            <button type="submit" class="btn btn-success btn-block btn-lg">ลงทะเบียน</button>
          </div>
          <div class="m-t-20">
            ถ้าเป็นสมาชิกแล้ว? คลิ๊ก <a href="login.php">ที่นี่</a> เพื่อเข้าสู่ระบบ.
          </div>
        </form>
      </div>
      <!-- end login-content -->
    </div>
    <!-- end login -->

    <!-- begin login-bg -->
    <ul class="login-bg-list clearfix">
      <li class="active"><a href="javascript:;" data-click="change-bg" data-img="../dist/img/login-bg/login-bg-17.jpg" style="background-image: url(../dist/img/login-bg/login-bg-17.jpg)"></a></li>
      <li><a href="javascript:;" data-click="change-bg" data-img="../dist/img/login-bg/login-bg-16.jpg" style="background-image: url(../dist/img/login-bg/login-bg-16.jpg)"></a></li>
      <li><a href="javascript:;" data-click="change-bg" data-img="../dist/img/login-bg/login-bg-15.jpg" style="background-image: url(../dist/img/login-bg/login-bg-15.jpg)"></a></li>
      <li><a href="javascript:;" data-click="change-bg" data-img="../dist/img/login-bg/login-bg-14.jpg" style="background-image: url(../dist/img/login-bg/login-bg-14.jpg)"></a></li>
      <li><a href="javascript:;" data-click="change-bg" data-img="../dist/img/login-bg/login-bg-13.jpg" style="background-image: url(../dist/img/login-bg/login-bg-13.jpg)"></a></li>
      <li><a href="javascript:;" data-click="change-bg" data-img="../dist/img/login-bg/login-bg-12.jpg" style="background-image: url(../dist/img/login-bg/login-bg-12.jpg)"></a></li>
    </ul>
    <!-- end login-bg -->

    <!-- begin scroll to top btn -->
    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
    <!-- end scroll to top btn -->
  </div>
  <!-- end page container -->

  <!-- ================== BEGIN BASE JS ================== -->
  <script src="../dist/js/app.min.js"></script>
  <script src="../dist/js/theme/default.min.js"></script>
  <!-- ================== END BASE JS ================== -->

  <!-- ================== BEGIN PAGE LEVEL JS ================== -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>
  <script src="../dist/js/demo/login-v2.demo.js"></script>
  <!-- ================== END PAGE LEVEL JS ================== -->
</body>

</html>