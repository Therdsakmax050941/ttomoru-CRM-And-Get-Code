<?php if(empty($_GET['orderID']) or $_GET['orderID'] == null){header('location: https://ttomoru.com/my-account/');} 
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="./assets/css/style.welcome.css" />
</head>
<body onload="CheckUrlOrderId()">
  <div class="container mt-5">
    <div class="card bg-black">
      <div class="card-header bg-dark"> 
      <h1 class="neon">We<span>l</span>co<span>m</span>e , <?echo $_GET['name']; ?></h1>
        <button id="btnLogOut" onclick="logOut()" class="btn btn-danger">Logout</button>
      </div>
      <div class="card-body">
        <p><b>Order ID : </b><?php  echo $_GET['orderID']; ?></p>
        <p><b>Name : </b><?php  echo $_GET['name']; ?></p>
        <p><b>รายการสั่งซื้อ : </b ><p id="order_list"></p></p>
        <h6><b>สถานะการจ่ายเงิน : </b><label id="status"></label></h6>
        <!-- Button trigger modal -->
        <button type="button" id="btnConfirm" class="btn btn-primary  float-md-right" data-bs-toggle="modal" data-bs-target="#exampleModal">
          ยืนยันการชำระและขอรับรหัส
        </button>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="./assets/js/check_Woo.js"></script>
  <script src="./assets/js/welcome.js"></script>
  <script src="./assets/js/CheckUrlOrder.js"></script>
  <script src="https://static.line-scdn.net/liff/edge/2/sdk.js"></script>
  <script src="./assets/js/line-api.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
</body>

</html>