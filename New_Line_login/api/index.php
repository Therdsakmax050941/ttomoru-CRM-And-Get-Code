<?php
require_once './function.php';
require_once './woo.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $json_data = file_get_contents("php://input");

    $data_ = json_decode($json_data, true);

    if (isset($data_['Code']) && $data_['Code'] === 'SendCode') {

        $orderNumber = $data_['orderNumber'];
        $status = $data_['status'];
        $skuList = $data_['skuList'];
        $userId = $data_['UserId'];
        $DisplayName = $data_['Name'];
        $Image = $data_['Image'];
        $Products = $data_['product'];
        //test data
        $code01 = 'test@gmail.com';
        $code02 = 'test123';
        // สร้างอาเรย์ผลลัพธ์ของข้อมูลกลับ
        $response_data = array(
            'orderNumber' => $orderNumber,
            'status' => $status,
            'Product' => $Products,
            'skuList' => $skuList,
            'UserId' => $userId,
            'Name' => $DisplayName,
            'Image' => $Image,
            'NewOrder' => $result
        );
        $OrderStatus = checkOrderInDatabase($orderNumber);
        //var_dump($result);
        // true ถ้าไม่เจอเลข orderNumber ในDatabase
        if (empty($OrderStatus) || $OrderStatus === true) {
            foreach ($Products as $product) {
                $code = GetCodeInDatabase($product);

                if ($code !== false) {
                    $flexMessageJsonPath = '../assets/flexmessage/sendcode.json';
                    $flexMessageJson = file_get_contents($flexMessageJsonPath);
                    $flexMessageJson = str_replace("รหัสสินค้า: สินค้า", "ชื่อสินค้า :  $product", $flexMessageJson);
                    $flexMessageJson = str_replace("User : myemail", "User : {$code['Username']}", $flexMessageJson);
                    $flexMessageJson = str_replace("Pass : mypassword", "Pass : {$code['Password']}", $flexMessageJson);
                    $flexMessageArray = json_decode($flexMessageJson, true);
                    $encodedJson = json_encode($flexMessageArray);
                    $results_ms = sendFlexMessage($userId, $encodedJson, $logFilePath);
                }
                 else {
                    echo 'ไม่พบข้อมูลสำหรับ Product: ' . $product . '<br>';
                }
            }
            header('Content-Type: application/json');
            if ($results_ms) {
                echo json_encode(['status' => true, 'messsage' => 'ส่งรหัสสำเร็จ']);
                $saveOrder = saveOrderToDatabase($orderNumber, $status, $skuList, $userId, $DisplayName, $Image, $Products);
                exit();
            } else {
                echo json_encode(['status' => false, 'messsage' => 'ส่งรหัสไม่สำเร็จ']);
                exit();
            }
        } else {
            echo json_encode(['status' => false, 'messsage' => 'ออเดอร์นี้ถูกรับรหัสไปแล้ว']);
            exit();
        }
    } elseif (isset($data_['Code']) && $data_['Code'] === 'GetAllOrder') {
        $orders = $woocommerce->get('orders', ['status' => 'on-hold']);
        echo json_encode(['status' => true, 'data' => $orders]);
    } elseif (isset($data_['Code']) && $data_['Code'] === 'GetAllCategories') {
        $categories =  $woocommerce->get('products/categories');
        echo json_encode(['status' => true, 'data' => $categories]);
    } elseif (isset($data_['Code']) && $data_['Code'] === 'GetAllProducts') {
        $products =  $woocommerce->get('products');
        echo json_encode(['status' => true, 'data' => $products]);
    } elseif (isset($data_['Code']) && $data_['Code'] === 'del_code') {
        try {
            $pdo = db_con();

            if (isset($data_['ID'])) {
                $id = $data_['ID'];
                $sql = "DELETE FROM product_account WHERE ID = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    echo json_encode(['status' => true, 'message' => 'ลบข้อมูล  สำเร็จ']);
                } else {
                    echo json_encode(['status' => false, 'message' => 'ไม่พบข้อมูล ที่ต้องการลบ']);
                }
            } else {
                echo json_encode(['status' => false, 'message' => 'ไม่ได้รับค่า ID']);
            }
            $pdo = null;
        } catch (PDOException $e) {
            echo json_encode(['error' => 'การเชื่อมต่อฐานข้อมูลล้มเหลว: ' . $e->getMessage()]);
        }
    } elseif (isset($data_['Code']) && $data_['Code'] === 'Payment') {
        try {
            $pdo = db_con();

            $sql = "SELECT * FROM payment_notifications";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo = null;
            if ($result) {
                echo json_encode(['data' => $result]);
            } else {
                echo json_encode(['message' => 'ไม่พบข้อมูล Payment Notifications']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => 'การเชื่อมต่อฐานข้อมูลล้มเหลว: ' . $e->getMessage()]);
        }
    } elseif (isset($data_['Code']) && $data_['Code'] === 'acc-code') {
        try {
            $pdo = db_con();

            $sql = "SELECT * FROM product_account";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo = null;

            if ($result) {
                echo json_encode(['data' => $result]);
            } else {
                echo json_encode(['message' => 'ไม่พบข้อมูล product_account']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => 'การเชื่อมต่อฐานข้อมูลล้มเหลว: ' . $e->getMessage()]);
        }
    } elseif (isset($data_['Code']) && $data_['Code'] === 'put-acc-code') {

        try {
            $pdo = db_con();
            $sql = "INSERT INTO product_account (Product, Username, Password) 
                    VALUES (:productname, :email, :password)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':productname', $data_['productname']);
            $stmt->bindParam(':email', $data_['email']);
            $stmt->bindParam(':password', $data_['password']);

            if ($stmt->execute()) {
                echo json_encode(['status' => true, 'message' => 'เพิ่มข้อมูลสำเร็จ']);
            } else {
                echo json_encode(['status' => false, 'error' => 'เกิดข้อผิดพลาดในการเพิ่มข้อมูล']);
            }
            $pdo = null;
        } catch (PDOException $e) {
            echo json_encode(['error' => 'การเชื่อมต่อฐานข้อมูลล้มเหลว: ' . $e->getMessage()]);
        }
    } elseif (isset($data_['Code']) && $data_['Code'] === 'SlipStatus') {
        $idToUpdate = $data_['ID'];
        $response = updateStatus($idToUpdate); // เรียกใช้งานฟังก์ชันและส่ง $pdo เป็นพารามิเตอร์
        if ($response['status'] === 'success') {
            echo json_encode(['status' => true, 'message' => 'การอัพเดทสำเร็จ']);
        } else {
            echo json_encode(['status' => false, 'message' => 'การอัพเดทไม่สำเร็จ']);
        }
    } elseif (isset($data_['Code']) && $data_['Code'] === 'CheckOrderStatus') {
       $userStatus =  checkOrderGetCode($data_['orderNumber']);
       if($userStatus){
        echo json_encode(['status' => false, 'message' => 'ไม่มีการรับ']);
       } else {
        echo json_encode(['status' => true, 'message' => 'มีการรับ']);
       }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'ข้อมูลไม่ถูกต้อง']);
    }
} else {
    // กรณีไม่มีข้อมูล POST ถูกส่งมา
    http_response_code(405); // ส่ง HTTP 405 Method Not Allowed
    echo json_encode(['error' => 'ไม่อนุญาตให้เรียกใช้ API นี้โดยตรง']);
}
