
const siteUrl = 'https://ttomoru.com/New_Line_login/api/';
const woo_Url = 'https://ttomoru.com/'
const consumerKey = 'ck_f1eb560f3debd10be97364033674d70ad952cf37';
const consumerSecret = 'cs_bbc60032615a5319a2133590fa662758d4b55b12';


function loadOrders() {
    let orderData = {
        Code: 'GetAllOrder',
    };
    const orderStatus = 'on-hold'; // เปลี่ยนเป็นสถานะที่คุณต้องการ
    const apiUrl = `${siteUrl}`;
    const requestOptions = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(orderData)
    };
    fetch(apiUrl, requestOptions)
        .then(function (response) {
            if (response.status === 200) {
                return response.json();
            } else {
                throw new Error('เกิดข้อผิดพลาดในการดึงรายการ Order');
            }
        })
        .then(function (responseData) {
            const data = responseData.data;
            data.forEach(function (order) {
                var existingRow = document.getElementById('row-' + order.id);
                if (!existingRow) {
                    var newRow = document.createElement('tr');
                    newRow.id = 'row-' + order.id;

                    // สร้างตัวแปรเพื่อเก็บรายการสินค้าทั้งหมดเป็น HTML
                    var orderListHTML = '<ul>'; // เปิดรายการ ul
                    order.line_items.forEach(item => {
                        orderListHTML += `<li>${item.name} (จำนวน: ${item.quantity})</li>`;
                    });
                    orderListHTML += '</ul>'; // ปิดรายการ ul
                    var imageHTML = order.line_items.map(item => `<img src="${item.image.src}" class="avatar avatar-sm me-3 product_img">`).join(' + ');
                    // คำนวณราคารวมของสินค้า
                    var totalAmount = 0;
                    order.line_items.forEach(function (item) {
                        totalAmount += parseFloat(item.price) * parseInt(item.quantity);
                    });
                    newRow.innerHTML = `
                <td class="text-center">
                    ${orderListHTML} <!-- เพิ่มรายการสินค้าที่สร้างขึ้นด้านบน -->
                </td>
                <td class="text-center">
                ${imageHTML}
            </td>
                <td class="text-center">${order.id}</td>
                <td class="text-center">${order.line_items[0].sku}</td>
                <td class="text-center">${totalAmount.toFixed(2)}</td>
                <td class="text-center">${order.billing.first_name} ${order.billing.last_name}</td>
                <td class="text-center">
    <button type="button" class="btn btn-success bg-gradient-info active" id="order-btn-${order.id}-approve" onclick="UpdateOrder(${order.id},'completed')">
        อนุมัติ
    </button>
    <button type="button" class="btn bg-gradient-danger btn-danger active" id="order-btn-${order.id}-cancel" onclick="UpdateOrder(${order.id},'cancelled')">
        ยกเลิก
    </button>
</td>
            `;

                    var tableBody = document.getElementById('table-body');
                    tableBody.appendChild(newRow);
                }
            });
        })

}
function disableAllButtons() {
    const allButtons = document.querySelectorAll('[id^="order-btn"]');
    allButtons.forEach(button => {
        button.disabled = true;
    });
}

function enableButton(orderId) {
    const approveButton = document.getElementById(`order-btn-${orderId}-approve`);
    const cancelButton = document.getElementById(`order-btn-${orderId}-cancel`);
    approveButton.classList.add('btn-disabled');
    cancelButton.classList.add('btn-disabled');
    
    if (approveButton) {
        approveButton.disabled = false;
    }
    
    if (cancelButton) {
        cancelButton.disabled = false;
    }
}
function UpdateOrder(orderId, Status) {
    disableAllButtons();
    const apiUrl = `${woo_Url}wp-json/wc/v3/orders/${orderId}`;
    let orderData = {
        status: Status
    };
    // ส่งคำขอ PUT เพื่ออนุมัติ Order ด้วย WooCommerce REST API
    fetch(apiUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        headers: {
            'Authorization': 'Basic ' + btoa(`${consumerKey}:${consumerSecret}`), // แทนค่า your_api_key และ your_api_secret ด้วยข้อมูลของคุณ
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(orderData),
    })
        .then(function (response) {
            if (response.status === 200) {
                console.log(response)
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000, // รีโหลดหน้าเว็บหลังจาก 3 วินาที
                    timerProgressBar: true,
                    didOpen: (toast) => {
                      toast.addEventListener('mouseenter', Swal.stopTimer)
                      toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                  })
                  
                  Toast.fire({icon: 'success',title: `${Status} Order สำเร็จ`})
                  .then(() => { enableButton(orderId); window.location.reload();}) 
            } else {
                throw new Error('เกิดข้อผิดพลาดในการอนุมัติ Order');
            }
        })
        .catch(function (error) {
            console.error(error);
        });
}

function Product_Code() {
    let orderData = {
        Code: 'acc-code',
    }; 

    fetch(`${siteUrl}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(orderData), // ส่ง orderData ที่มี Code: 'Payment'
    })
        .then(response => response.json())
        .then(responseData => {
            // เรียกใช้ฟังก์ชันสร้างตาราง
            buildProduct_Code(responseData.data)
        })
        .catch(error => {
            console.error('เกิดข้อผิดพลาดในการ POST ข้อมูล:', error);
        });
}
function postData() {
    let orderData = {
        Code: 'Payment',
    }; 

    fetch(`${siteUrl}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(orderData), // ส่ง orderData ที่มี Code: 'Payment'
    })
        .then(response => response.json())
        .then(responseData => {
            // เรียกใช้ฟังก์ชันสร้างตาราง
            buildTable(responseData.data);
        })
        .catch(error => {
            console.error('เกิดข้อผิดพลาดในการ POST ข้อมูล:', error);
        });
}

function buildTable(data) {
    console.log('data: ', data);
    const tableBody = document.getElementById('tableBody');

    if (tableBody !== null) {
        data.forEach(rowData => {
            // ตรวจสอบว่าแถวที่มี ID นี้ยังไม่มีอยู่ในตาราง
            const existingRow = document.querySelector(`#tableBody tr#row-${rowData.id}`);
            if (!existingRow && rowData.status !== 1) {
                const row = document.createElement('tr');
                row.id = `row-${rowData.id}`;
                row.innerHTML = `
                    <td class="text-center">${rowData.id}</td>
                    <td class="text-center">${rowData.purchase_order}</td>
                    <td class="text-center">${rowData.name_surname}</td>
                    <td class="text-center">${rowData.total}</td>
                    <td class="text-center"><img class="img-slip" src="https://ttomoru.com/${rowData.payment_slip_path}"></td>
                    <td class="text-center"><button type="button" id="btn-${rowData.id}" class="btn btn-info" onclick="UpdateStatus(${rowData.id})">ตรวจสอบเรียบร้อย</button></td>
                `;
                tableBody.appendChild(row);
            }
        });
    } else {
        console.error("ไม่พบอิลิเมนต์ที่มี 'id=tableBody'");
    }
}

function buildProduct_Code(data) {
    const tableBody = document.getElementById('tableBody');
    if (tableBody !== null) {
        data.forEach(rowData => {
            const existingRow = document.querySelector(`#tableBody tr#row-${rowData.ID}`);
            if (!existingRow) {
                const row = document.createElement('tr');
                row.id = `row-${rowData.ID}`;

                // Check if Stock is 0
                if (rowData.Stock === 0) {
                    // If Stock is 0, show a small notification and hide the value
                    const notification = document.createElement('span');
                    notification.classList.add('badge', 'bg-danger', 'text-white');
                    notification.innerText = 'สินค้าหมด';
                    row.innerHTML = `
                        <td class="text-center">${rowData.ID}</td>
                        <td class="text-center">${rowData.Product}</td>
                        <td class="text-center">${rowData.Username}</td>
                        <td class="text-center">${rowData.Password}</td>
                        <td class="text-center"></td>  <!-- Leave this cell empty for 0 stock products -->
                        <td class="text-center">${rowData.UpdatedAt}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger" onclick="DeleteCode(${rowData.ID})">ลบ</button>
                        </td>
                    `;
                    row.querySelector('td:nth-child(5)').appendChild(notification);
                } else {
                    // If Stock is not 0, show the value
                    row.innerHTML = `
                        <td class="text-center">${rowData.ID}</td>
                        <td class="text-center">${rowData.Product}</td>
                        <td class="text-center">${rowData.Username}</td>
                        <td class="text-center">${rowData.Password}</td>
                        <td class="text-center">${rowData.Stock}</td>
                        <td class="text-center">${rowData.UpdatedAt}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger" onclick="DeleteCode(${rowData.ID})">ลบ</button>
                        </td>
                    `;
                }

                tableBody.appendChild(row);
            }
        });
    } else {
        console.error("ไม่พบอิลิเมนต์ที่มี 'id=tableBody'");
    }
}

function DeleteCode(id) {
    const data = {
        Code: 'del_code',
        ID: id
    };
    const jsonData = JSON.stringify(data);

    fetch(`${siteUrl}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: jsonData
    })
    .then(response => response.json())
    .then(responseData => {
        if (responseData.status === true) {
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                text: 'ข้อมูลถูกลบเรียบร้อย',
            }).then(() => {
                // หลังจากกด OK ใน Sweetalert ให้รีโหลดหน้า
                location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด!',
                text: 'ไม่สามารถลบข้อมูลได้',
            });
        }
    })
    .catch(error => {
        console.error('เกิดข้อผิดพลาดในการลบข้อมูล:', error);
    });
}


function UpdateStatus(id) {
    const button = document.getElementById(`btn-${id}`);
    const updateData = {
        Code: 'SlipStatus',
        ID: id
    };

    fetch(`${siteUrl}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(updateData)
    })
        .then(response => {
            if (response.status) {
                button.innerText = "✅";
                console.log(response.message)
                setTimeout(function () {
                    location.reload();
                }, 3000);
            } else {
                console.error('เกิดข้อผิดพลาดในการอัปเดตสถานะ');
            }
        })
        .catch(error => {
            console.error(error);
        });
}
document.getElementById('FormCreate').addEventListener('submit', function (e) {
    e.preventDefault(); 
    
    const productnameValue = document.getElementById('productname').value;
    const emailValue = document.getElementById('email').value;
    const passwordValue = document.getElementById('password').value;
    const data = {
        Code: 'put-acc-code',
        productname: productnameValue,
        email: emailValue,
        password: passwordValue
    };
    
    const jsonData = JSON.stringify(data);
    console.log(jsonData)
    fetch(`${siteUrl}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: jsonData
    })
    .then(response => response.json())
    .then(data => {
        // ตรวจสอบ Status ที่ตอบกลับจาก Backend
        if (data.status === true) {
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                text: 'ข้อมูลถูกบันทึกเรียบร้อย',
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด!',
                text: 'ไม่สามารถบันทึกข้อมูลได้',
            }).then(() => {
                location.reload();
            });
        }
        console.log(data);
    })
    .catch(error => {
        console.error('เกิดข้อผิดพลาดในการส่งข้อมูล:', error);
    });
});

function fetchPackages() {
    const data = {
        Code: 'GetAllProducts',
    };
    const jsonData = JSON.stringify(data);
    const productnameInput = document.getElementById('productname');
    
    // ล้างเนื้อหาใน dropdown เดิม (ถ้ามี)
    productnameInput.innerHTML = ''; 
    
    // เพิ่มตัวเลือกแรก (option) เป็นค่าเริ่มต้น
    const defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.text = 'เลือก Productname';
    productnameInput.appendChild(defaultOption);

    fetch(`${siteUrl}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: jsonData
    })
    .then(response => response.json())
    .then(responseData => {
        console.log(responseData); 
        if (!responseData.status) {
            throw new Error('เกิดข้อผิดพลาดในการดึงข้อมูลหมวดหมู่สินค้า');
        }

        // สร้างเซ็ตเพื่อเก็บชื่อ Product ที่มีอยู่ในตาราง
        const existingProducts = new Set();
        const tableRows = document.querySelectorAll('#tableBody tr');
        tableRows.forEach(row => {
            const productNameCell = row.querySelector('td:nth-child(2)');
            if (productNameCell) {
                existingProducts.add(productNameCell.textContent.trim());
            }
        });

        responseData.data.forEach(product => {
            const productName = product.name;
            if (!existingProducts.has(productName)) {
                const option = document.createElement('option');
                option.value = productName;
                option.text = productName;
                productnameInput.appendChild(option);
            }
        });
        
    })
    .catch(error => {
        console.error('เกิดข้อผิดพลาดในการดึง Package:', error);
    });
}