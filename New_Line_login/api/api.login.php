<?php
require_once './function.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $json_data = file_get_contents("php://input");
    $data_ = json_decode($json_data, true);

    if (isset($data_['username']) && $data_['password']) {
      $check_login = check_Login($data_['username'],md5($data_['password']));
        if($check_login)
        {
            $token = md5($data_['username'].$data_['password']);
            echo json_encode(['status' => true, 'messsage' => 'ข้อมูลถูกต้อง' ,'token' => $token]);
        }else{
            echo json_encode(['status' => false, 'messsage' => 'ไม่มี User ในระบบ']);
        }
    }
} else{
    echo json_encode(['status' => false, 'messsage' => 'ไม่พบข้อมูล']);
}
?>