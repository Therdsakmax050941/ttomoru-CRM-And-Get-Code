<?php
function updateStockData() {
    // ทำการเชื่อมต่อกับฐานข้อมูลของคุณ
    $db_host = '127.0.0.1';
    $db_user = 'up0pykdpcofgq';
    $db_pass = 'bggssjm1cg4b';
    $db_name = 'dbnqpjg8oxxuyj';

    // สร้างการเชื่อมต่อ
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // ตรวจสอบการเชื่อมต่อ
    if ($conn->connect_error) {
        die("การเชื่อมต่อกับฐานข้อมูลล้มเหลว: " . $conn->connect_error);
    }

    require_once './woo.php';
    $products = $woocommerce->get('products', ['per_page' => 100]);

    // วนลูปผ่านสินค้าที่ดึงมา
    foreach ($products as $product) {
        $product = $product->name;
        $stock = $product->stock_quantity;

        // คำสั่ง SQL สำหรับอัปเดตข้อมูลสต็อกเฉพาะเมื่อ SKU เท่ากับ Product
        $sql = "UPDATE product_account 
                SET Stock = $stock 
                WHERE SKU = '$product' AND Product = '$product'";

        if ($conn->query($sql) === TRUE) {
            file_put_contents('log.txt', "อัปเดตสต็อกสำเร็จสำหรับ SKU: $product\n", FILE_APPEND); 
        } else {
            echo "เกิดข้อผิดพลาดในการอัปเดตสต็อกสำหรับ SKU: $product - " . $conn->error . "\n";
        }
    }

    // ปิดการเชื่อมต่อกับฐานข้อมูล
    $conn->close();
}

// เรียกใช้ฟังก์ชันเพื่อดึงข้อมูลจาก WooCommerce API และอัปเดตในฐานข้อมูล
updateStockData();
?>
