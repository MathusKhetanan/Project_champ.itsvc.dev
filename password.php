<?php 
			include('config.php'); 
			include('includes/authentication.php'); 
			include('includes/header.php'); 

			$sql = "SELECT * FROM categories";
			$result = $conn->query($sql);
		?>
		<style>
.form-control {
    border: 1px solid #ced4da !important;
}
		</style>
		<!-- BEGIN #my-account -->
		<div id="about-us-cover" class="section-container" style="margin-bottom: 3rem">
		    <!-- BEGIN container -->
		    <div class="container">
		        <!-- BEGIN breadcrumb -->
		        <ul class="breadcrumb mb-3">
		            <li class="breadcrumb-item"><a href="./">หน้าหลัก</a></li>
		            <li class="breadcrumb-item active">บัญชีของฉัน</li>
		        </ul>
		        <!-- END breadcrumb -->
		        <!-- BEGIN account-container -->
		        <div class="account-container">
		            <?php include('includes/profile.menu.php');  ?>
		            <!-- BEGIN account-body -->
		            <div class="account-body" style="height: 100%;min-height: 650px;background-color: #d9e0e7;">
		                <!-- BEGIN row -->
		                <div class="row">
		                    <!-- BEGIN col-6 -->
		                    <div class="col-md-12">
		                        <!-- begin panel -->
		                        <form action="process_password.php" method="POST" data-parsley-validate="true">
		                            <div class="panel panel-default">
		                                <div class="panel-heading">
		                                    <h4 class="panel-title" style="font-size: 20px"><i
		                                            class="fa fa-key fa-fw text-primary"></i> เปลี่ยนรหัสผ่าน
		                                    </h4>
		                                </div>
		                                <div class="panel-body">
		                                    <div class="row">
		                                      
		                                        <div class="col-6">
		                                            <div class="form-group">
		                                                <label for="user_password">รหัสผ่าน (หากไม่เปลี่ยน
		                                                    โปรดปล่อยว่าง)</label>
		                                                <input type="password" id="user_password" name="user_password"
		                                                    placeholder="รหัสผ่าน" class="form-control"
		                                                    data-parsley-equalto="#user_password_confirm" />
		                                            </div>
		                                        </div>
		                                        <div class="col-6">
		                                            <div class="form-group">
		                                                <label for="user_password_confirm">ยืนยันรหัสผ่าน (หากไม่เปลี่ยน
		                                                    โปรดปล่อยว่าง)</label>
		                                                <input type="password" id="user_password_confirm"
		                                                    name="user_password_confirm" placeholder="ยืนยันรหัสผ่าน"
		                                                    class="form-control" data-parsley-equalto="#user_password" />
		                                            </div>
		                                        </div>
		                                    </div>
		                                </div>
		                                <div class="panel-footer text-right">
		                                    <button type="submit" class="btn btn-success m-l-5">แก้ไขข้อมูลส่วนตัว</button>
		                                </div>
		                            </div>
		                        </form>
		                        <!-- end panel -->
		                    </div>
		                    <!-- END col-6 -->
		                </div>
		                <!-- END row -->
		            </div>
		            <!-- END account-body -->
		        </div>
		        <!-- END account-container -->
		    </div>
		    <!-- END container -->
		</div>
		<!-- END #about-us-cover -->

		<?php include('includes/footer.php'); ?>