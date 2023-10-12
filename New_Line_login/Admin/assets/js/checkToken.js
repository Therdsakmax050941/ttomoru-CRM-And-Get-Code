const token = localStorage.getItem('token');
const tokenExpiration = localStorage.getItem('tokenExpiration');

if (token && tokenExpiration && new Date().getTime() < tokenExpiration) {
    // Token ยังไม่หมดอายุ
    // สามารถทำอะไรก็ได้ที่ผู้ใช้เข้าสู่ระบบแล้ว
} else {
    // Token หมดอายุหรือไม่มี Token
    // จำเป็นต้องเด้งไปหน้า login ใหม่
    localStorage.removeItem('token');
    window.location.href = 'https://ttomoru.com/New_Line_login/Admin/index.php'; // หรือหน้า login ที่คุณใช้
}