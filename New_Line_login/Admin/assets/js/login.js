document.getElementById('loginForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    fetch('https://ttomoru.com/New_Line_login/api/api.login.php', {
        method: 'POST',
        body: JSON.stringify({ username, password }),
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.status) {
            alert(data.message);

            // บันทึก Token ใน localStorage
            localStorage.setItem('token', data.token);

            // บันทึกเวลาหมดอายุของ Token (1 ชั่วโมง) ใน localStorage
            const expirationTime = new Date().getTime() + 60 * 60 * 1000; // 1 ชั่วโมง
            localStorage.setItem('tokenExpiration', expirationTime);

            window.location.href = 'https://ttomoru.com/New_Line_login/Admin/Admin.php';
        } else {
            alert(data.message);
            window.location.reload();
        }
    })
    .catch(error => {
        console.error('เกิดข้อผิดพลาด: ' + error);
    });
});