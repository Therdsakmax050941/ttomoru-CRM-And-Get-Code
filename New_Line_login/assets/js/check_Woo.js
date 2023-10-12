const config = {
    api: 'https://ttomoru.com/New_Line_login/api/index.php'
}
const urlParams = new URLSearchParams(window.location.search);
const consumerKey = 'ck_f1eb560f3debd10be97364033674d70ad952cf37';
const consumerSecret = 'cs_bbc60032615a5319a2133590fa662758d4b55b12';
const siteUrl = 'https://ttomoru.com';
const orderId = urlParams.get('orderID');
const sub = urlParams.get('userId');
const image = urlParams.get('pictureUrl');
const DisplayName = urlParams.get('name');

const orderData = {
    Code: 'SendCode',
    status: null,
    orderNumber: orderId,
    skuList: [],
    product: [],
    UserId: sub,
    Image: image,
    Name: DisplayName
};
// เลือกปุ่ม "btnConfirm"
const btnConfirm = document.getElementById('btnConfirm');
const statusLabel = document.getElementById('status');
const orderListElement = document.getElementById('order_list');
btnConfirm.disabled = true;
// สร้างคำขอ API
fetch(`${siteUrl}/wp-json/wc/v3/orders/${orderId}?consumer_key=${consumerKey}&consumer_secret=${consumerSecret}`)
    .then(response => response.json())
    .then(data => {
        // เข้าถึง SKU ของสินค้าในออร์เดอร์
        const orderStatus = data.status;
        const lineItems = data.line_items;
        if (lineItems && lineItems.length > 0) {
            lineItems.forEach(item => {
                const sku = item.sku;
                const product = item.name;
                orderData.skuList.push(sku);
                orderData.product.push(product);
                //console.log('sku1: ', sku);
                return sku;
            });
            //console.log('Product Name',Product);
            orderData.status = orderStatus;
            // สร้าง HTML สำหรับรายการสินค้า
            let orderListHTML = '<ul>';
            lineItems.forEach(item => {
                orderListHTML += `<li>${item.name} (จำนวน: ${item.quantity})</li>`;
            });
            orderListHTML += '</ul>';
            orderListElement.innerHTML = orderListHTML;

        } else {
            console.log('ไม่พบข้อมูลสินค้าในออร์เดอร์');
        }
        console.log('DataAll-Order', lineItems);

        if (orderData.status === 'completed') {
            statusLabel.style.color = 'green';
            statusLabel.textContent += 'การสั่งซื้อสำเร็จ';

            // ตรวจสอบสต็อกและปิดปิดปุ่มตามผลตรวจสอบ
            checkAlreadyGetCode(orderData.skuList,orderData.orderNumber)
        } else if (orderData.status === 'on-hold') {
            statusLabel.style.color = 'blue';
            statusLabel.textContent += 'กำลังตรวจสอบ';
        } else {
            statusLabel.style.color = 'red'; // สีแดงสำหรับสถานะอื่น ๆ
            statusLabel.textContent += 'ไม่พบออเดอร์ของคุณ';
            // Crate Delay to go this link
            setTimeout(() => {
                window.location.href = `https://ttomoru.com/my-account/`;
            })
        }
    })
    .catch(error => console.error('เกิดข้อผิดพลาด: ' + error));
    
function checkAlreadyGetCode(DataSku, orderNumber) {
    const apiUrl = `${config.api}`; // เปลี่ยนเป็น URL ของ API ของคุณ
    const requestData = {
        Code: 'CheckOrderStatus',
        orderNumber: orderNumber
    };

    fetch(apiUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(requestData)
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === true) {
                btnConfirm.disabled = true;
                Swal.fire({
                    icon: 'warning',
                    title: 'รับรหัสไปแล้ว',
                    text: 'คุณได้รับรหัสนี้ไปแล้ว หากยังไม่ได้รับโปรดติดต่อแอดมิน'
                })
               .then(() => {
                    window.location.href = `https://ttomoru.com/my-account/`;
               });
            } else {
                checkStockAndToggleButton(DataSku);
            }
        })
        .catch(error => {
            console.error('เกิดข้อผิดพลาด: ' + error);
        });
}

// เพิ่ม event listener สำหรับปุ่ม "btnConfirm"
btnConfirm.addEventListener('click', function () {

    if (orderData.status === 'completed') {
        sendOrderDataToAPI(orderData);
        console.log(orderData);
    } else {
        console.log('ไม่สามารถส่งข้อมูลได้เนื่องจากสถานะไม่ใช่ "completed"');
    }
    btnConfirm.disabled = true;
});

// ฟังก์ชันสำหรับส่งข้อมูลไปยัง https://ttomoru.com/api/ ในรูปแบบ POST
function sendOrderDataToAPI(data) {
    // สร้างออบเจ็กต์สำหรับการส่งข้อมูล
    const requestOptions = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    };

    // ทำการส่งข้อมูลไปยัง https://ttomoru.com/api/
    fetch(config.api, requestOptions)
        .then(response => response.json())
        .then(responseData => {

            if (responseData.status) {
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ!',
                    text: 'ส่งรหัสสำเร็จ'
                })
               .then(() => {
                    window.location.href = `https://ttomoru.com/my-account/`;
               });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด!',
                    text: 'ไม่สามารถส่งรหัสได้'
                });
                btnConfirm.disabled = true;
            }
        })
        .catch(error => {
            console.error('เกิดข้อผิดพลาดในการส่งข้อมูล:', error);
        });
}
async function checkStockAndToggleButton(skuList) {
    try {
        // เรียกใช้ WooCommerce API เพื่อตรวจสอบสต็อกของ SKU ทั้งหมดในรายการ
        let promises = skuList.map(async sku => {
            let response = await fetch(`${siteUrl}/wp-json/wc/v3/products?sku=${sku}&consumer_key=${consumerKey}&consumer_secret=${consumerSecret}`);
            if (!response.ok) {
                throw new Error('ไม่สามารถดึงข้อมูลสินค้าได้');
            }
            const products = await response.json();
            if (Array.isArray(products) && products.length > 0) {
                // ตรวจสอบว่าสินค้าใน SKU มีสต็อกไม่เท่ากับ 0
                return products.every(product => product.stock_quantity > 0);
            } else {
                console.error(`ไม่พบสินค้าใน SKU: ${sku}`);
                return false;
            }
        });

        // รอให้การร้องขอ API ทั้งหมดเสร็จสิ้นแล้วเก็บผลลัพธ์
        let results = await Promise.all(promises);

        // ตรวจสอบผลลัพธ์และตั้งค่าปุ่มตามผลตรวจสอบ
        const hasStock = results.some(result => result);
        btnConfirm.disabled = !hasStock;
        if (hasStock) {
            console.log('สต็อกมีในสินค้า : ' + skuList);
        } else {
            btnConfirm.textContent = 'Stock หมด';
            console.log('สต็อกสินค้าหมด');
        }
    } catch (error) {
        console.error('เกิดข้อผิดพลาดในการตรวจสอบสต็อก: ' + error.message);
    }
}

