<?php
// ตรวจสอบว่ามีการส่งค่า POST มาจากฟอร์มหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // กำหนดข้อมูลในการเชื่อมต่อฐานข้อมูล
     $conn = new mysqli('127.0.0.1', 'up0pykdpcofgq', 'bggssjm1cg4b', 'dbnqpjg8oxxuyj');

    // ตรวจสอบการเชื่อมต่อ
    if ($conn->connect_error) {
        die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
    }

    // ดึงข้อมูลจากฟอร์ม
    $purchase_order = $_POST['purchase_order'];
    $name_surname = $_POST['name_surname'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $total = $_POST['total'];
    $payment_date = $_POST['date'];
    $payment_time = $_POST['time'];

    // อัพโหลดไฟล์สลิปการชำระเงิน
    $target_directory = "./Images/"; // โฟลเดอร์ที่จะบันทึกไฟล์
    $imageFileType = strtolower(pathinfo($_FILES["upload"]["name"], PATHINFO_EXTENSION));

    // สร้างชื่อไฟล์ใหม่
    $timestamp = time(); // ดึง timestamp ปัจจุบัน
    $random_number = rand(1000, 9999); // สุ่มตัวเลขระหว่าง 1000 ถึง 9999
    $new_file_name = $timestamp . '_' . $random_number . '.' . $imageFileType; // ชื่อไฟล์ใหม่

    $target_file = $target_directory . $new_file_name; // เตรียมตำแหน่งไฟล์ที่จะบันทึก

    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // เช็คว่าไฟล์รูปภาพหรือไม่
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["upload"]["tmp_name"]);
        if($check !== false) {
            echo "ไฟล์เป็นรูปภาพ - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "ไฟล์ไม่ใช่รูปภาพ.";
            $uploadOk = 0;
        }
    }

    // เช็คขนาดของไฟล์
    if ($_FILES["upload"]["size"] > 50000000) {
        echo "ขออภัย, ไฟล์ของคุณมีขนาดใหญ่เกินไป.";
        $uploadOk = 0;
    }

    // เช็คนามสกุลไฟล์
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "ขออภัย, ไฟล์รูปภาพเชียนรองรับเฉพาะ JPG, JPEG, PNG.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "ขออภัย, ไฟล์ของคุณไม่ถูกอัพโหลด.";
    } else {
        if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
           // echo "ไฟล์ " . basename($_FILES["upload"]["name"]) . " ถูกอัพโหลดเรียบร้อยแล้ว.";
            // เมื่ออัพโหลดไฟล์สำเร็จ เพิ่มข้อมูลลงในฐานข้อมูล
            $sql = "INSERT INTO payment_notifications (purchase_order, name_surname, tel, email, payment_slip_path, total, payment_date, payment_time) 
                    VALUES ('$purchase_order', '$name_surname', '$tel', '$email', '$target_file', '$total', '$payment_date', '$payment_time')";
            
            if ($conn->query($sql) === TRUE) {
                header('location: https://ttomoru.com/pay2/?upload=sucsse');
                exit();
            } else {
                 header('location: https://ttomoru.com/pay2/?upload=false');
                exit();
            }
        } else {
            header('location: https://ttomoru.com/pay2/?upload=false');
            exit();
        }
    }
    $conn->close();
}
?>
