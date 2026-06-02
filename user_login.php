<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign In - CyberShield Consulting</title>
<link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Rajdhani:wght@300;400;600;700&family=Orbitron:wght@400;700;900&display=swap" rel="stylesheet">
<style>
:root{--bg:#030810;--panel:#081425;--border:#0a2a4a;--accent:#00d4ff;--accent2:#00ff88;--accent3:#ff3c6e;--text:#c8dff0;--text-dim:#4a6a8a;}
*{margin:0;padding:0;box-sizing:border-box;}
body{background:var(--bg);color:var(--text);font-family:'Rajdhani',sans-serif;min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:2rem;}
body::before{content:'';position:fixed;inset:0;background-image:linear-gradient(rgba(0,212,255,0.02) 1px,transparent 1px),linear-gradient(90deg,rgba(0,212,255,0.02) 1px,transparent 1px);background-size:50px 50px;pointer-events:none;}
.back-link{font-family:'Share Tech Mono',monospace;font-size:0.7rem;color:var(--text-dim);text-decoration:none;letter-spacing:2px;margin-bottom:2rem;align-self:flex-start;transition:color 0.3s;}
.back-link:hover{color:var(--accent);}
.card{background:var(--panel);border:1px solid var(--border);width:100%;max-width:460px;position:relative;}
.card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--accent),var(--accent2));}
.tabs{display:flex;border-bottom:1px solid var(--border);}
.tab{flex:1;padding:1.1rem;text-align:center;font-family:'Share Tech Mono',monospace;font-size:0.72rem;letter-spacing:2px;text-transform:uppercase;cursor:pointer;color:var(--text-dim);transition:all 0.3s;border:none;background:none;}
.tab.active{color:var(--accent);background:rgba(0,212,255,0.04);border-bottom:2px solid var(--accent);}
.tab:hover{color:var(--accent);}
.form-body{padding:2.5rem;}
.logo{font-family:'Orbitron',monospace;font-size:1.2rem;font-weight:900;color:var(--accent);text-align:center;margin-bottom:0.3rem;}
.logo span{color:var(--accent2);}
.sub{font-family:'Share Tech Mono',monospace;font-size:0.62rem;color:var(--text-dim);text-align:center;letter-spacing:2px;margin-bottom:2rem;}
.field{margin-bottom:1.2rem;}
.field label{display:block;font-family:'Share Tech Mono',monospace;font-size:0.62rem;color:var(--text-dim);letter-spacing:2px;text-transform:uppercase;margin-bottom:0.5rem;}
.field input{width:100%;background:rgba(0,0,0,0.3);border:1px solid var(--border);border-bottom:1px solid rgba(0,212,255,0.2);color:var(--text);padding:0.85rem 1rem;font-family:'Rajdhani',sans-serif;font-size:1rem;outline:none;transition:all 0.3s;}
.field input:focus{border-color:var(--accent);background:rgba(0,212,255,0.02);}
.pw-wrap{position:relative;}
.pw-wrap input{padding-right:3rem;}
.pw-eye{position:absolute;right:0.8rem;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--text-dim);cursor:pointer;font-size:1.1rem;padding:0.2rem;}
.pw-eye:hover{color:var(--accent);}
.strength-bar{height:3px;background:var(--border);margin-top:0.4rem;border-radius:2px;overflow:hidden;}
.strength-fill{height:100%;width:0%;transition:width 0.3s,background 0.3s;}
.strength-label{font-family:'Share Tech Mono',monospace;font-size:0.58rem;color:var(--text-dim);margin-top:0.3rem;letter-spacing:1px;}
.submit-btn{width:100%;background:var(--accent);color:var(--bg);border:none;padding:1rem;font-family:'Orbitron',monospace;font-size:0.8rem;font-weight:700;letter-spacing:2px;cursor:pointer;text-transform:uppercase;margin-top:0.5rem;clip-path:polygon(0 0,calc(100% - 10px) 0,100% 10px,100% 100%,10px 100%,0 calc(100% - 10px));transition:all 0.3s;}
.submit-btn:hover{box-shadow:0 0 20px rgba(0,212,255,0.3);}
.submit-btn:disabled{opacity:0.5;cursor:not-allowed;}
.alert{padding:0.8rem 1rem;font-family:'Share Tech Mono',monospace;font-size:0.72rem;letter-spacing:1px;margin-bottom:1.2rem;display:none;}
.alert.error{background:rgba(255,60,110,0.08);border:1px solid rgba(255,60,110,0.3);color:var(--accent3);}
.alert.success{background:rgba(0,255,136,0.08);border:1px solid rgba(0,255,136,0.3);color:var(--accent2);}
.divider{display:flex;align-items:center;gap:1rem;margin:1.2rem 0;}
.divider span{font-family:'Share Tech Mono',monospace;font-size:0.6rem;color:var(--text-dim);letter-spacing:2px;white-space:nowrap;}
.divider::before,.divider::after{content:'';flex:1;height:1px;background:var(--border);}
.security-note{margin-top:1.5rem;padding-top:1.2rem;border-top:1px solid var(--border);font-family:'Share Tech Mono',monospace;font-size:0.58rem;color:var(--text-dim);text-align:center;letter-spacing:1px;line-height:1.8;}
.security-note b{color:var(--accent2);}
/* password requirements list */
.pw-reqs{margin-top:0.5rem;display:none;}
.pw-reqs li{font-family:'Share Tech Mono',monospace;font-size:0.6rem;letter-spacing:1px;list-style:none;padding:0.15rem 0;transition:color 0.2s;}
.pw-reqs li.met{color:var(--accent2);}
.pw-reqs li.unmet{color:var(--text-dim);}
.form-panel{display:none;}
.form-panel.active{display:block;}
</style>
</head>
<body>

<a href="index.html" class="back-link">&#8592; Back to Home</a>

<div class="card">
  <div class="tabs">
    <button class="tab active" id="tabLogin" onclick="showTab('login')">Sign In</button>
    <button class="tab" id="tabRegister" onclick="showTab('register')">Create Account</button>
  </div>

  <div class="form-body">
    <div class="logo">Cyber<span>Shield</span></div>
    <div class="sub" id="formSub">Sign in to book a consultation</div>

    <div class="alert" id="alertBox"></div>

    <!-- LOGIN FORM -->
    <div class="form-panel active" id="panelLogin">
      <div class="field">
        <label>Username or Email</label>
        <input type="text" id="loginIdentifier" placeholder="username or email@example.com" autocomplete="username">
      </div>
      <div class="field">
        <label>Password</label>
        <div class="pw-wrap">
          <input type="password" id="loginPassword" placeholder="Your password" autocomplete="current-password">
          <button type="button" class="pw-eye" onclick="togglePw('loginPassword')">&#128065;</button>
        </div>
      </div>
      <button class="submit-btn" id="loginBtn">&#9658; SIGN IN</button>
    </div>

    <!-- REGISTER FORM -->
    <div class="form-panel" id="panelRegister">
      <div class="field">
        <label>Username</label>
        <input type="text" id="regUsername" placeholder="Choose a username" autocomplete="username" oninput="checkUsername(this.value)">
        <div class="strength-label" id="usernameHint"></div>
      </div>
      <div class="field">
        <label>Email Address</label>
        <input type="email" id="regEmail" placeholder="your@email.com" autocomplete="email">
      </div>
      <div class="field">
        <label>Password</label>
        <div class="pw-wrap">
          <input type="password" id="regPassword" placeholder="Min. 8 characters" autocomplete="new-password" oninput="checkStrength(this.value)">
          <button type="button" class="pw-eye" onclick="togglePw('regPassword')">&#128065;</button>
        </div>
        <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
        <div class="strength-label" id="strengthLabel"></div>
        <ul class="pw-reqs" id="pwReqs">
          <li id="req-len" class="unmet">&#9675; At least 8 characters</li>
          <li id="req-upper" class="unmet">&#9675; At least one uppercase letter</li>
          <li id="req-num" class="unmet">&#9675; At least one number</li>
          <li id="req-special" class="unmet">&#9675; At least one special character</li>
        </ul>
      </div>
      <div class="field">
        <label>Confirm Password</label>
        <div class="pw-wrap">
          <input type="password" id="regConfirm" placeholder="Repeat your password" autocomplete="new-password">
          <button type="button" class="pw-eye" onclick="togglePw('regConfirm')">&#128065;</button>
        </div>
        <div class="strength-label" id="confirmHint"></div>
      </div>
      <button class="submit-btn" id="registerBtn">&#9658; CREATE ACCOUNT</button>
    </div>

    <div class="security-note">
      <b>&#10003;</b> Passwords are bcrypt hashed &nbsp;&bull;&nbsp;
      <b>&#10003;</b> Rate limited &nbsp;&bull;&nbsp;
      <b>&#10003;</b> HTTPS encrypted
    </div>
  </div>
</div>

<script>
var currentTab = 'login';

function showTab(tab) {
  currentTab = tab;
  document.getElementById('panelLogin').classList.toggle('active', tab === 'login');
  document.getElementById('panelRegister').classList.toggle('active', tab === 'register');
  document.getElementById('tabLogin').classList.toggle('active', tab === 'login');
  document.getElementById('tabRegister').classList.toggle('active', tab === 'register');
  document.getElementById('formSub').textContent = tab === 'login'
    ? 'Sign in to book a consultation'
    : 'Create a free account to get started';
  hideAlert();
}

function showAlert(type, msg) {
  var box = document.getElementById('alertBox');
  box.className = 'alert ' + type;
  box.textContent = msg;
  box.style.display = 'block';
}

function hideAlert() {
  document.getElementById('alertBox').style.display = 'none';
}

function togglePw(id) {
  var f = document.getElementById(id);
  f.type = f.type === 'password' ? 'text' : 'password';
}

function checkUsername(val) {
  var hint = document.getElementById('usernameHint');
  if (val.length === 0) { hint.textContent = ''; return; }
  if (val.length < 3) { hint.style.color = 'var(--accent3)'; hint.textContent = 'Too short'; return; }
  if (!/^[a-zA-Z0-9_]+$/.test(val)) { hint.style.color = 'var(--accent3)'; hint.textContent = 'Letters, numbers and underscores only'; return; }
  hint.style.color = 'var(--accent2)';
  hint.textContent = 'Looks good';
}

function checkStrength(pw) {
  var reqs = document.getElementById('pwReqs');
  reqs.style.display = pw.length > 0 ? 'block' : 'none';

  var len     = pw.length >= 8;
  var upper   = /[A-Z]/.test(pw);
  var num     = /[0-9]/.test(pw);
  var special = /[^A-Za-z0-9]/.test(pw);

  setReq('req-len',     len);
  setReq('req-upper',   upper);
  setReq('req-num',     num);
  setReq('req-special', special);

  var score = [len, upper, num, special].filter(Boolean).length;
  var fill  = document.getElementById('strengthFill');
  var label = document.getElementById('strengthLabel');
  var colors = ['#ff3c6e','#ff3c6e','#ffaa00','#00d4ff','#00ff88'];
  var labels = ['','Weak','Fair','Good','Strong'];
  fill.style.width  = (score * 25) + '%';
  fill.style.background = colors[score];
  label.style.color = colors[score];
  label.textContent = labels[score];
}

function setReq(id, met) {
  var el = document.getElementById(id);
  el.className = met ? 'met' : 'unmet';
  el.innerHTML = (met ? '&#9679;' : '&#9675;') + ' ' + el.textContent.replace(/^. /, '');
}

// LOGIN
document.getElementById('loginBtn').addEventListener('click', async function() {
  var identifier = document.getElementById('loginIdentifier').value.trim();
  var password   = document.getElementById('loginPassword').value;
  if (!identifier || !password) { showAlert('error', 'Please fill in all fields.'); return; }

  this.disabled = true;
  this.textContent = 'Signing in...';
  hideAlert();

  var fd = new FormData();
  fd.append('action', 'login');
  fd.append('identifier', identifier);
  fd.append('password', password);

  try {
    var res  = await fetch('user_auth.php', {method:'POST', body:fd});
    var data = await res.json();
    if (data.ok) {
      showAlert('success', 'Welcome back, ' + data.username + '! Redirecting...');
      setTimeout(function(){ window.location.href = 'dashboard.php'; }, 1000);
    } else {
      showAlert('error', data.error || 'Login failed.');
      this.disabled = false;
      this.innerHTML = '&#9658; SIGN IN';
    }
  } catch(e) {
    showAlert('error', 'Network error. Please try again.');
    this.disabled = false;
    this.innerHTML = '&#9658; SIGN IN';
  }
});

// REGISTER
document.getElementById('registerBtn').addEventListener('click', async function() {
  var username = document.getElementById('regUsername').value.trim();
  var email    = document.getElementById('regEmail').value.trim();
  var password = document.getElementById('regPassword').value;
  var confirm  = document.getElementById('regConfirm').value;

  if (!username || !email || !password || !confirm) { showAlert('error', 'Please fill in all fields.'); return; }
  if (password !== confirm) { showAlert('error', 'Passwords do not match.'); return; }
  if (password.length < 8)  { showAlert('error', 'Password must be at least 8 characters.'); return; }

  // Update confirm hint
  var hint = document.getElementById('confirmHint');
  if (password !== confirm) {
    hint.style.color = 'var(--accent3)';
    hint.textContent = 'Passwords do not match';
    return;
  }

  this.disabled = true;
  this.textContent = 'Creating account...';
  hideAlert();

  var fd = new FormData();
  fd.append('action',   'register');
  fd.append('username', username);
  fd.append('email',    email);
  fd.append('password', password);
  fd.append('confirm',  confirm);

  try {
    var res  = await fetch('user_auth.php', {method:'POST', body:fd});
    var data = await res.json();
    if (data.ok) {
      showAlert('success', 'Account created! Switching to sign in...');
      setTimeout(function(){
        showTab('login');
        document.getElementById('loginIdentifier').value = username;
      }, 1500);
      this.disabled = false;
      this.innerHTML = '&#9658; CREATE ACCOUNT';
    } else {
      showAlert('error', data.error || 'Registration failed.');
      this.disabled = false;
      this.innerHTML = '&#9658; CREATE ACCOUNT';
    }
  } catch(e) {
    showAlert('error', 'Network error. Please try again.');
    this.disabled = false;
    this.innerHTML = '&#9658; CREATE ACCOUNT';
  }
});

// Allow Enter key on login fields
document.getElementById('loginPassword').addEventListener('keydown', function(e){
  if (e.key === 'Enter') document.getElementById('loginBtn').click();
});
document.getElementById('regConfirm').addEventListener('keydown', function(e){
  if (e.key === 'Enter') document.getElementById('registerBtn').click();
});
document.getElementById('regPassword').addEventListener('keydown', function(e){
  var hint = document.getElementById('confirmHint');
  var confirm = document.getElementById('regConfirm').value;
  if (confirm) {
    hint.style.color = this.value === confirm ? 'var(--accent2)' : 'var(--accent3)';
    hint.textContent = this.value === confirm ? 'Passwords match' : 'Passwords do not match';
  }
});
document.getElementById('regConfirm').addEventListener('input', function(){
  var pw = document.getElementById('regPassword').value;
  var hint = document.getElementById('confirmHint');
  hint.style.color = this.value === pw ? 'var(--accent2)' : 'var(--accent3)';
  hint.textContent = this.value === pw ? 'Passwords match' : 'Passwords do not match';
});

// Check if already logged in
fetch('user_auth.php?action=check').then(function(r){ return r.json(); }).then(function(d){
  if (d.logged_in) window.location.href = 'dashboard.php';
});
</script>
</body>
</html>
