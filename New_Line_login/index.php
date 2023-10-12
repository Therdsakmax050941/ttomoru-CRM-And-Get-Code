
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.72.0">
  <title>ttomoru </title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://ttomoru.com/Line_Login/CSS/style.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="./assets/css/style.index.css" />
</head>
<body onload="CheckUrlOrderId()">
  <!-- Add the video container and video element -->
  <div class="video-container">
    <video src="https://ttomoru.com/Line_Login/vdo/movie.mp4" autoplay loop muted></video>
  </div>
  <div class="carousel-text active">
  <span class="carousel-content slide-left-animation">TTOMORU WELCOME</span>
</div>
<div class="carousel-text">
  <span class="carousel-content slide-left-animation">If you're ready, go get the code</span>
</div>
  <div class="wrapper fadeInDown">
    <div id="formContent">
      <!-- Tabs Titles -->
      <!-- Icon -->
      <div class="fadeIn first icon">
        
      </div>
      <!-- Login Form -->
      <div class="w3-content w3-section " style="max-width:500px">
        <img class="mySlides w3-animate-zoom" src="https://cdn-icons-png.flaticon.com/512/5977/5977590.png" style="width:30%">
        <img class="mySlides w3-animate-zoom" src="https://storage.googleapis.com/techsauce-prod/uploads/2019/03/WeTV_Logo.jpg" style="width:50%">
        <img class="mySlides w3-animate-zoom" src="https://www.citypng.com/public/uploads/preview/-1159629574507zqo9azzc.png?v=2023061001" style="width:30%">
        <img class="mySlides w3-animate-zoom" src="https://cpc.ais.co.th/CPC-FE-WEB/api/contents/upload//d/i/s/n/e/disney%20logo.png?rand=0.4769652299799142" style="width:50%">
      </div style="margin-top:10%;">

      <button class="login-button btn btn-line" id="btnLogIn" onclick="logIn()">
      <img src="./assets/icon/line.png" alt="Line Icon"> LINE LOIN
    </button>
        <br><br><p>เข้าสู่ระบบด้วยไลน์เพื่อรับรหัส</p>

      <!-- Remind Passowrd -->
      <div id="formFooter">
        
        <a href="logout.php?orderID= <?php $orderID ?>" class="logout-btn">
        <i class="fas fa-undo-alt"></i>RESET
        </a> 
        *หากเกิดปัญหาการเข้าสู่ระบบ 
        <h4>ttomoru.com</h4>
      </div>
    </div>
  </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://static.line-scdn.net/liff/edge/2/sdk.js"></script>
  <script src="./assets/js/index.js"></script>
  <script src="./assets/js/line-api.js"></script>
  <script src="./assets/js/CheckUrlOrder.js"></script>
</body>

</html>