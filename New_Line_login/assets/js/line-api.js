
function logOut() {
    liff.logout()
    window.location.href = 'https://ttomoru.com/my-account/';
  }
  function logIn() {
    liff.login({ redirectUri: window.location.href })
  }
  
  async function getUserProfile() {
    const profile = await liff.getProfile()
  }
  async function main() {
    await liff.init({ liffId: "1661486572-NwGd1pXO" })
    if (liff.isInClient()) {
      getUserProfile()
    } else {
      if (liff.isLoggedIn()) {
        getUserProfile()
      }
    }
    if (liff.isLoggedIn()) {
      const profile = await liff.getProfile();
      const userId = profile.userId;
      const orderId = localStorage.getItem('orderID');
      if (orderId) {
       window.location.href = `https://ttomoru.com/New_Line_login/welcome.php?userId=${userId}&name=${profile.displayName}&pictureUrl=${profile.pictureUrl}&orderID=${orderId}`;
      }
    } 
  }
  main();