    <?php   
      include('../config.php');
			include('includes/authentication.php'); 
			include('includes/header.php'); 

      $sql = "SELECT * FROM orders LEFT JOIN user ON orders.user_id = user.user_id";
      $result = $conn->query($sql);
		?>

		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="./">หน้าหลัก</a></li>
				<li class="breadcrumb-item active">จัดการออเดอร์</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">
        จัดการออเดอร์ 
        <!-- <small>header small text goes here...</small> -->
      </h1>
			<!-- end page-header -->

			<!-- begin panel -->
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">จัดการออเดอร์</h4>
				</div>
				<div class="panel-body">
					<table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
						<thead>
							<tr>
								<th width="1%"></th>
								<th class="text-nowrap">ชื่อ-สกุลผู้สั่ง</th>
								<th class="text-nowrap">เบอร์ติดต่อ</th>
								<th class="text-nowrap">ราคารวม</th>
								<th class="text-nowrap">fee+vat</th>
								<th class="text-nowrap">ยอดที่ได้รับ</th>
								<th class="text-nowrap text-center">สถานะออเดอร์</th>
								<th class="text-nowrap">สั่งซื้อเมื่อ</th>
								<th class="text-nowrap">เลขที่อ้างอิง</th>
								<th class="text-nowrap text-center">อัพเดจสถานะ</th>
								<th class="text-nowrap text-center">ดูรายการคำสั่งซื้อ</th>
							</tr>
						</thead>
						<tbody>
              <?php foreach ($result as $key => $row){ 
								$free = number_format(($row['order_total'] * $row['order_total_free'])/100, 2);
								$free_vat = number_format(($free * $row['order_total_free_vat'])/100, 2);
							?>
							<tr>
								<td width="1%" class="f-s-600 text-inverse"><?php echo $key+1; ?></td>
								<td><?php echo $row['user_fullname']; ?></td>
								<td><?php echo $row['user_tel']; ?></td>
								<td><?php echo $row['order_total']; ?></td>
								<td><?php echo $free+$free_vat; ?></td>
								<td><?php echo $row['order_total_net']; ?></td>
								<td class="text-center"><span class="badge bg-<?php echo $StatusColor[$row['order_status']]; ?>" style="font-size: 14px"><?php echo $Status[$row['order_status']]; ?></span></td>
								<td><?php echo $row['createdAt']; ?></td>
								<td><?php echo $row['order_ref']; ?></td>
								<td class="text-center">
                  <form action="process_order.status.php" method="POST" data-parsley-validate="true">
                  <?php if($row['order_status'] == "paid"){ ?>
                    <button type="submit" class="btn btn-<?php echo $StatusColor['preparing']; ?>" name="change_status" value="<?php echo $row['order_id']; ?>"><?php echo $Status['preparing']; ?></button>
                  <?php }else if($row['order_status'] == "preparing"){ ?>
                    <input type="text" class="form-control w-50 mx-auto mb-1" id="order_tracking" name="order_tracking" placeholder="กรอกหมายเลขพัสดุ" data-parsley-required="true">
                    <button type="submit" class="btn btn-<?php echo $StatusColor['shipping']; ?>" name="change_status" value="<?php echo $row['order_id']; ?>"><?php echo $Status['shipping']; ?></button>
                  <?php }else if($row['order_status'] == "shipping"){ ?>
                    <button type="button" class="btn btn-<?php echo $StatusColor['successful']; ?>" name="change_status" value="<?php echo $row['order_id']; ?>" disabled><?php echo "รอลูกค้ารับสินค้า"; ?></button>
                  <?php }else if($row['order_status'] == "successful"){ ?>
                    <span class="badge bg-green" style="font-size: 14px">ดำเนินการสำเร็จ</span>
                  <?php } ?>
                  </form>
                </td>
                <td class="text-center">
                  <a class="btn btn-outline-info" href="order.detail.php?id=<?php echo $row['order_id']; ?>">ดูรายละเอียด</a>
                </td>
							</tr>
              <?php } ?>
						</tbody>
					</table>
				</div>
			</div>
			<!-- end panel -->

		</div>
		<!-- end #content -->

		<?php include('includes/footer.php'); ?>
