<?php 
function db_con()
{
    $db_status = 1;
    if ($db_status == 1) {
        $dbHost = 'localhost'; // โฮสต์ฐานข้อมูล
        $dbName = 'test'; // ชื่อฐานข้อมูล
        $dbUser = 'root'; // ชื่อผู้ใช้ของฐานข้อมูล
        $dbPass = ''; // รหัสผ่านของฐานข้อมูล
    } else {
        $dbHost = "127.0.0.1";
        $dbName = "dbnqpjg8oxxuyj";
        $dbUser = "up0pykdpcofgq";
        $dbPass = "bggssjm1cg4b";

    }

    try {
        $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $e->getMessage());
    }
}
function con_line()
{
    $channelAccessToken = 'qmZWvnRccYyE5GM1lzSoQVX5uI6B/jhwloFAZrh1ZYphEsQ66x92TLy1VxIenqxas9maolOVqbGiVsVzLasnJWREX7h94gScVBPDwLlb9HxReAGy2T2eol0tFiMN2UL4DqpPYWLgR2ldwbB0oMZ4FwdB04t89/1O/w1cDnyilFU=';
    return $channelAccessToken;
}
function checkOrderInDatabase($orderNumber) {
    try {
        $pdo = db_con();
        $sql = "SELECT * FROM orders WHERE orderNumber = :orderNumber";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':orderNumber', $orderNumber, PDO::PARAM_INT);
        $stmt->execute();
        $result = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $row;
        }
        $pdo = null;

        // ตรวจสอบว่า $result ไม่มีข้อมูล และส่งค่า true กลับ
        if (empty($result)) {
            return true;
        }

        return $result;

    } catch (PDOException $e) {
        saveLog("เกิดข้อผิดพลาดในการค้นหาข้อมูล: " . $e->getMessage());
        return false; // หากเกิดข้อผิดพลาด ส่งค่า null กลับ
    }
}
function checkOrderGetCode($orderNumber) {
    try {
        $pdo = db_con();
        $sql = "SELECT * FROM orders WHERE orderNumber = :orderNumber";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':orderNumber', $orderNumber, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC); // เราใช้ fetch() ในกรณีนี้ เนื่องจากเราคาดหวังแค่บันทึกข้อมูลเดียว

        $pdo = null;

        // ตรวจสอบว่า $result ไม่มีข้อมูล และส่งค่า true กลับ
        if (!$result) {
            return true;
        } else {
            return false; // ส่งข้อมูลที่พบในฐานข้อมูลกลับ
        }

    } catch (PDOException $e) {
        saveLog("เกิดข้อผิดพลาดในการค้นหาข้อมูล: " . $e->getMessage());
        return false; // หากเกิดข้อผิดพลาด ส่งค่า false กลับ
    }
}

function GetCodeInDatabase($product) {
    try {
        $pdo = db_con();
        $sql = "SELECT Username, Password FROM product_account WHERE Product = :Product";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':Product', $product, PDO::PARAM_STR); // คุณอาจต้องเปลี่ยน PDO::PARAM_STR ตามประเภทของข้อมูลในฐานข้อมูลของคุณ
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $pdo = null;
        if (empty($result)) {
            return false; // หากไม่พบข้อมูล
        }
        return $result;
    } catch (PDOException $e) {
        saveLog("เกิดข้อผิดพลาดในการค้นหาข้อมูล: " . $e->getMessage());
        return false; // หากเกิดข้อผิดพลาด
    }
}



function sendFlexMessage($to, $flexMessageJson, $logFilePath)
{
    $url = "https://api.line.me/v2/bot/message/push";

    $headers = [
        "Content-Type: application/json",
        "Authorization: Bearer " . con_line()
    ];

    $data = [
        "to" => $to,
        "messages" => [
            [
                "type" => "flex",
                "altText" => "This is a Flex Message",
                "contents" => json_decode($flexMessageJson, true)
            ]
        ]
    ];

    $dataJson = json_encode($data);

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    saveLog('Respone Send Flex message : ' .$response);
    $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpStatus === 200) {
        // บันทึกผลลัพธ์ลงในไฟล์ log
        saveLog("การส่ง Flex Message สำเร็จ");
        return true; // ส่ง Flex Message สำเร็จ
    } else {
        // บันทึกผลลัพธ์ลงในไฟล์ log
        saveLog("การส่ง Flex Message ไม่สำเร็จ");
        return false; // การส่ง Flex Message ไม่สำเร็จ
    }
}
function saveLog($message) {
    $logFilePath = '../api/log/function.txt';
    // กำหนดรูปแบบของข้อความ log ที่ต้องการเก็บ
    $logMessage = date('Y-m-d H:i:s') . " - " . $message . "\n";

    file_put_contents($logFilePath, $logMessage, FILE_APPEND);
}
function updateStatus ($idToUpdate) {
    $pdo = db_con();
    $sql = "UPDATE payment_notifications SET status = 1 WHERE id = :id";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $idToUpdate, PDO::PARAM_INT);
        $stmt->execute();
        $response = ['status' => 'success', 'message' => 'อัปเดตสถานะสำเร็จ'];
    } catch (PDOException $e) {
        $response = ['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการอัปเดตสถานะ: ' . $e->getMessage()];
    }

    return $response;
}
function saveOrderToDatabase($orderNumber, $status, $skuList, $userId, $DisplayName, $Image, $Products) {
    $separator = ', '; // กำหนดตัวแยก

    $sql = "INSERT INTO orders (code, status, orderNumber, userId, image, name, skuList, productList) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $pdo = db_con(); 

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $orderNumber);
        $stmt->bindParam(2, $status);
        $stmt->bindParam(3, $orderNumber);
        $stmt->bindParam(4, $userId);
        $stmt->bindParam(5, $Image);
        $stmt->bindParam(6, $DisplayName);

        // แปลง skuList และ Products ให้เป็นสตริง
        $skuListString = implode($separator, $skuList);
        $ProductsString = implode($separator, $Products);

        $stmt->bindParam(7, $skuListString);
        $stmt->bindParam(8, $ProductsString);

        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        $errorInfo = $stmt->errorInfo();
        echo 'PDO Error: ' . $errorInfo[2]; // แสดงข้อความข้อผิดพลาด
        return false;
    }
}
function check_Login($username, $password) {
    $pdo = db_con();
    $sql = "SELECT * FROM Admin WHERE username = :username AND password = :password";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // พบผู้ใช้ที่เข้าสู่ระบบ
        return true;
    } else {
        // ไม่พบผู้ใช้หรือรหัสผ่านไม่ถูกต้อง
        return false;
    }
}


?>