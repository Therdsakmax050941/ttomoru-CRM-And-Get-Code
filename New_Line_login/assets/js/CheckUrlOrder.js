function CheckUrlOrderId() {
    const urlParams = new URLSearchParams(window.location.search);
    const orderId = urlParams.get('orderID');
    if (orderId === null || orderId === '') {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer);
          toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
      });

      Toast.fire({
        icon: 'error',
        title: 'ดูเหมือนคุณจะเข้าสู่ระบบแบบไม่ถูกต้อง โปรดกดที่รับรหัสเพื่อเข้าสู่หน้านี้'
      }).then((result) => {
        window.location.href = 'https://ttomoru.com/my-account/'; // เปลี่ยนเป็นลิงก์ที่คุณต้องการ
      });
    }
  }