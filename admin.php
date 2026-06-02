<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Panel - CyberShield</title>
<link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Rajdhani:wght@300;400;600;700&family=Orbitron:wght@400;700;900&display=swap" rel="stylesheet">
<style>
:root{--bg:#020609;--panel:#060f1e;--border:#0a2a4a;--accent:#00d4ff;--accent2:#00ff88;--accent3:#ff3c6e;--warn:#ffaa00;--text:#c8dff0;--text-dim:#3a5a7a;}
*{margin:0;padding:0;box-sizing:border-box;}
body{background:var(--bg);color:var(--text);font-family:'Rajdhani',sans-serif;min-height:100vh;}
body::before{content:'';position:fixed;inset:0;background-image:linear-gradient(rgba(0,212,255,0.015) 1px,transparent 1px),linear-gradient(90deg,rgba(0,212,255,0.015) 1px,transparent 1px);background-size:40px 40px;pointer-events:none;z-index:0;}

/* LOGIN */
.login-screen{position:fixed;inset:0;z-index:1000;background:var(--bg);display:flex;align-items:center;justify-content:center;}
.login-box{background:var(--panel);border:1px solid var(--border);padding:3.5rem;width:100%;max-width:420px;position:relative;}
.login-box::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--accent3),var(--accent));}
.login-logo{font-family:'Orbitron',monospace;font-size:1.3rem;font-weight:900;color:var(--accent);text-align:center;margin-bottom:0.4rem;}
.login-logo span{color:var(--accent2);}
.login-sub{font-family:'Share Tech Mono',monospace;font-size:0.65rem;color:var(--text-dim);text-align:center;letter-spacing:3px;text-transform:uppercase;margin-bottom:2.5rem;}
.login-field{margin-bottom:1.2rem;}
.login-field label{display:block;font-family:'Share Tech Mono',monospace;font-size:0.65rem;color:var(--text-dim);letter-spacing:2px;text-transform:uppercase;margin-bottom:0.5rem;}
.login-field input{width:100%;background:rgba(0,0,0,0.4);border:1px solid var(--border);border-bottom:1px solid rgba(0,212,255,0.2);color:var(--text);padding:0.85rem 1rem;font-family:'Rajdhani',sans-serif;font-size:1rem;outline:none;transition:all 0.3s;}
.login-field input:focus{border-color:var(--accent);}
.login-btn{width:100%;background:var(--accent3);color:#fff;border:none;padding:1rem;font-family:'Orbitron',monospace;font-size:0.8rem;font-weight:700;letter-spacing:2px;cursor:pointer;text-transform:uppercase;margin-top:0.5rem;clip-path:polygon(0 0,calc(100% - 10px) 0,100% 10px,100% 100%,10px 100%,0 calc(100% - 10px));}
.login-btn:hover{opacity:0.85;}
.login-err{display:none;font-family:'Share Tech Mono',monospace;font-size:0.72rem;color:var(--accent3);text-align:center;margin-top:1rem;letter-spacing:1px;}

/* LAYOUT */
.admin-layout{display:none;min-height:100vh;position:relative;z-index:2;}
.sidebar{position:fixed;left:0;top:0;bottom:0;width:240px;background:var(--panel);border-right:1px solid var(--border);display:flex;flex-direction:column;z-index:50;}
.sidebar-logo{padding:1.5rem 1.5rem 1rem;border-bottom:1px solid var(--border);}
.sidebar-logo .logo-text{font-family:'Orbitron',monospace;font-size:1rem;font-weight:900;color:var(--accent);}
.sidebar-logo .logo-text span{color:var(--accent2);}
.sidebar-logo .admin-tag{font-family:'Share Tech Mono',monospace;font-size:0.6rem;color:var(--accent3);letter-spacing:3px;text-transform:uppercase;margin-top:0.2rem;display:block;}
.sidebar nav{flex:1;padding:1.5rem 0;}
.nav-item{display:flex;align-items:center;gap:0.8rem;padding:0.85rem 1.5rem;cursor:pointer;transition:all 0.2s;border-left:3px solid transparent;font-family:'Share Tech Mono',monospace;font-size:0.75rem;color:var(--text-dim);letter-spacing:1px;text-transform:uppercase;}
.nav-item:hover{color:var(--accent);background:rgba(0,212,255,0.03);}
.nav-item.active{color:var(--accent);border-left-color:var(--accent);background:rgba(0,212,255,0.05);}
.badge{margin-left:auto;background:var(--accent3);color:#fff;font-size:0.6rem;padding:0.1rem 0.5rem;min-width:20px;text-align:center;font-family:'Orbitron',monospace;}
.sidebar-footer{padding:1.5rem;border-top:1px solid var(--border);}
.logout-btn{width:100%;background:transparent;border:1px solid rgba(255,60,110,0.3);color:var(--accent3);padding:0.7rem;font-family:'Share Tech Mono',monospace;font-size:0.65rem;letter-spacing:2px;cursor:pointer;text-transform:uppercase;}
.logout-btn:hover{background:rgba(255,60,110,0.1);}
.main-content{margin-left:240px;padding:2rem;min-height:100vh;}
.topbar{display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;}
.topbar h1{font-family:'Orbitron',monospace;font-size:1.3rem;font-weight:700;color:var(--text);}
.topbar h1 span{color:var(--accent);}
.topbar-meta{font-family:'Share Tech Mono',monospace;font-size:0.7rem;color:var(--text-dim);}

/* STATS */
.stat-cards{display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:2rem;}
.stat-card{background:var(--panel);border:1px solid var(--border);padding:1.5rem;position:relative;overflow:hidden;}
.stat-card::after{content:'';position:absolute;bottom:0;left:0;height:2px;width:100%;}
.stat-card:nth-child(1)::after{background:var(--accent);}
.stat-card:nth-child(2)::after{background:var(--accent2);}
.stat-card:nth-child(3)::after{background:var(--warn);}
.stat-card:nth-child(4)::after{background:var(--accent3);}
.s-label{font-family:'Share Tech Mono',monospace;font-size:0.62rem;color:var(--text-dim);letter-spacing:2px;text-transform:uppercase;margin-bottom:0.8rem;display:block;}
.s-num{font-family:'Orbitron',monospace;font-size:2.2rem;font-weight:900;display:block;line-height:1;}
.stat-card:nth-child(1) .s-num{color:var(--accent);}
.stat-card:nth-child(2) .s-num{color:var(--accent2);}
.stat-card:nth-child(3) .s-num{color:var(--warn);}
.stat-card:nth-child(4) .s-num{color:var(--accent3);}

/* PANELS */
.panel-section{display:none;}
.panel-section.active{display:block;}
.data-panel{background:var(--panel);border:1px solid var(--border);margin-bottom:1.5rem;}
.panel-header{display:flex;align-items:center;justify-content:space-between;padding:1.2rem 1.5rem;border-bottom:1px solid var(--border);background:rgba(0,212,255,0.02);}
.panel-header h2{font-family:'Orbitron',monospace;font-size:0.85rem;font-weight:700;color:var(--text);letter-spacing:1px;text-transform:uppercase;}
.panel-count{font-family:'Share Tech Mono',monospace;font-size:0.7rem;color:var(--text-dim);}

/* BOOKING CARDS */
.booking-card{padding:1.5rem;border-bottom:1px solid rgba(10,42,74,0.5);cursor:pointer;transition:background 0.2s;display:grid;grid-template-columns:1fr auto;gap:1rem;align-items:start;}
.booking-card:hover{background:rgba(0,212,255,0.02);}
.client-name{font-size:1.1rem;font-weight:700;color:var(--text);margin-bottom:0.2rem;}
.client-email{font-family:'Share Tech Mono',monospace;font-size:0.68rem;color:var(--text-dim);margin-bottom:0.3rem;}
.booking-msg{font-size:0.9rem;color:var(--text-dim);font-style:italic;margin-top:0.3rem;}
.booking-date{font-family:'Share Tech Mono',monospace;font-size:0.65rem;color:var(--text-dim);}
.urgency-badge{display:inline-block;padding:0.2rem 0.7rem;font-family:'Share Tech Mono',monospace;font-size:0.6rem;letter-spacing:1px;text-transform:uppercase;}
.urgency-badge.standard{background:rgba(0,212,255,0.1);color:var(--accent);border:1px solid rgba(0,212,255,0.2);}
.urgency-badge.priority{background:rgba(255,170,0,0.1);color:var(--warn);border:1px solid rgba(255,170,0,0.2);}
.urgency-badge.emergency{background:rgba(255,60,110,0.1);color:var(--accent3);border:1px solid rgba(255,60,110,0.2);}
.empty-state{padding:3rem;text-align:center;font-family:'Share Tech Mono',monospace;font-size:0.8rem;color:var(--text-dim);letter-spacing:2px;}

/* SESSIONS */
.session-item{display:grid;grid-template-columns:200px 1fr auto;gap:1.5rem;align-items:start;padding:1.2rem 1.5rem;border-bottom:1px solid rgba(10,42,74,0.5);cursor:pointer;transition:background 0.2s;}
.session-item:hover{background:rgba(0,212,255,0.02);}
.session-user strong{display:block;font-size:1rem;color:var(--text);margin-bottom:0.2rem;}
.s-email{font-family:'Share Tech Mono',monospace;font-size:0.65rem;color:var(--text-dim);display:block;}
.session-preview{font-size:0.85rem;color:var(--text-dim);font-style:italic;}
.session-meta{font-family:'Share Tech Mono',monospace;font-size:0.65rem;color:var(--text-dim);text-align:right;white-space:nowrap;}
.msg-count{display:block;color:var(--accent);font-size:0.8rem;font-family:'Orbitron',monospace;margin-bottom:0.3rem;}

/* MODAL */
.modal-overlay{display:none;position:fixed;inset:0;background:rgba(2,6,9,0.88);z-index:200;align-items:center;justify-content:center;backdrop-filter:blur(4px);}
.modal-overlay.open{display:flex;}
.modal{background:var(--panel);border:1px solid var(--border);width:100%;max-width:700px;height:82vh;display:flex;flex-direction:column;position:relative;}
.modal::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--accent2),var(--accent));}
.modal-header{display:flex;align-items:center;justify-content:space-between;padding:1.2rem 1.5rem;border-bottom:1px solid var(--border);flex-shrink:0;}
.modal-header h3{font-family:'Orbitron',monospace;font-size:0.85rem;color:var(--text);}
.modal-header-meta{font-family:'Share Tech Mono',monospace;font-size:0.65rem;color:var(--text-dim);margin-top:0.2rem;}
.modal-close{background:none;border:1px solid var(--border);color:var(--text-dim);width:30px;height:30px;cursor:pointer;font-size:1rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.modal-close:hover{border-color:var(--accent3);color:var(--accent3);}
.modal-body{flex:1;overflow-y:auto;padding:1.5rem;display:flex;flex-direction:column;gap:0.8rem;scrollbar-width:thin;}

/* BOOKING DETAIL */
.detail-section{margin-bottom:1.5rem;}
.detail-title{font-family:'Share Tech Mono',monospace;font-size:0.65rem;color:var(--accent);letter-spacing:3px;text-transform:uppercase;margin-bottom:0.8rem;padding-bottom:0.4rem;border-bottom:1px solid var(--border);}
.detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:0.8rem;}
.detail-item label{display:block;font-family:'Share Tech Mono',monospace;font-size:0.6rem;color:var(--text-dim);letter-spacing:2px;text-transform:uppercase;margin-bottom:0.2rem;}
.detail-item value{display:block;font-size:1rem;color:var(--text);}
.detail-msg{background:rgba(0,0,0,0.2);border:1px solid var(--border);padding:1rem;font-size:0.95rem;color:var(--text-dim);line-height:1.6;margin-top:0.5rem;}
.file-block{background:rgba(0,212,255,0.02);border:1px solid rgba(0,212,255,0.1);padding:0.8rem 1rem;margin-bottom:0.5rem;}
.file-top{display:flex;align-items:center;gap:0.8rem;}
.file-name-text{flex:1;font-size:0.9rem;color:var(--text);}
.file-size-text{font-family:'Share Tech Mono',monospace;font-size:0.65rem;color:var(--text-dim);}
.file-actions{display:flex;gap:0.5rem;align-items:center;flex-wrap:wrap;}
.btn-preview{background:none;border:1px solid rgba(0,212,255,0.3);color:var(--accent);padding:0.25rem 0.7rem;font-family:'Share Tech Mono',monospace;font-size:0.62rem;letter-spacing:1px;cursor:pointer;text-transform:uppercase;}
.btn-download{background:var(--accent2);color:var(--bg);padding:0.25rem 0.7rem;font-family:'Share Tech Mono',monospace;font-size:0.62rem;letter-spacing:1px;text-decoration:none;text-transform:uppercase;display:inline-block;}
.file-preview{display:none;margin-top:0.8rem;border:1px solid var(--border);background:rgba(0,0,0,0.3);}
.file-preview.open{display:block;}
.file-preview iframe{width:100%;height:380px;border:none;background:#fff;}
.file-preview img{width:100%;max-height:380px;object-fit:contain;display:block;}
.file-preview pre{padding:1rem;font-family:monospace;font-size:0.75rem;color:var(--text-dim);line-height:1.6;max-height:280px;overflow-y:auto;white-space:pre-wrap;word-break:break-all;}
.prev-msg{padding:1rem;text-align:center;font-family:'Share Tech Mono',monospace;font-size:0.72rem;color:var(--text-dim);letter-spacing:2px;}

/* CHAT MESSAGES */
.chat-msg{display:flex;flex-direction:column;max-width:80%;}
.chat-msg.user{align-self:flex-end;}
.chat-msg.agent{align-self:flex-start;}
.m-sender{font-family:'Share Tech Mono',monospace;font-size:0.62rem;letter-spacing:1px;text-transform:uppercase;margin-bottom:0.2rem;}
.chat-msg.agent .m-sender{color:var(--accent2);}
.chat-msg.user .m-sender{color:var(--accent);text-align:right;}
.bubble{padding:0.7rem 1rem;font-size:0.95rem;line-height:1.5;}
.chat-msg.user .bubble{background:rgba(0,212,255,0.08);border:1px solid rgba(0,212,255,0.2);}
.chat-msg.agent .bubble{background:rgba(8,20,37,0.8);border:1px solid var(--border);}
.m-meta{font-family:'Share Tech Mono',monospace;font-size:0.6rem;color:var(--text-dim);margin-top:0.2rem;}
.chat-msg.user .m-meta{text-align:right;}

/* REPLY */
.modal-reply{display:flex;flex-shrink:0;border-top:1px solid var(--border);}
.modal-reply input{flex:1;background:rgba(0,0,0,0.3);border:none;color:var(--text);padding:1rem 1.5rem;font-family:'Rajdhani',sans-serif;font-size:1rem;outline:none;}
.modal-reply input::placeholder{color:var(--text-dim);font-style:italic;}
.modal-reply button{background:var(--accent2);color:var(--bg);border:none;padding:0 2rem;font-family:'Orbitron',monospace;font-size:0.7rem;font-weight:700;letter-spacing:2px;cursor:pointer;text-transform:uppercase;}

/* BTNS */
.del-btn{background:none;border:1px solid rgba(255,60,110,0.3);color:var(--accent3);padding:0.3rem 0.8rem;font-family:'Share Tech Mono',monospace;font-size:0.6rem;letter-spacing:1px;cursor:pointer;}
.del-btn:hover{background:rgba(255,60,110,0.1);}
.refresh-btn{background:none;border:1px solid var(--border);color:var(--text-dim);padding:0.3rem 0.8rem;font-family:'Share Tech Mono',monospace;font-size:0.6rem;letter-spacing:1px;cursor:pointer;}
.refresh-btn:hover{border-color:var(--accent);color:var(--accent);}

/* USERS TABLE */
.users-table{width:100%;}
.users-row{display:grid;grid-template-columns:1fr 1.5fr 1fr auto;gap:1rem;padding:1rem 1.5rem;border-bottom:1px solid rgba(10,42,74,0.5);align-items:center;}
.users-row.header{background:rgba(0,0,0,0.2);border-bottom:1px solid var(--border);}
.users-row.header span{font-family:'Share Tech Mono',monospace;font-size:0.62rem;color:var(--text-dim);letter-spacing:2px;text-transform:uppercase;}
.users-row .u-name{font-size:1rem;font-weight:700;color:var(--text);}
.users-row .u-id{font-family:'Share Tech Mono',monospace;font-size:0.6rem;color:var(--text-dim);}
.users-row .u-email{font-family:'Share Tech Mono',monospace;font-size:0.75rem;color:var(--text-dim);}
.users-row .u-date{font-family:'Share Tech Mono',monospace;font-size:0.65rem;color:var(--text-dim);}
</style>
</head>
<body>

<!-- LOGIN SCREEN -->
<div class="login-screen" id="loginScreen">
  <div class="login-box">
    <div class="login-logo">Cyber<span>Shield</span></div>
    <div class="login-sub">Admin Access Portal</div>
    <div class="login-field">
      <label>Username</label>
      <input type="text" id="adminUser" placeholder="admin" autocomplete="username">
    </div>
    <div class="login-field">
      <label>Password</label>
      <input type="password" id="adminPass" placeholder="password" autocomplete="current-password">
    </div>
    <button class="login-btn" id="loginBtn">&#9658; ACCESS PANEL</button>
    <div class="login-err" id="loginErr">&#9888; INVALID CREDENTIALS</div>
  </div>
</div>

<!-- ADMIN LAYOUT -->
<div class="admin-layout" id="adminLayout">
  <div class="sidebar">
    <div class="sidebar-logo">
      <div class="logo-text">Cyber<span>Shield</span></div>
      <span class="admin-tag">// Admin Console</span>
    </div>
    <nav>
      <div class="nav-item active" id="nav-dashboard">&#11041; Dashboard</div>
      <div class="nav-item" id="nav-bookings">&#128203; Bookings <span class="badge" id="bookingBadge">0</span></div>
      <div class="nav-item" id="nav-chats">&#128172; Live Chats <span class="badge" id="chatBadge">0</span></div>
      <div class="nav-item" id="nav-users">&#128100; Accounts <span class="badge" id="userBadge">0</span></div>
    </nav>
    <div class="sidebar-footer">
      <button class="logout-btn" id="logoutBtn">&#11041; LOG OUT</button>
    </div>
  </div>

  <div class="main-content">
    <div class="topbar">
      <h1>Admin <span>Console</span></h1>
      <div class="topbar-meta" id="topbarTime">--</div>
    </div>

    <!-- DASHBOARD -->
    <div class="panel-section active" id="tab-dashboard">
      <div class="stat-cards">
        <div class="stat-card"><span class="s-label">Total Bookings</span><span class="s-num" id="statBookings">0</span></div>
        <div class="stat-card"><span class="s-label">Chat Sessions</span><span class="s-num" id="statChats">0</span></div>
        <div class="stat-card"><span class="s-label">Registered Users</span><span class="s-num" id="statUsers">0</span></div>
        <div class="stat-card"><span class="s-label">Emergency</span><span class="s-num" id="statEmergency">0</span></div>
      </div>
      <div class="data-panel">
        <div class="panel-header"><h2>Recent Bookings</h2><span class="panel-count" id="recentCount">--</span></div>
        <div id="recentBookings"></div>
      </div>
    </div>

    <!-- BOOKINGS -->
    <div class="panel-section" id="tab-bookings">
      <div class="data-panel">
        <div class="panel-header">
          <h2>All Booking Requests</h2>
          <div style="display:flex;gap:0.5rem">
            <button class="refresh-btn" id="refreshBookings">&#8635; Refresh</button>
            <button class="del-btn" id="clearBookingsBtn">&#10005; Clear All</button>
          </div>
        </div>
        <div id="bookingsList"></div>
        <div class="empty-state" id="bookingsEmpty" style="display:none">NO BOOKING REQUESTS YET</div>
      </div>
    </div>

    <!-- CHATS -->
    <div class="panel-section" id="tab-chats">
      <div class="data-panel">
        <div class="panel-header">
          <h2>Live Chat Sessions</h2>
          <button class="refresh-btn" id="refreshChats">&#8635; Refresh</button>
        </div>
        <div id="sessionList"></div>
        <div class="empty-state" id="chatsEmpty" style="display:none">NO CHAT SESSIONS YET</div>
      </div>
    </div>

    <!-- USERS -->
    <div class="panel-section" id="tab-users">
      <div class="data-panel">
        <div class="panel-header">
          <h2>Registered Accounts</h2>
          <span class="panel-count" id="userCount">--</span>
        </div>
        <div id="usersList"></div>
        <div class="empty-state" id="usersEmpty" style="display:none">NO REGISTERED USERS YET</div>
      </div>
    </div>
  </div>
</div>

<!-- MODAL -->
<div class="modal-overlay" id="mainModal">
  <div class="modal">
    <div class="modal-header">
      <div>
        <h3 id="modalTitle">Detail</h3>
        <div class="modal-header-meta" id="modalMeta"></div>
      </div>
      <button class="modal-close" id="modalCloseBtn">&#10005;</button>
    </div>
    <div class="modal-body" id="modalBody"></div>
    <div class="modal-reply" id="modalReply" style="display:none">
      <input type="text" id="replyInput" placeholder="Type your reply as CyberShield Support...">
      <button id="replyBtn">Reply &#9658;</button>
    </div>
  </div>
</div>

<script>
// ---- CHANGE ADMIN CREDENTIALS HERE ----
var ADMIN_USER = 'frog';
var ADMIN_PASS = 'Mypassword';
// ----------------------------------------

var BACKEND = 'chat_backend.php';
var UPLOAD  = 'get_bookings.php';
var activeSessionId = '';
var modalLastTs = 0;
var modalPolling = false;
var modalMode = '';

// ---- EVENT LISTENERS ----
document.getElementById('loginBtn').addEventListener('click', doLogin);
document.getElementById('adminUser').addEventListener('keydown', function(e){ if(e.key==='Enter') doLogin(); });
document.getElementById('adminPass').addEventListener('keydown', function(e){ if(e.key==='Enter') doLogin(); });
document.getElementById('logoutBtn').addEventListener('click', doLogout);
document.getElementById('nav-dashboard').addEventListener('click', function(){ switchTab('dashboard',this); });
document.getElementById('nav-bookings').addEventListener('click', function(){ switchTab('bookings',this); });
document.getElementById('nav-chats').addEventListener('click', function(){ switchTab('chats',this); });
document.getElementById('nav-users').addEventListener('click', function(){ switchTab('users',this); });
document.getElementById('modalCloseBtn').addEventListener('click', closeModal);
document.getElementById('replyBtn').addEventListener('click', sendReply);
document.getElementById('replyInput').addEventListener('keydown', function(e){ if(e.key==='Enter') sendReply(); });
document.getElementById('refreshBookings').addEventListener('click', loadAll);
document.getElementById('refreshChats').addEventListener('click', loadAll);
document.getElementById('clearBookingsBtn').addEventListener('click', clearBookings);

// ---- AUTH ----
function doLogin() {
  var u = document.getElementById('adminUser').value;
  var p = document.getElementById('adminPass').value;
  if (u === ADMIN_USER && p === ADMIN_PASS) {
    document.getElementById('loginScreen').style.display = 'none';
    document.getElementById('adminLayout').style.display = 'flex';
    loadAll();
    setInterval(loadAll, 8000);
  } else {
    document.getElementById('loginErr').style.display = 'block';
    document.getElementById('adminPass').value = '';
  }
}

function doLogout() {
  document.getElementById('loginScreen').style.display = 'flex';
  document.getElementById('adminLayout').style.display = 'none';
}

// ---- TABS ----
function switchTab(name, el) {
  document.querySelectorAll('.panel-section').forEach(function(p){ p.classList.remove('active'); });
  document.querySelectorAll('.nav-item').forEach(function(n){ n.classList.remove('active'); });
  document.getElementById('tab-'+name).classList.add('active');
  el.classList.add('active');
}

// ---- LOAD ALL DATA ----
async function loadAll() {
  document.getElementById('topbarTime').textContent = 'Updated: ' + new Date().toLocaleTimeString();

  // Bookings
  try {
    var bRes = await fetch(UPLOAD + '?action=get_bookings');
    var bData = await bRes.json();
    var bookings = bData.bookings || [];
    var emergency = bookings.filter(function(b){ return b.urgency==='emergency'; }).length;
    document.getElementById('statBookings').textContent = bookings.length;
    document.getElementById('statEmergency').textContent = emergency;
    document.getElementById('bookingBadge').textContent = bookings.length;
    document.getElementById('recentCount').textContent = bookings.length + ' total';
    renderBookings(bookings.slice().reverse().slice(0,5), 'recentBookings');
    renderBookings(bookings.slice().reverse(), 'bookingsList');
    document.getElementById('bookingsEmpty').style.display = bookings.length===0 ? 'block':'none';
  } catch(e) {
    document.getElementById('bookingsEmpty').style.display = 'block';
    document.getElementById('bookingsEmpty').textContent = 'Could not load bookings.';
  }

  // Chats
  try {
    var cRes = await fetch(BACKEND + '?action=sessions');
    var cData = await cRes.json();
    var sessions = cData.sessions || [];
    document.getElementById('statChats').textContent = sessions.length;
    document.getElementById('chatBadge').textContent = sessions.length;
    renderSessions(sessions);
    document.getElementById('chatsEmpty').style.display = sessions.length===0 ? 'block':'none';
  } catch(e) {
    document.getElementById('chatsEmpty').style.display = 'block';
    document.getElementById('chatsEmpty').textContent = 'Could not load chats.';
  }

  // Users
  try {
    var uRes = await fetch('user_auth.php?action=list_users');
    var uData = await uRes.json();
    var users = uData.users || [];
    document.getElementById('statUsers').textContent = users.length;
    document.getElementById('userBadge').textContent = users.length;
    document.getElementById('userCount').textContent = users.length + ' total';
    renderUsers(users);
    document.getElementById('usersEmpty').style.display = users.length===0 ? 'block':'none';
  } catch(e) {}
}

// ---- RENDER BOOKINGS ----
function renderBookings(bookings, targetId) {
  var el = document.getElementById(targetId);
  el.innerHTML = '';
  if (!bookings.length) {
    el.innerHTML = '<div class="empty-state">NO BOOKINGS YET</div>';
    return;
  }
  bookings.forEach(function(b) {
    var card = document.createElement('div');
    card.className = 'booking-card';
    card.innerHTML = '<div>'
      + '<div class="client-name">' + esc(b.fname) + ' ' + esc(b.lname) + '</div>'
      + '<div class="client-email">' + esc(b.email) + ' &bull; ' + esc(b.company) + '</div>'
      + '<div style="font-family:monospace;font-size:0.68rem;color:var(--text-dim)">' + esc(b.service) + '</div>'
      + (b.message ? '<div class="booking-msg">' + esc(b.message.substring(0,100)) + '</div>' : '')
      + '</div>'
      + '<div style="display:flex;flex-direction:column;align-items:flex-end;gap:0.5rem">'
      + '<span class="urgency-badge ' + (b.urgency||'standard') + '">' + (b.urgency||'standard') + '</span>'
      + '<span class="booking-date">' + fmtDate(b.date) + '</span>'
      + '</div>';
    card.addEventListener('click', function(){ openBooking(b); });
    el.appendChild(card);
  });
}

// ---- BOOKING DETAIL MODAL ----
function openBooking(b) {
  modalMode = 'booking';
  modalPolling = false;
  document.getElementById('modalTitle').textContent = b.fname + ' ' + b.lname;
  document.getElementById('modalMeta').textContent = b.email + ' - ' + b.company;
  document.getElementById('modalReply').style.display = 'none';
  var body = document.getElementById('modalBody');
  body.innerHTML = '';

  // Client info
  var s1 = document.createElement('div');
  s1.className = 'detail-section';
  s1.innerHTML = '<div class="detail-title">Client Information</div>'
    + '<div class="detail-grid">'
    + '<div class="detail-item"><label>Full Name</label><value>' + esc(b.fname) + ' ' + esc(b.lname) + '</value></div>'
    + '<div class="detail-item"><label>Email</label><value>' + esc(b.email) + '</value></div>'
    + '<div class="detail-item"><label>Company</label><value>' + esc(b.company) + '</value></div>'
    + '<div class="detail-item"><label>Date</label><value>' + fmtDate(b.date) + '</value></div>'
    + '</div>';
  body.appendChild(s1);

  // Service
  var s2 = document.createElement('div');
  s2.className = 'detail-section';
  s2.innerHTML = '<div class="detail-title">Service Request</div>'
    + '<div class="detail-grid">'
    + '<div class="detail-item"><label>Service</label><value>' + esc(b.service) + '</value></div>'
    + '<div class="detail-item"><label>Urgency</label><value><span class="urgency-badge ' + (b.urgency||'standard') + '">' + (b.urgency||'standard') + '</span></value></div>'
    + '</div>'
    + (b.message ? '<div class="detail-msg">' + esc(b.message) + '</div>' : '');
  body.appendChild(s2);

  // Files
  var files = b.files || [];
  var s3 = document.createElement('div');
  s3.className = 'detail-section';
  s3.innerHTML = '<div class="detail-title">Attached Files (' + files.length + ')</div>';
  if (!files.length) {
    s3.innerHTML += '<div style="font-family:monospace;font-size:0.72rem;color:var(--text-dim)">No files attached</div>';
  } else {
    files.forEach(function(f, fi) {
      var block = document.createElement('div');
      block.className = 'file-block';
      var prevId = 'prev-' + fi + '-' + Date.now();
      var ext = (f.name||'').split('.').pop().toLowerCase();
      var canPreview = ['jpg','jpeg','png','gif','pdf','txt','csv','json'].indexOf(ext) !== -1;
      var top = document.createElement('div');
      top.className = 'file-top';
      top.innerHTML = '<span>' + getFileIcon(f.name) + '</span>'
        + '<span class="file-name-text">' + esc(f.name) + '</span>'
        + (f.size ? '<span class="file-size-text">' + formatSize(f.size) + '</span>' : '');
      var actions = document.createElement('div');
      actions.className = 'file-actions';
      if (canPreview) {
        var pb = document.createElement('button');
        pb.className = 'btn-preview';
        pb.textContent = 'Preview';
        var fu = 'uploads/' + f.saved_as;
        var fn = f.name;
        pb.addEventListener('click', function(){ togglePreview(prevId, fu, fn); });
        actions.appendChild(pb);
      }
      var dl = document.createElement('a');
      dl.className = 'btn-download';
      dl.href = 'uploads/' + f.saved_as;
      dl.download = f.name;
      dl.target = '_blank';
      dl.textContent = 'Download';
      actions.appendChild(dl);
      top.appendChild(actions);
      block.appendChild(top);
      if (canPreview) {
        var pbox = document.createElement('div');
        pbox.className = 'file-preview';
        pbox.id = prevId;
        pbox.innerHTML = '<div class="prev-msg">Click Preview to load</div>';
        block.appendChild(pbox);
      }
      s3.appendChild(block);
    });
  }
  body.appendChild(s3);
  document.getElementById('mainModal').classList.add('open');
}

// ---- SESSIONS ----
function renderSessions(sessions) {
  var list = document.getElementById('sessionList');
  list.innerHTML = '';
  if (!sessions.length) return;
  sessions.forEach(function(s) {
    var item = document.createElement('div');
    item.className = 'session-item';
    item.innerHTML = '<div class="session-user">'
      + '<strong>' + esc(s.name) + '</strong>'
      + '<span class="s-email">' + esc(s.email||'No email') + '</span>'
      + '<span class="s-email">' + esc(s.session_id) + '</span>'
      + '</div>'
      + '<div class="session-preview">"' + esc((s.last_msg||'No messages').substring(0,100)) + '"</div>'
      + '<div class="session-meta"><span class="msg-count">' + s.msg_count + ' msgs</span>' + fmtDate(s.started) + '</div>';
    var db = document.createElement('button');
    db.className = 'del-btn';
    db.textContent = 'Delete';
    db.style.marginTop = '0.5rem';
    db.addEventListener('click', function(e){ e.stopPropagation(); deleteSession(s.session_id); });
    item.querySelector('.session-meta').appendChild(db);
    var sid = s.session_id; var sname = s.name;
    item.addEventListener('click', function(){ openChat(sid, sname); });
    list.appendChild(item);
  });
}

// ---- CHAT MODAL ----
async function openChat(sessionId, name) {
  modalMode = 'chat';
  activeSessionId = sessionId;
  modalLastTs = 0;
  document.getElementById('modalTitle').textContent = 'Chat - ' + name;
  document.getElementById('modalMeta').textContent = sessionId;
  document.getElementById('modalReply').style.display = 'flex';
  document.getElementById('modalBody').innerHTML = '';
  document.getElementById('mainModal').classList.add('open');
  document.getElementById('replyInput').focus();
  try {
    var res = await fetch(BACKEND + '?action=sessions');
    var data = await res.json();
    var session = (data.sessions||[]).find(function(s){ return s.session_id===sessionId; });
    if (session && session.messages) {
      session.messages.forEach(renderChatMsg);
      if (session.messages.length) modalLastTs = session.messages[session.messages.length-1].ts;
    }
  } catch(e) {}
  modalPolling = true;
  pollModal();
}

function renderChatMsg(msg) {
  var div = document.createElement('div');
  div.className = 'chat-msg ' + msg.role;
  div.innerHTML = '<div class="m-sender">' + esc(msg.sender) + '</div>'
    + '<div class="bubble">' + esc(msg.text) + '</div>'
    + '<div class="m-meta">' + (msg.time||'') + '</div>';
  document.getElementById('modalBody').appendChild(div);
  document.getElementById('modalBody').scrollTop = 99999;
}

async function pollModal() {
  while (modalPolling && activeSessionId && modalMode==='chat') {
    try {
      var res = await fetch(BACKEND + '?action=poll&session_id=' + activeSessionId + '&since=' + modalLastTs);
      var data = await res.json();
      if (data.ok && data.messages && data.messages.length > 0) {
        data.messages.forEach(renderChatMsg);
        modalLastTs = data.messages[data.messages.length-1].ts;
      }
    } catch(e) { await sleep(3000); }
  }
}

async function sendReply() {
  var input = document.getElementById('replyInput');
  var text = input.value.trim();
  if (!text || !activeSessionId) return;
  input.value = '';
  await fetch(BACKEND + '?action=send', {
    method:'POST', headers:{'Content-Type':'application/json'},
    body: JSON.stringify({session_id:activeSessionId, role:'agent', sender:'CyberShield Support', text:text})
  });
}

function closeModal() {
  modalPolling = false; activeSessionId = ''; modalMode = '';
  document.getElementById('mainModal').classList.remove('open');
}

async function deleteSession(sid) {
  if (!confirm('Delete this chat session?')) return;
  await fetch(BACKEND + '?action=delete&session_id=' + sid);
  loadAll();
}

function clearBookings() {
  if (!confirm('Delete all bookings?')) return;
  fetch(UPLOAD + '?action=clear').then(function(){ loadAll(); });
}

// ---- USERS ----
function renderUsers(users) {
  var el = document.getElementById('usersList');
  el.innerHTML = '';
  if (!users.length) return;
  var header = document.createElement('div');
  header.className = 'users-row header';
  header.innerHTML = '<span>Username</span><span>Email</span><span>Registered</span><span></span>';
  el.appendChild(header);
  users.forEach(function(u) {
    var row = document.createElement('div');
    row.className = 'users-row';
    row.innerHTML = '<div><div class="u-name">' + esc(u.username) + '</div><div class="u-id">' + esc(u.id) + '</div></div>'
      + '<div class="u-email">' + esc(u.email) + '</div>'
      + '<div class="u-date">' + fmtDate(u.created_at) + '</div>';
    var db = document.createElement('button');
    db.className = 'del-btn';
    db.textContent = 'Delete';
    db.addEventListener('click', function(){ deleteUser(u.id); });
    row.appendChild(db);
    el.appendChild(row);
  });
}

async function deleteUser(userId) {
  if (!confirm('Delete this user account?')) return;
  var fd = new FormData();
  fd.append('action', 'delete_user');
  fd.append('user_id', userId);
  await fetch('user_auth.php', {method:'POST', body:fd});
  loadAll();
}

// ---- PREVIEW ----
function togglePreview(pid, url, filename) {
  var box = document.getElementById(pid);
  if (!box) return;
  if (box.classList.contains('open')) { box.classList.remove('open'); return; }
  box.classList.add('open');
  var ext = filename.split('.').pop().toLowerCase();
  if (['jpg','jpeg','png','gif'].indexOf(ext) !== -1) {
    box.innerHTML = '<img src="' + url + '" alt="preview">';
  } else if (ext === 'pdf') {
    box.innerHTML = '<iframe src="' + url + '#toolbar=0" title="preview"></iframe>';
  } else if (['txt','csv','json','xml','md'].indexOf(ext) !== -1) {
    box.innerHTML = '<div class="prev-msg">Loading...</div>';
    fetch(url).then(function(r){ return r.text(); }).then(function(t){
      box.innerHTML = '<pre>' + t.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').substring(0,5000) + '</pre>';
    }).catch(function(){ box.innerHTML = '<div class="prev-msg">Could not load file</div>'; });
  } else {
    box.innerHTML = '<div class="prev-msg">No preview available for this file type</div>';
  }
}

// ---- HELPERS ----
function fmtDate(s) { try { return new Date(s).toLocaleString(); } catch(e) { return s||'--'; } }
function esc(s) { return String(s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }
function sleep(ms) { return new Promise(function(r){ setTimeout(r,ms); }); }
function formatSize(b) {
  if (!b) return '';
  if (b < 1024) return b + ' B';
  if (b < 1048576) return (b/1024).toFixed(1) + ' KB';
  return (b/1048576).toFixed(1) + ' MB';
}
function getFileIcon(name) {
  var ext = (name||'').split('.').pop().toLowerCase();
  var m = {pdf:'[PDF]',doc:'[DOC]',docx:'[DOC]',xls:'[XLS]',xlsx:'[XLS]',txt:'[TXT]',jpg:'[IMG]',jpeg:'[IMG]',png:'[IMG]',gif:'[IMG]',zip:'[ZIP]'};
  return m[ext]||'[FILE]';
}
</script>
</body>
</html>
