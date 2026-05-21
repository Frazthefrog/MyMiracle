<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Live Chat – CyberShield Consulting</title>
<link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Rajdhani:wght@300;400;600;700&family=Orbitron:wght@400;700;900&display=swap" rel="stylesheet">
<style>
  :root {
    --bg: #030810; --bg2: #050d1a; --panel: #081425; --border: #0a2a4a;
    --accent: #00d4ff; --accent2: #00ff88; --accent3: #ff3c6e;
    --text: #c8dff0; --text-dim: #4a6a8a; --glow: 0 0 20px rgba(0,212,255,0.3);
  }
  * { margin:0; padding:0; box-sizing:border-box; }
  body { background:var(--bg); color:var(--text); font-family:'Rajdhani',sans-serif; height:100vh; display:flex; flex-direction:column; overflow:hidden; }
  body::before { content:''; position:fixed; inset:0; background-image:linear-gradient(rgba(0,212,255,0.02) 1px,transparent 1px),linear-gradient(90deg,rgba(0,212,255,0.02) 1px,transparent 1px); background-size:50px 50px; pointer-events:none; z-index:0; }
  header { position:relative; z-index:10; display:flex; align-items:center; justify-content:space-between; padding:0 2rem; height:65px; background:rgba(3,8,16,0.95); border-bottom:1px solid var(--border); flex-shrink:0; }
  .logo { font-family:'Orbitron',monospace; font-size:1.1rem; font-weight:900; color:var(--accent); text-decoration:none; }
  .logo span { color:#00ff88; }
  .chat-status { display:flex; align-items:center; gap:0.6rem; font-family:'Share Tech Mono',monospace; font-size:0.72rem; color:var(--accent2); letter-spacing:2px; }
  .status-dot { width:8px; height:8px; border-radius:50%; background:var(--accent2); animation:pulse 2s infinite; }
  @keyframes pulse { 0%,100%{opacity:1;box-shadow:0 0 6px var(--accent2);}50%{opacity:0.4;box-shadow:none;} }
  .back-btn { font-family:'Share Tech Mono',monospace; font-size:0.7rem; color:var(--text-dim); text-decoration:none; letter-spacing:2px; transition:color 0.3s; }
  .back-btn:hover { color:var(--accent); }
  .chat-wrapper { position:relative; z-index:2; flex:1; display:flex; flex-direction:column; max-width:820px; width:100%; margin:0 auto; padding:0 1.5rem; overflow:hidden; }
  .name-gate { flex:1; display:flex; align-items:center; justify-content:center; }
  .name-card { background:var(--panel); border:1px solid var(--border); padding:3rem; width:100%; max-width:440px; position:relative; }
  .name-card::before { content:''; position:absolute; top:0;left:0;right:0; height:3px; background:linear-gradient(90deg,var(--accent),var(--accent2)); }
  .name-card h2 { font-family:'Orbitron',monospace; font-size:1.2rem; color:var(--text); margin-bottom:0.5rem; }
  .name-card p { font-family:'Share Tech Mono',monospace; font-size:0.72rem; color:var(--text-dim); letter-spacing:1px; margin-bottom:2rem; }
  .name-card input { width:100%; background:rgba(0,0,0,0.4); border:1px solid var(--border); border-bottom:1px solid rgba(0,212,255,0.3); color:var(--text); padding:0.85rem 1rem; font-family:'Rajdhani',sans-serif; font-size:1rem; outline:none; margin-bottom:1.2rem; transition:all 0.3s; }
  .name-card input:focus { border-color:var(--accent); box-shadow:0 0 0 1px rgba(0,212,255,0.15); }
  .start-btn { width:100%; background:var(--accent); color:var(--bg); border:none; padding:1rem; font-family:'Orbitron',monospace; font-size:0.8rem; font-weight:700; letter-spacing:2px; cursor:pointer; text-transform:uppercase; transition:all 0.3s; clip-path:polygon(0 0,calc(100% - 10px) 0,100% 10px,100% 100%,10px 100%,0 calc(100% - 10px)); }
  .start-btn:hover { box-shadow:var(--glow); }
  .chat-interface { display:none; flex-direction:column; flex:1; overflow:hidden; padding:1.5rem 0; gap:1rem; }
  .chat-info-bar { display:flex; align-items:center; justify-content:space-between; padding:0.75rem 1rem; background:rgba(8,20,37,0.8); border:1px solid var(--border); font-family:'Share Tech Mono',monospace; font-size:0.7rem; flex-shrink:0; }
  .chat-info-bar .user-id { color:var(--accent); }
  .chat-info-bar .session { color:var(--text-dim); }
  .messages { flex:1; overflow-y:auto; display:flex; flex-direction:column; gap:1rem; padding:1rem 0; scrollbar-width:thin; scrollbar-color:var(--border) transparent; }
  .messages::-webkit-scrollbar { width:4px; }
  .messages::-webkit-scrollbar-thumb { background:var(--border); }
  .msg { display:flex; flex-direction:column; max-width:75%; animation:msgIn 0.3s ease; }
  @keyframes msgIn { from{opacity:0;transform:translateY(10px);}to{opacity:1;transform:translateY(0);} }
  .msg.user { align-self:flex-end; }
  .msg.agent { align-self:flex-start; }
  .msg-bubble { padding:0.85rem 1.2rem; font-size:0.95rem; line-height:1.5; }
  .msg.user .msg-bubble { background:rgba(0,212,255,0.1); border:1px solid rgba(0,212,255,0.25); color:var(--text); }
  .msg.agent .msg-bubble { background:rgba(8,20,37,0.9); border:1px solid var(--border); color:var(--text); }
  .msg-meta { font-family:'Share Tech Mono',monospace; font-size:0.62rem; color:var(--text-dim); margin-top:0.3rem; letter-spacing:1px; }
  .msg.user .msg-meta { text-align:right; }
  .msg-sender { font-family:'Share Tech Mono',monospace; font-size:0.65rem; letter-spacing:2px; text-transform:uppercase; margin-bottom:0.3rem; }
  .msg.agent .msg-sender { color:var(--accent2); }
  .msg.user .msg-sender { color:var(--accent); text-align:right; }
  .typing-indicator { display:none; align-self:flex-start; }
  .typing-indicator .msg-bubble { background:rgba(8,20,37,0.9); border:1px solid var(--border); display:flex; gap:0.4rem; align-items:center; padding:1rem 1.2rem; }
  .typing-dot { width:7px; height:7px; border-radius:50%; background:var(--text-dim); animation:typingDot 1.4s infinite; }
  .typing-dot:nth-child(2){animation-delay:0.2s;} .typing-dot:nth-child(3){animation-delay:0.4s;}
  @keyframes typingDot { 0%,60%,100%{opacity:0.3;transform:scale(1);}30%{opacity:1;transform:scale(1.3);} }
  .chat-input-area { flex-shrink:0; display:flex; background:var(--panel); border:1px solid var(--border); border-top:1px solid rgba(0,212,255,0.2); }
  .chat-input { flex:1; background:transparent; border:none; color:var(--text); padding:1.1rem 1.5rem; font-family:'Rajdhani',sans-serif; font-size:1rem; outline:none; }
  .chat-input::placeholder { color:var(--text-dim); font-style:italic; }
  .send-btn { background:var(--accent); color:var(--bg); border:none; padding:0 2rem; font-family:'Orbitron',monospace; font-size:0.7rem; font-weight:700; letter-spacing:2px; cursor:pointer; text-transform:uppercase; transition:all 0.3s; flex-shrink:0; }
  .send-btn:hover { opacity:0.85; }
  .input-hint { font-family:'Share Tech Mono',monospace; font-size:0.65rem; color:var(--text-dim); text-align:center; padding:0.5rem; flex-shrink:0; letter-spacing:1px; }
</style>
</head>
<body>
<header>
  <a href="index.html" class="logo">Cyber<span>Shield</span></a>
  <div class="chat-status"><div class="status-dot"></div>SUPPORT ONLINE</div>
  <a href="index.html" class="back-btn">← BACK</a>
</header>

<div class="chat-wrapper">
  <div class="name-gate" id="nameGate">
    <div class="name-card">
      <h2>Start Secure Chat</h2>
      <p>&gt; Enter your details to connect with support</p>
      <input type="text" id="visitorName" placeholder="Your name" maxlength="40">
      <input type="email" id="visitorEmail" placeholder="Your email (optional)" maxlength="80">
      <button class="start-btn" onclick="startChat()">▸ Connect to Support</button>
    </div>
  </div>

  <div class="chat-interface" id="chatInterface">
    <div class="chat-info-bar">
      <span>SESSION: <span class="user-id" id="sessionId">—</span></span>
      <span class="session" id="sessionTime">—</span>
    </div>
    <div class="messages" id="messages"></div>
    <div class="typing-indicator" id="typingIndicator">
      <div class="msg-bubble">
        <div class="typing-dot"></div><div class="typing-dot"></div><div class="typing-dot"></div>
      </div>
    </div>
    <div class="chat-input-area">
      <input class="chat-input" type="text" id="msgInput" placeholder="Type your message..." maxlength="500" onkeydown="handleKey(event)">
      <button class="send-btn" onclick="sendMessage()">Send ▸</button>
    </div>
    <div class="input-hint">Press ENTER to send</div>
  </div>
</div>

<script>
const BACKEND = 'chat_backend.php';
let sessionId = '';
let visitorName = '';
let lastTs = 0;
let polling = false;

function startChat() {
  visitorName = document.getElementById('visitorName').value.trim();
  if (!visitorName) { alert('Please enter your name.'); return; }
  const email = document.getElementById('visitorEmail').value.trim();
  sessionId = 'CS-' + Date.now().toString(36).toUpperCase();

  document.getElementById('nameGate').style.display = 'none';
  document.getElementById('chatInterface').style.display = 'flex';
  document.getElementById('sessionId').textContent = sessionId;
  document.getElementById('sessionTime').textContent = new Date().toLocaleString();

  // Save meta to server
  fetch(`${BACKEND}?action=meta`, {
    method: 'POST',
    headers: {'Content-Type':'application/json'},
    body: JSON.stringify({ session_id: sessionId, name: visitorName, email })
  });

  // Welcome message from agent
  sendAgentWelcome();
  startPolling();
}

function sendAgentWelcome() {
  fetch(`${BACKEND}?action=send`, {
    method: 'POST',
    headers: {'Content-Type':'application/json'},
    body: JSON.stringify({
      session_id: sessionId,
      role: 'agent',
      sender: 'CyberShield Support',
      text: `Hello ${visitorName}! Welcome to CyberShield Consulting. How can we help secure your business today?`
    })
  });
}

async function sendMessage() {
  const input = document.getElementById('msgInput');
  const text = input.value.trim();
  if (!text) return;
  input.value = '';

  await fetch(`${BACKEND}?action=send`, {
    method: 'POST',
    headers: {'Content-Type':'application/json'},
    body: JSON.stringify({ session_id: sessionId, role: 'user', sender: visitorName, text })
  });
}

function handleKey(e) { if (e.key === 'Enter') sendMessage(); }

function startPolling() {
  if (polling) return;
  polling = true;
  pollMessages();
}

async function pollMessages() {
  while (polling) {
    try {
      const res = await fetch(`${BACKEND}?action=poll&session_id=${sessionId}&since=${lastTs}`);
      const data = await res.json();
      if (data.ok && data.messages && data.messages.length > 0) {
        data.messages.forEach(renderMessage);
        lastTs = data.messages[data.messages.length - 1].ts;
      }
    } catch(e) {
      await sleep(3000);
    }
  }
}

function renderMessage(msg) {
  const div = document.createElement('div');
  div.className = `msg ${msg.role}`;
  div.innerHTML = `
    <div class="msg-sender">${esc(msg.sender)}</div>
    <div class="msg-bubble">${esc(msg.text)}</div>
    <div class="msg-meta">${msg.time}</div>
  `;
  document.getElementById('messages').appendChild(div);
  const m = document.getElementById('messages');
  m.scrollTop = m.scrollHeight;
}

function sleep(ms) { return new Promise(r => setTimeout(r, ms)); }
function esc(s) { return String(s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }
</script>
</body>
</html>
