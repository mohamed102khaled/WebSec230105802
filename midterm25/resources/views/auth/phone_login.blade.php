<script src="https://www.gstatic.com/firebasejs/9.22.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.22.2/firebase-auth.js"></script>

<script>
  // ✅ Your Firebase config
  const firebaseConfig = {
    apiKey: "YOUR_API_KEY",
    authDomain: "YOUR_PROJECT.firebaseapp.com",
    projectId: "YOUR_PROJECT_ID",
    appId: "YOUR_APP_ID",
  };

  firebase.initializeApp(firebaseConfig);
  const auth = firebase.auth();

  function sendOTP() {
    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
      'size': 'invisible'
    });

    const phoneNumber = document.getElementById('phone').value;
    firebase.auth().signInWithPhoneNumber(phoneNumber, window.recaptchaVerifier)
      .then(confirmationResult => {
        window.confirmationResult = confirmationResult;
        alert('OTP Sent!');
      }).catch(error => {
        alert(error.message);
      });
  }

  function verifyOTP() {
    const otp = document.getElementById('otp').value;
    window.confirmationResult.confirm(otp).then(result => {
      result.user.getIdToken().then(token => {
        // ✅ Send token to Laravel
        fetch('/auth/phone/callback', {
          method: 'POST',
          headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
          body: JSON.stringify({token})
        }).then(res => res.json()).then(data => {
          if (data.success) window.location.href = '/';
          else alert('Login failed');
        });
      });
    }).catch(error => alert('OTP Invalid'));
  }
</script>

<!-- HTML -->
<input type="tel" id="phone" placeholder="+201234567890" />
<div id="recaptcha-container"></div>
<button onclick="sendOTP()">Send OTP</button>

<input type="text" id="otp" placeholder="Enter OTP" />
<button onclick="verifyOTP()">Verify OTP</button>
