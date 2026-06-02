<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Dashboard - CyberShield</title>
<link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Rajdhani:wght@300;400;600;700&family=Orbitron:wght@400;700;900&display=swap" rel="stylesheet">
<style>
:root{--bg:#030810;--panel:#081425;--border:#0a2a4a;--accent:#00d4ff;--accent2:#00ff88;--accent3:#ff3c6e;--warn:#ffaa00;--text:#c8dff0;--text-dim:#4a6a8a;}
*{margin:0;padding:0;box-sizing:border-box;}
body{background:var(--bg);color:var(--text);font-family:'Rajdhani',sans-serif;min-height:100vh;}
body::before{content:'';position:fixed;inset:0;background-image:linear-gradient(rgba(0,212,255,0.02) 1px,transparent 1px),linear-gradient(90deg,rgba(0,212,255,0.02) 1px,transparent 1px);background-size:50px 50px;pointer-events:none;z-index:0;}

/* NAV */
nav{position:fixed;top:0;left:0;right:0;z-index:100;display:flex;justify-content:space-between;align-items:center;padding:0 2.5rem;height:65px;background:rgba(3,8,16,0.95);border-bottom:1px solid var(--border);backdrop-filter:blur(10px);}
.logo{font-family:'Orbitron',monospace;font-size:1.1rem;font-weight:900;color:var(--accent);text-decoration:none;}
.logo span{color:var(--accent2);}
.nav-right{display:flex;align-items:center;gap:1.5rem;}
.nav-user{font-family:'Share Tech Mono',monospace;font-size:0.72rem;color:var(--accent2);letter-spacing:1px;}
.nav-btn{background:transparent;border:1px solid var(--border);color:var(--text-dim);padding:0.4rem 1.2rem;font-family:'Share Tech Mono',monospace;font-size:0.7rem;letter-spacing:2px;cursor:pointer;text-transform:uppercase;text-decoration:none;transition:all 0.3s;}
.nav-btn:hover{border-color:var(--accent);color:var(--accent);}
.nav-btn.danger{border-color:rgba(255,60,110,0.3);color:var(--accent3);}
.nav-btn.danger:hover{background:rgba(255,60,110,0.1);}

/* LAYOUT */
.page{padding:90px 2.5rem 2.5rem;max-width:1200px;margin:0 auto;position:relative;z-index:2;}

/* WELCOME */
.welcome{margin-bottom:2.5rem;}
.welcome-tag{font-family:'Share Tech Mono',monospace;font-size:0.7rem;color:var(--accent2);letter-spacing:3px;text-transform:uppercase;margin-bottom:0.5rem;}
.welcome h1{font-family:'Orbitron',monospace;font-size:2rem;font-weight:700;color:var(--text);}
.welcome h1 span{color:var(--accent);}
.welcome p{color:var(--text-dim);font-size:1rem;margin-top:0.5rem;}

/* TABS */
.tabs{display:flex;gap:0;border-bottom:1px solid var(--border);margin-bottom:2rem;}
.tab-btn{padding:0.9rem 2rem;font-family:'Share Tech Mono',monospace;font-size:0.72rem;letter-spacing:2px;text-transform:uppercase;cursor:pointer;color:var(--text-dim);background:none;border:none;border-bottom:2px solid transparent;transition:all 0.3s;margin-bottom:-1px;}
.tab-btn.active{color:var(--accent);border-bottom-color:var(--accent);}
.tab-btn:hover{color:var(--accent);}
.tab-panel{display:none;}
.tab-panel.active{display:block;}

/* BOOKING FORM */
.form-card{background:var(--panel);border:1px solid var(--border);padding:2.5rem;position:relative;max-width:800px;}
.form-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--accent),var(--accent2));}
.form-title{font-family:'Share Tech Mono',monospace;font-size:0.7rem;color:var(--accent);letter-spacing:3px;text-transform:uppercase;margin-bottom:2rem;padding-bottom:1rem;border-bottom:1px solid var(--border);}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:1.2rem;}
.field{margin-bottom:1.2rem;}
.field label{display:block;font-family:'Share Tech Mono',monospace;font-size:0.62rem;color:var(--text-dim);letter-spacing:2px;text-transform:uppercase;margin-bottom:0.5rem;}
.field input,.field select,.field textarea{width:100%;background:rgba(0,0,0,0.3);border:1px solid var(--border);border-bottom:1px solid rgba(0,212,255,0.2);color:var(--text);padding:0.85rem 1rem;font-family:'Rajdhani',sans-serif;font-size:1rem;outline:none;transition:all 0.3s;appearance:none;}
.field input:focus,.field select:focus,.field textarea:focus{border-color:var(--accent);background:rgba(0,212,255,0.02);}
.field select option{background:var(--panel);}
.field textarea{height:100px;resize:vertical;}
.submit-btn{background:var(--accent);color:var(--bg);border:none;padding:1rem 3rem;font-family:'Orbitron',monospace;font-size:0.8rem;font-weight:700;letter-spacing:2px;cursor:pointer;text-transform:uppercase;transition:all 0.3s;clip-path:polygon(0 0,calc(100% - 10px) 0,100% 10px,100% 100%,10px 100%,0 calc(100% - 10px));}
.submit-btn:hover{box-shadow:0 0 20px rgba(0,212,255,0.3);}
.submit-btn:disabled{opacity:0.5;cursor:not-allowed;}
.alert{padding:0.8rem 1rem;font-family:'Share Tech Mono',monospace;font-size:0.72rem;letter-spacing:1px;margin-bottom:1.5rem;display:none;}
.alert.success{background:rgba(0,255,136,0.08);border:1px solid rgba(0,255,136,0.3);color:var(--accent2);}
.alert.error{background:rgba(255,60,110,0.08);border:1px solid rgba(255,60,110,0.3);color:var(--accent3);}

/* BOOKINGS LIST */
.bookings-grid{display:flex;flex-direction:column;gap:1rem;}
.booking-item{background:var(--panel);border:1px solid var(--border);padding:1.5rem;display:grid;grid-template-columns:1fr auto;gap:1rem;align-items:start;transition:border-color 0.3s;}
.booking-item:hover{border-color:rgba(0,212,255,0.2);}
.bi-service{font-family:'Orbitron',monospace;font-size:0.85rem;font-weight:700;color:var(--text);margin-bottom:0.3rem;}
.bi-company{font-family:'Share Tech Mono',monospace;font-size:0.7rem;color:var(--text-dim);margin-bottom:0.5rem;}
.bi-msg{font-size:0.9rem;color:var(--text-dim);font-style:italic;}
.bi-date{font-family:'Share Tech Mono',monospace;font-size:0.65rem;color:var(--text-dim);margin-top:0.5rem;}
.urgency-badge{display:inline-block;padding:0.2rem 0.7rem;font-family:'Share Tech Mono',monospace;font-size:0.6rem;letter-spacing:1px;text-transform:uppercase;}
.urgency-badge.standard{background:rgba(0,212,255,0.1);color:var(--accent);border:1px solid rgba(0,212,255,0.2);}
.urgency-badge.priority{background:rgba(255,170,0,0.1);color:var(--warn);border:1px solid rgba(255,170,0,0.2);}
.urgency-badge.emergency{background:rgba(255,60,110,0.1);color:var(--accent3);border:1px solid rgba(255,60,110,0.2);}
.empty-box{background:var(--panel);border:1px solid var(--border);padding:3rem;text-align:center;font-family:'Share Tech Mono',monospace;font-size:0.8rem;color:var(--text-dim);letter-spacing:2px;}

/* PROFILE */
.profile-card{background:var(--panel);border:1px solid var(--border);padding:2rem;max-width:500px;position:relative;}
.profile-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--accent2),var(--accent));}
.profile-avatar{width:60px;height:60px;background:rgba(0,212,255,0.1);border:1px solid rgba(0,212,255,0.3);display:flex;align-items:center;justify-content:center;font-family:'Orbitron',monospace;font-size:1.5rem;font-weight:900;color:var(--accent);margin-bottom:1.5rem;}
.profile-name{font-family:'Orbitron',monospace;font-size:1.2rem;font-weight:700;color:var(--text);margin-bottom:0.3rem;}
.profile-email{font-family:'Share Tech Mono',monospace;font-size:0.75rem;color:var(--text-dim);margin-bottom:1.5rem;}
.profile-stat{display:flex;justify-content:space-between;padding:0.8rem 0;border-bottom:1px solid var(--border);font-family:'Share Tech Mono',monospace;font-size:0.72rem;}
.profile-stat:last-child{border-bottom:none;}
.profile-stat .ps-label{color:var(--text-dim);letter-spacing:1px;}
.profile-stat .ps-val{color:var(--accent);}
.danger-zone{margin-top:2rem;padding:1.5rem;border:1px solid rgba(255,60,110,0.2);background:rgba(255,60,110,0.03);}
.danger-title{font-family:'Share Tech Mono',monospace;font-size:0.65rem;color:var(--accent3);letter-spacing:3px;text-transform:uppercase;margin-bottom:1rem;}
</style>
</head>
<body>

<nav>
  <a href="index.html" class="logo">Cyber<span>Shield</span></a>
  <div class="nav-right">
    <span class="nav-user" id="navUsername">Loading...</span>
    <a href="chat.php" class="nav-btn">Live Chat</a>
    <button class="nav-btn danger" id="logoutBtn">Sign Out</button>
  </div>
</nav>

<div class="page">
  <div class="welcome">
    <div class="welcome-tag">&gt; User Dashboard</div>
    <h1>Welcome back, <span id="welcomeName">--</span></h1>
    <p>Manage your consultations, bookings and account from here.</p>
  </div>

  <div class="tabs">
    <button class="tab-btn active" id="tab-book">Book Consultation</button>
    <button class="tab-btn" id="tab-mybookings">My Bookings</button>
    <button class="tab-btn" id="tab-profile">My Profile</button>
  </div>

  <!-- BOOK -->
  <div class="tab-panel active" id="panel-book">
    <div class="form-card">
      <div class="form-title">&gt; New Consultation Request</div>
      <div class="alert" id="bookAlert"></div>
      <div class="form-row">
        <div class="field">
          <label>First Name</label>
          <input type="text" id="fname" placeholder="John">
        </div>
        <div class="field">
          <label>Last Name</label>
          <input type="text" id="lname" placeholder="Smith">
        </div>
      </div>
      <div class="field">
        <label>Business Email</label>
        <input type="email" id="email" placeholder="john@company.com">
      </div>
      <div class="field">
        <label>Company Name</label>
        <input type="text" id="company" placeholder="Acme Corp">
      </div>
      <div class="form-row">
        <div class="field">
          <label>Service Required</label>
          <select id="service">
            <option value="">Select service...</option>
            <option>Penetration Testing</option>
            <option>Security Audit</option>
            <option>Network Security</option>
            <option>Incident Response</option>
            <option>Cloud Security</option>
            <option>Security Training</option>
            <option>General Consultation</option>
          </select>
        </div>
        <div class="field">
          <label>Urgency</label>
          <select id="urgency">
            <option value="standard">Standard (1-2 weeks)</option>
            <option value="priority">Priority (3-5 days)</option>
            <option value="emergency">Emergency (24hrs)</option>
          </select>
        </div>
      </div>
      <div class="field">
        <label>Message / Details</label>
        <textarea id="message" placeholder="Describe your security concern..."></textarea>
      </div>
      <button class="submit-btn" id="submitBookBtn">&#9658; Submit Booking Request</button>
    </div>
  </div>

  <!-- MY BOOKINGS -->
  <div class="tab-panel" id="panel-mybookings">
    <div id="myBookingsList">
      <div class="empty-box">Loading your bookings...</div>
    </div>
  </div>

  <!-- PROFILE -->
  <div class="tab-panel" id="panel-profile">
    <div class="profile-card">
      <div class="profile-avatar" id="profileAvatar">--</div>
      <div class="profile-name" id="profileName">--</div>
      <div class="profile-email" id="profileEmail">--</div>
      <div class="profile-stat">
        <span class="ps-label">Account Status</span>
        <span class="ps-val">Active</span>
      </div>
      <div class="profile-stat">
        <span class="ps-label">Total Bookings</span>
        <span class="ps-val" id="profileBookingCount">0</span>
      </div>
      <div class="profile-stat">
        <span class="ps-label">Member Since</span>
        <span class="ps-val" id="profileJoined">--</span>
      </div>
      <div class="danger-zone">
        <div class="danger-title">Account Actions</div>
        <button class="nav-btn danger" id="deleteAccountBtn" style="width:100%;padding:0.7rem;text-align:center">Delete My Account</button>
      </div>
    </div>
  </div>
</div>

<script>
var currentUser = null;

// ---- CHECK AUTH ----
async function init() {
  try {
    var res  = await fetch('user_auth.php?action=check');
    var data = await res.json();
    if (!data.logged_in) {
      window.location.href = 'user_login.php';
      return;
    }
    currentUser = data;
    document.getElementById('navUsername').textContent = data.username;
    document.getElementById('welcomeName').textContent = data.username;
    document.getElementById('profileName').textContent = data.username;
    document.getElementById('profileEmail').textContent = data.email;
    document.getElementById('profileAvatar').textContent = data.username.charAt(0).toUpperCase();

    // Pre-fill email in booking form
    document.getElementById('email').value = data.email;

    loadMyBookings();
    loadProfileStats();
  } catch(e) {
    window.location.href = 'user_login.php';
  }
}

// ---- TABS ----
document.getElementById('tab-book').addEventListener('click', function(){ showTab('book', this); });
document.getElementById('tab-mybookings').addEventListener('click', function(){ showTab('mybookings', this); loadMyBookings(); });
document.getElementById('tab-profile').addEventListener('click', function(){ showTab('profile', this); });

function showTab(name, el) {
  document.querySelectorAll('.tab-btn').forEach(function(b){ b.classList.remove('active'); });
  document.querySelectorAll('.tab-panel').forEach(function(p){ p.classList.remove('active'); });
  el.classList.add('active');
  document.getElementById('panel-' + name).classList.add('active');
}

// ---- SUBMIT BOOKING ----
document.getElementById('submitBookBtn').addEventListener('click', async function() {
  var fname   = document.getElementById('fname').value.trim();
  var lname   = document.getElementById('lname').value.trim();
  var email   = document.getElementById('email').value.trim();
  var company = document.getElementById('company').value.trim();
  var service = document.getElementById('service').value;
  var urgency = document.getElementById('urgency').value;
  var message = document.getElementById('message').value.trim();

  if (!fname || !lname || !email || !company || !service) {
    showAlert('bookAlert', 'error', 'Please fill in all required fields.');
    return;
  }

  this.disabled = true;
  this.textContent = 'Submitting...';

  var fd = new FormData();
  fd.append('action',   'save_booking');
  fd.append('fname',    fname);
  fd.append('lname',    lname);
  fd.append('email',    email);
  fd.append('company',  company);
  fd.append('service',  service);
  fd.append('urgency',  urgency);
  fd.append('message',  message);
  fd.append('username', currentUser ? currentUser.username : '');

  try {
    var res  = await fetch('get_bookings.php', {method:'POST', body:fd});
    var data = await res.json();
    if (data.ok) {
      showAlert('bookAlert', 'success', 'Booking submitted successfully! We will contact you within 24 hours.');
      document.getElementById('fname').value = '';
      document.getElementById('lname').value = '';
      document.getElementById('company').value = '';
      document.getElementById('service').value = '';
      document.getElementById('message').value = '';
    } else {
      showAlert('bookAlert', 'error', data.error || 'Submission failed. Please try again.');
    }
  } catch(e) {
    showAlert('bookAlert', 'error', 'Network error. Please try again.');
  }

  this.disabled = false;
  this.innerHTML = '&#9658; Submit Booking Request';
});

// ---- LOAD MY BOOKINGS ----
async function loadMyBookings() {
  var el = document.getElementById('myBookingsList');
  try {
    var res  = await fetch('get_bookings.php?action=get_bookings');
    var data = await res.json();
    var all  = data.bookings || [];

    // Filter bookings by current user email or username
    var mine = all.filter(function(b) {
      return (currentUser && (b.email === currentUser.email || b.username === currentUser.username));
    });

    if (!mine.length) {
      el.innerHTML = '<div class="empty-box">No bookings yet. Use the Book Consultation tab to get started.</div>';
      return;
    }

    el.innerHTML = '';
    var grid = document.createElement('div');
    grid.className = 'bookings-grid';
    mine.slice().reverse().forEach(function(b) {
      var item = document.createElement('div');
      item.className = 'booking-item';
      item.innerHTML = '<div>'
        + '<div class="bi-service">' + esc(b.service) + '</div>'
        + '<div class="bi-company">' + esc(b.company) + '</div>'
        + (b.message ? '<div class="bi-msg">"' + esc(b.message.substring(0,120)) + '"</div>' : '')
        + '<div class="bi-date">Submitted: ' + fmtDate(b.date) + '</div>'
        + '</div>'
        + '<div style="display:flex;flex-direction:column;align-items:flex-end;gap:0.5rem">'
        + '<span class="urgency-badge ' + (b.urgency||'standard') + '">' + (b.urgency||'standard') + '</span>'
        + '<span style="font-family:monospace;font-size:0.65rem;color:var(--accent2)">&#10003; Received</span>'
        + '</div>';
      grid.appendChild(item);
    });
    el.appendChild(grid);
  } catch(e) {
    el.innerHTML = '<div class="empty-box">Could not load bookings.</div>';
  }
}

// ---- PROFILE STATS ----
async function loadProfileStats() {
  try {
    var res  = await fetch('get_bookings.php?action=get_bookings');
    var data = await res.json();
    var all  = data.bookings || [];
    var mine = all.filter(function(b){
      return currentUser && (b.email === currentUser.email || b.username === currentUser.username);
    });
    document.getElementById('profileBookingCount').textContent = mine.length;

    // Get join date from users list
    var uRes  = await fetch('user_auth.php?action=list_users');
    var uData = await uRes.json();
    var me = (uData.users||[]).find(function(u){ return u.username === currentUser.username; });
    if (me) document.getElementById('profileJoined').textContent = fmtDate(me.created_at);
  } catch(e) {}
}

// ---- LOGOUT ----
document.getElementById('logoutBtn').addEventListener('click', async function() {
  var fd = new FormData();
  fd.append('action', 'logout');
  await fetch('user_auth.php', {method:'POST', body:fd});
  window.location.href = 'user_login.php';
});

// ---- DELETE ACCOUNT ----
document.getElementById('deleteAccountBtn').addEventListener('click', async function() {
  if (!confirm('Are you sure you want to delete your account? This cannot be undone.')) return;
  if (!confirm('Really delete? All your data will be lost.')) return;
  var fd = new FormData();
  fd.append('action', 'delete_user');
  fd.append('user_id', currentUser.id);
  await fetch('user_auth.php', {method:'POST', body:fd});
  window.location.href = 'user_login.php';
});

function showAlert(id, type, msg) {
  var el = document.getElementById(id);
  el.className = 'alert ' + type;
  el.textContent = msg;
  el.style.display = 'block';
  setTimeout(function(){ el.style.display = 'none'; }, 5000);
}

function fmtDate(s) { try { return new Date(s).toLocaleString(); } catch(e) { return s||'--'; } }
function esc(s) { return String(s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

init();
</script>
</body>
</html>
