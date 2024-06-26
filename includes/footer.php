<div id="footer-copyright" class="footer-copyright">
    <div class="container">
        <div class="payment-method">
        </div>
    </div>
</div>
<!-- icon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script src="dist/js/e-commerce/app.min.js"></script>

<script type="text/javascript" src="https://cdn.omise.co/omise.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/smartwizard/4.3.1/js/jquery.smartWizard.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/css/jquery.dataTables.min.css"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs4/3.2.2/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-responsive/2.2.3/dataTables.responsive.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive-bs4/2.5.0/responsive.bootstrap4.min.js">
</script>
<script src="dist/js/demo/table-manage-default.demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.21/dist/sweetalert2.all.min.js"></script>
<script>
 Omise.setPublicKey("pkey_test_5r0gn5997jah59d6ns1");

let cartObject = JSON.parse(localStorage.getItem('items')) || [];
let cartGroupadmin = [];

const payOmise = () => {
    var form = document.querySelector('form[action="process_checkout.php"]');
    let amount = parseFloat($('input[name="amount"]').val()) * 100; // แปลงเป็น satangs

    if (amount < 2000) {
        alert('จำนวนเงินต้องไม่น้อยกว่า 20 บาท (2000 satangs)');
        return;
    }

    let mm = parseInt($('input[name="mm"]').val());
    let yy = parseInt($('input[name="yy"]').val());
    let cardHolder = $('input[name="cardHolder"]').val();
    let cardNumber = $('input[name="cardNumber"]').val();
    let securityCode = parseInt($('input[name="securityCode"]').val());
    let bank = $('input[name="bank"]:checked').val();
    let slipFile = document.querySelector('input[name="slip"]').files[0];

    // ตรวจสอบข้อมูลการชำระเงิน
    if (!mm || mm < 1 || mm > 12) {
        alert('กรุณากรอกเดือนในรูปแบบที่ถูกต้อง');
        return;
    }

    if (!slipFile) {
        alert('กรุณาแนบสลิปการโอนเงิน');
        return;
    }

    // เพิ่มฟังก์ชันสำหรับดึงข้อมูลสลิป
    const getSlipData = () => {
        let slipFile = document.querySelector('input[name="slip"]').files[0];
        if (slipFile) {
            // ทำสิ่งที่คุณต้องการกับ slipFile ที่ถูกเลือกที่นี่
            console.log('ชื่อไฟล์: ' + slipFile.name);
            console.log('ประเภทไฟล์: ' + slipFile.type);
            console.log('ขนาดไฟล์: ' + slipFile.size + ' ไบต์');
        }
    }

    // สร้าง Token จาก Omise
    let tokenParameters = {
        "expiration_month": mm,
        "expiration_year": yy,
        "name": cardHolder,
        "number": cardNumber,
        "security_code": securityCode,
        "amount": amount
    };

    Omise.createToken("card", tokenParameters, function(statusCode, response) {
        if (statusCode === 200) {
            // เมื่อได้รับ Token สำเร็จ
            const newCartObject = JSON.parse(localStorage.getItem('items')) || [];

            // นับราคารวมของสินค้าในตะกร้า
            const totalPrice = newCartObject.reduce((a, b) => a + b.price * b.qty, 0);

            // กำหนดค่าในฟอร์ม
            form.items.value = JSON.stringify(cartGroupadmin);
            form.amount.value = totalPrice * 100; // แปลงเป็น satangs
            form.omiseToken.value = response.id;

            // ส่งฟอร์มไปยัง process_checkout.php
            form.submit();
        } else {
            // เมื่อไม่สามารถสร้าง Token ได้
            alert('ไม่สามารถสร้าง Token ได้ กรุณาตรวจสอบข้อมูลบัตรเครดิตอีกครั้ง');
        }
    });
}


    const groupadmin = (newCartObject) => {
        cartGroupadmin = [];
        newCartObject.map((item) => {
            let checkItem = cartGroupadmin.find((x) => x.key == item.admin)
            if (checkItem) {
                checkItem.order = [...checkItem.order, item]
                cartGroupadmin.map((x) => x.admin === item.admin ? checkItem : x);
            } else {
                const newItem = {
                    key: item.admin,
                    shop: item.shop,
                    order: [item]
                }
                cartGroupadmin = [...cartGroupadmin, newItem];
            }
        })
    }
    const renderCountCart = () => {
        const cartObject = JSON.parse(localStorage.getItem('items')) || [];
        $(".dropdown-cart .header-cart span.total").html(cartObject.reduce((a, b) => a + b.qty, 0));
        $(".dropdown-cart .cart-header .cart-title").html(
            `ตะกร้าสินค้า (${cartObject.reduce((a, b)=> a + b.qty, 0)})`);
        $(".dropdown-cart .cart-body .cart-item").html("");
        if (cartObject.length <= 0) {
            $(".dropdown-cart .cart-body .cart-item").append(`<h5 class="text-center">ตะกร้าสินค้าว่าง</h5>`);
        } else {
            const cartObjectLimit = cartObject.slice(0, 5)
            cartObjectLimit.map((item) => {
                $(".dropdown-cart .cart-body .cart-item").append(`
                                    <li>
                                        <div class="cart-item-image"><img src="${item.img}" onError="#"/></div>
                                        <div class="cart-item-info">
                                            <h4>${item.name}</h4>
                                            <p class="price">
                <span class="item-price">${parseFloat(item.price).toLocaleString('en-US', {minimumFractionDigits: 0, maximumFractionDigits: 0})} ฿</span>
                <span class="pull-right">x ${item.qty}</span>
            </p>
                                        </div>
                                        <div class="cart-item-close">
                                            <a data-toggle="tooltip" onclick="removeItemMiniCart(${item.id})">&times;</a>
                                        </div>
                                    </li>
                                `);
            })
        }
    }
    const renderCart = () => {
        const cartObject = JSON.parse(localStorage.getItem('items')) || [];
        groupadmin(cartObject)
        $(".table-cart").html("")
        $(`#cart-item-*`).html("")
        if (cartObject.length <= 0) {
            $(".table-cart").append(
                `<tr> <th scope="row" colspan="5" class="text-center">ตะกร้าของคุณว่าง กรุณาสั่งซื้อสินค้า</th> </tr>`
            );
            $("button.sw-btn-next").hide();
        } else {
            $("button.sw-btn-next").show();
            cartGroupadmin.map((admin) => {
                $(".table-cart").append(`
                                    <thead id="cart-head">
                                        <tr>
                                        <th>รูปสินค้า&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ชื่อสินค้า</th>
                                            <th class="text-center">ราคา</th>
                                                <th class="text-center">จำนวน</th>
                                                <th class="text-center">รวม</th>
                                                <th class="text-center" style="white-space: nowrap;">ตัวเลือก</th>
                                        </tr>
                                    </thead>
                                `);
                $(".table-cart").append(`<tbody id="cart-item-${admin.key}">`)
                admin.order.map((item) => {
                    $(`#cart-item-${admin.key}`).append(`
                                        <tr>
                        <td class="cart-product">
                            <div class="product-img" style="width: 5rem;">
                                <img src="${item.img}" onError="this.src='#'" />
                            </div>
                            <div class="product-info">
                                <div class="title">${item.name}</div>
                                <!-- <div class="desc">Delivers Tue 26/04/2016 - Free</div> -->
                            </div>
                        </td>

                        <td class="cart-price text-center">${item.price}</td>
								<td class="cart-qty text-center">
									<div class="cart-qty-input">
										<a href="#" class="qty-control left disabled" data-id="${item.id}" data-click="decrease-qty" data-target="#qty-${item.id}"><i class="fa fa-minus"></i></a>
										<input type="text" name="qty" value="${item.qty}" class="form-control" id="qty-${item.id}"/>
										<a href="#" class="qty-control right disabled" data-id="${item.id}" data-click="increase-qty" data-target="#qty-${item.id}"><i class="fa fa-plus"></i></a>
									</div>
                        </td>
                    <td id="cart-total-${item.id}" class="cart-total text-center">
                            ${item.price * item.qty}฿
                        </td>

                        <td class="cart-actions text-center">
                            <div class="qty-desc" style="cursor: pointer;" onclick="removeItemCart(${admin.key}, ${item.id})">
                                <i class="fas fa-trash-alt"></i> <!-- ไอคอนถังขยะ -->
                            </div>
                        </td>
                    </tr>
                `);
                })
                $(".table-cart").append(`</tbody>`)
            })
            $(".table-cart").append(`
                    <tbody id="cart-item">
                <tr>
                <td class="cart-summary" colspan="7">
                    <div class="summary-container">
                    <div class="summary-row total" style="border-top: 0px; margin-top: 0;">
                        <div class="field"></div>
                        <div class="field">รวมทั้งหมด</div>   
                        <div class="field"></div>
                        <div class="field"></div>
                        <div class="value">${cartObject.reduce((a, b)=> a + b.price * b.qty, 0)+"฿"}</div>
                    </div>
                </td>
                </tr>
            </tbody>
            `);
        }
    }
    const addCart = (admin, shop, id, name, price, img) => {
        const checkItem = cartObject.find((x) => x.id === id);
        if (checkItem) {
            checkItem.qty = parseInt(checkItem.qty) + 1;
            cartObject.map((x) => x.id === id ? checkItem : x);
        } else {
            cartObject = [...cartObject, {
                admin,
                shop,
                id,
                name,
                price,
                qty: 1,
                img
            }];
        }
        localStorage.setItem("items", JSON.stringify(cartObject));
        renderCountCart();
    }
    const removeItemMiniCart = (id) => {
        cartObject = cartObject.filter((x) => x.id !== id)
        localStorage.setItem("items", JSON.stringify(cartObject));
        renderCountCart();
    }
    const removeItemCart = (admin, id) => {
        cartObject = cartObject.filter((x) => x.id !== id)
        localStorage.setItem("items", JSON.stringify(cartObject));
        const newCartObject = JSON.parse(localStorage.getItem('items')) || [];
        groupadmin(newCartObject)
        renderCart();
        renderCountCart();
    }
    renderCart();
    renderCountCart();
</script>
<script>
    function getSlipData() {
        const slipInput = document.querySelector('input[name="slip"]');
        const fileName = slipInput.files[0].name;                               
        // แสดงชื่อไฟล์ที่เลือก
        alert("คุณได้แนบไฟล์: " + fileName);

        // เรียกใช้งานฟังก์ชันที่ส่งข้อมูลไปยังฝั่งเซิร์ฟเวอร์
        uploadSlip();
    }

    // ฟังก์ชันสำหรับอัปโหลดสลิปไปยังเซิร์ฟเวอร์
    function uploadSlip() {
        const slipInput = document.querySelector('input[name="slip"]');
        const slipFile = slipInput.files[0];

        // สร้าง FormData เพื่อส่งไฟล์ไปยังฝั่งเซิร์ฟเวอร์
        const formData = new FormData();
        formData.append('slip', slipFile);

        // ใช้ AJAX ส่งไฟล์ไปยังฝั่งเซิร์ฟเวอร์
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'upload.php'); // แก้ไขเป็น URL ของไฟล์ที่จะรับไฟล์

        
        // หลังจากส่งไฟล์แล้ว
        xhr.onload = function() {
            if (xhr.status === 200) {
                // การส่งไฟล์สำเร็จ
                // แสดงข้อความหรือทำอย่างอื่นตามที่คุณต้องการ
               
            } else {
                // เกิดข้อผิดพลาดในการส่งไฟล์
                alert("เกิดข้อผิดพลาดในการส่งไฟล์");
            }
        };
        // ส่ง FormData
        xhr.send(formData);
    }
</script>

<script src="dist/js/demo/form-wizards-validation.checkout.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>
<script>
    $(".multiple-select2").select2({
        placeholder: "กรุณาเลือกสัตว์เลี้ยงของคุณ (สามารถเลือกได้หลายประเภท)"
    });
</script>
<script>
    const updateUserFullname = () => {
        const userFullnameElement = document.getElementById('userFullname');
        const cartObject = JSON.parse(localStorage.getItem('items')) || [];
        const totalPrice = cartObject.reduce((a, b) => a + b.price * b.qty, 0);

        // แปลงราคาเป็นตัวเลขแบบทศนิยม 2 ตำแหน่ง
        const totalPriceFormatted = parseFloat(totalPrice).toLocaleString('en-US', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 2
        });

        userFullnameElement.value = totalPriceFormatted + " ฿";
    }

    // เรียกใช้ฟังก์ชันเมื่อหน้าเว็บโหลด
    updateUserFullname();

    // อัปเดตราคารวมโดยตบอดเวลาทุก 5 วินาที
    setInterval(updateUserFullname, 1000); // 5000 มิลลิวินาที = 5 วินาที
</script>
<script>
    // ปุ่มแสดงรูปภาพสลิป
    var showSlipButton = document.getElementById("showSlipButton");
    // หน้าต่างแสดงรูปภาพสลิป
    var slipModal = document.getElementById("slip-modal");
    // ปุ่มปิดสลิป
    var closeSlipButton = document.getElementById("closeSlipButton");
    // รูปภาพสลิป
    var slipImage = document.getElementById("slip-image");

    // เมื่อคลิกที่ปุ่มแสดงรูปภาพสลิป
    showSlipButton.onclick = function() {
        // แสดงหน้าต่างแสดงรูปภาพสลิป
        slipModal.style.display = "block";
        // ใส่ URL รูปภาพสลิปที่คุณต้องการแสดง
        slipImage.src = "slip";
    }

    // เมื่อคลิกที่ปุ่มปิดสลิป
    closeSlipButton.onclick = function() {
        // ปิดหน้าต่างแสดงรูปภาพสลิป
        slipModal.style.display = "none";
    }
</script>
</body>

</html>

</style>
<div class="bg-white shadow-sm"><br>
    <div class="container-fluid">
        <section class="footer-top padding-y">
            <div class="row">
                <aside class="col-md-4" style="margin-top: -29px;">
                    <article class="mr-8 order-first">
                        <div style="display: flex; align-items: center; flex-direction: column;">
                            <a href="https://champ.itsvc.dev">
                                <img src="https://media.discordapp.net/attachments/1120961499196821596/1141926367336865852/logo.webp" class="img-fluid" style="max-width: 100px; height: auto;" alt="โลโก้ A&P">
                            </a>
                            <div class="description" style="margin-top: 10px;">
                                <span style="font-size: 16px; display: flex; align-items: center;">
                                    <i class='bx bxs-phone-call bx-md'></i>
                                    <div style="margin-left: 5px;">
                                        ติดต่อสอบถาม<br>
                                        โทร081-894-6364
                                    </div>
                                </span><br>
                                <b class="mt-3" style="font-size: 16px; margin-top: 10px;">
                                    บริษัทขายเครื่องกรองน้ำ A & P
                                </b>
                                <p class="mt-3" style="font-size: 16px; margin-top: 10px;">
                                    104/641 หมู่3 ถนน พ่อขุนทะเล ตำบล มะขามเตี้ย อำเภอเมือง <br>จังหวัด สุราษฎร์ธานี
                                </p>
                            </div>
                        </div>
                    </article>
                </aside>

                <aside class="col-sm-5 col-md-3">
                    <h5 class="title">สินค้า</h5>
                    <ul class="list-unstyled">
                        <li><a href="product.php" data-abc="true">สินค้าทั้งหมด</a></li>
                        <li><a href="product.php" data-abc="true">สินค้าเครื่องกรองนํ้า</a></li>
                    </ul>
                </aside>
                <aside class="col-sm-5 col-md-3">
                    <h5 class="title">บริการช่วยเหลือ</h5>
                    <ul class="list-unstyled">
                        <li><a href="Terms_conditions.php" data-abc="true" aria-label="เงื่อนไขการแก้ไข">ข้อกำหนดและเงื่อนไข</a></li>
                        <li><a href="Privacy_Policy.php" data-abc="true" aria-label="นโยบายส่วนบุคคล">นโยบายส่วนบุคคล</a></li>
                        <li><a href="howtopayment.php" data-abc="true">ช่องทางการชําระเงิน</a></li>
                    </ul>
              

            </div>
            </output>
        </section>
        <br>

    </div>
</div>
<script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js'>
</script>
<script type='text/javascript' src='#'></script>
<script type='text/javascript' src='#'></script>
<script type='text/javascript' src='#'></script>
<script type='text/javascript' src='#'></script>
<script type='text/javascript'>
    var myLink = document.querySelector('a[href="#"]');
    myLink.addEventListener('click', function(e) {
        e.preventDefault();
    });
</script>

</body>

</html>