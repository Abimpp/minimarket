<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>WhatsApp - Chatting Reverb</title>

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background: #dadbd4;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Container WhatsApp Web */
        .wa-app {
            width: 100%;
            max-width: 480px;
            height: 94vh;
            max-height: 720px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Header WhatsApp */
        .wa-header {
            background: #008069;
            color: #ffffff;
            padding: 10px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 10;
        }
        .wa-header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .wa-avatar {
            width: 40px;
            height: 40px;
            background: #dfe5e7;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #54656f;
            font-size: 18px;
            font-weight: bold;
        }
        .wa-title h3 {
            font-size: 15px;
            font-weight: 500;
            line-height: 1.2;
        }
        .wa-title .wa-status {
            font-size: 12px;
            color: #d1fae5;
        }
        .wa-title .wa-status.disconnected {
            color: #fecaca;
        }

        /* Switcher Nama Klien di Header */
        .wa-header-right {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .wa-header-right select {
            background: #006b57;
            color: #ffffff;
            border: 1px solid #005646;
            padding: 5px 8px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            outline: none;
            cursor: pointer;
        }
        .wa-clear-btn {
            background: none;
            border: none;
            color: #ffffff;
            font-size: 15px;
            cursor: pointer;
            padding: 4px 6px;
            border-radius: 4px;
            opacity: 0.8;
            transition: opacity 0.2s;
        }
        .wa-clear-btn:hover {
            opacity: 1;
            background: rgba(0, 0, 0, 0.15);
        }

        /* Chat Area dengan Wallpaper WhatsApp */
        .wa-chat-area {
            flex: 1;
            background-color: #efeae2;
            background-image: 
                radial-gradient(#d5cbbb 1px, transparent 1px),
                radial-gradient(#d5cbbb 1px, #efeae2 1px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
            padding: 16px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        /* Message Bubbles */
        .wa-bubble {
            max-width: 75%;
            padding: 6px 9px 6px 9px;
            border-radius: 7.5px;
            font-size: 14px;
            line-height: 1.35;
            position: relative;
            word-break: break-word;
            box-shadow: 0 1px 0.5px rgba(11, 20, 26, 0.13);
        }

        /* Pesan Saya (Kanan - Hijau Muda) */
        .wa-bubble.mine {
            align-self: flex-end;
            background: #d9fdd3;
            color: #111b21;
            border-top-right-radius: 0;
        }
        .wa-bubble.mine .wa-sender-name {
            display: none;
        }

        /* Pesan Orang Lain (Kiri - Putih) */
        .wa-bubble.other {
            align-self: flex-start;
            background: #ffffff;
            color: #111b21;
            border-top-left-radius: 0;
        }
        .wa-bubble.other .wa-sender-name {
            font-size: 12px;
            font-weight: 600;
            color: #008069;
            margin-bottom: 2px;
        }

        .wa-text {
            display: inline;
        }

        /* Waktu & Tanda Centang */
        .wa-time-wrapper {
            float: right;
            margin-left: 12px;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 3px;
            font-size: 11px;
            color: #667781;
            user-select: none;
        }
        .wa-check {
            color: #53bdeb;
            font-weight: bold;
            font-size: 13px;
            line-height: 1;
        }

        /* Input Bar WhatsApp */
        .wa-input-bar {
            background: #f0f2f5;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .wa-input-bar input {
            flex: 1;
            background: #ffffff;
            border: none;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 14.5px;
            outline: none;
            color: #111b21;
        }
        .wa-input-bar input::placeholder {
            color: #8696a0;
        }

        /* Tombol Kirim */
        .wa-send-btn {
            background: #00a884;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.15s;
        }
        .wa-send-btn:hover {
            background: #008f6f;
        }
        .wa-send-btn svg {
            width: 18px;
            height: 18px;
            fill: #ffffff;
            margin-left: 2px;
        }
    </style>
</head>
<body>

    <div class="wa-app">
        <!-- Header WhatsApp -->
        <div class="wa-header">
            <div class="wa-header-left">
                <div class="wa-avatar">👥</div>
                <div class="wa-title">
                    <h3>Grup Reverb Realtime</h3>
                    <div id="reverb-status" class="wa-status">menghubungkan...</div>
                </div>
            </div>
            <div class="wa-header-right">
                <select id="client-name" onchange="changeIdentity(this.value)">
                    <option value="Klien 1">Saya: Klien 1</option>
                    <option value="Klien 2">Saya: Klien 2</option>
                </select>
                <button type="button" class="wa-clear-btn" onclick="clearChat()" title="Hapus Semua Chat">🗑️</button>
            </div>
        </div>

        <!-- Chat Area -->
        <div id="wa-chat-area" class="wa-chat-area">
            @foreach($messages as $msg)
                <div class="wa-bubble other" data-sender="{{ $msg->sender_name }}" data-id="{{ $msg->id }}">
                    <div class="wa-sender-name">{{ $msg->sender_name }}</div>
                    <div class="wa-text">{{ $msg->message }}</div>
                    <div class="wa-time-wrapper">
                        <span>{{ $msg->created_at ? $msg->created_at->format('H:i') : '' }}</span>
                        <span class="wa-check">✓✓</span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Input Bar WhatsApp -->
        <form class="wa-input-bar" onsubmit="handleSend(event)">
            <input type="text" id="message-input" placeholder="Ketik pesan..." autocomplete="off" required>
            <button type="submit" class="wa-send-btn" title="Kirim">
                <svg viewBox="0 0 24 24">
                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"></path>
                </svg>
            </button>
        </form>
    </div>

    <script>
        const nameSelect = document.getElementById('client-name');
        const chatArea = document.getElementById('wa-chat-area');
        const statusEl = document.getElementById('reverb-status');

        // Mengambil identitas tersimpan di masing-masing browser
        const savedName = localStorage.getItem('wa_client_name');
        if (savedName) {
            nameSelect.value = savedName;
        }

        function changeIdentity(val) {
            localStorage.setItem('wa_client_name', val);
            refreshBubbleAlignment();
        }

        // Setup Laravel Reverb & Echo via CDN
        window.Pusher = Pusher;
        window.Echo = new Echo({
            broadcaster: 'reverb',
            key: '{{ env('REVERB_APP_KEY') }}',
            wsHost: '{{ env('REVERB_HOST', '127.0.0.1') }}',
            wsPort: {{ env('REVERB_PORT', 8080) }},
            wssPort: {{ env('REVERB_PORT', 8080) }},
            forceTLS: false,
            enabledTransports: ['ws', 'wss'],
        });

        // Status koneksi WebSocket
        window.Echo.connector.pusher.connection.bind('connected', () => {
            statusEl.className = 'wa-status';
            statusEl.innerText = 'online';
        });

        window.Echo.connector.pusher.connection.bind('disconnected', () => {
            statusEl.className = 'wa-status disconnected';
            statusEl.innerText = 'terputus';
        });

        // Dengarkan broadcast realtime di channel 'chat-channel'
        window.Echo.channel('chat-channel')
            .listen('.message.sent', (data) => {
                if (!document.querySelector(`[data-id="${data.id}"]`)) {
                    appendBubble(data);
                }
            });

        function appendBubble(data) {
            const myName = nameSelect.value.trim().toLowerCase();
            const isMine = (data.sender_name || '').trim().toLowerCase() === myName;

            const bubble = document.createElement('div');
            bubble.className = `wa-bubble ${isMine ? 'mine' : 'other'}`;
            bubble.setAttribute('data-sender', data.sender_name);
            bubble.setAttribute('data-id', data.id);

            bubble.innerHTML = `
                <div class="wa-sender-name">${escapeHtml(data.sender_name)}</div>
                <div class="wa-text">${escapeHtml(data.message)}</div>
                <div class="wa-time-wrapper">
                    <span>${data.created_at || ''}</span>
                    <span class="wa-check">${isMine ? '✓✓' : ''}</span>
                </div>
            `;

            chatArea.appendChild(bubble);
            scrollToBottom();
        }

        function refreshBubbleAlignment() {
            const myName = nameSelect.value.trim().toLowerCase();
            document.querySelectorAll('.wa-bubble').forEach(bubble => {
                const sender = (bubble.getAttribute('data-sender') || '').trim().toLowerCase();
                const checkEl = bubble.querySelector('.wa-check');
                if (sender === myName) {
                    bubble.classList.remove('other');
                    bubble.classList.add('mine');
                    if (checkEl) checkEl.innerText = '✓✓';
                } else {
                    bubble.classList.remove('mine');
                    bubble.classList.add('other');
                    if (checkEl) checkEl.innerText = '';
                }
            });
            scrollToBottom();
        }

        function scrollToBottom() {
            chatArea.scrollTop = chatArea.scrollHeight;
        }

        function escapeHtml(str) {
            const div = document.createElement('div');
            div.innerText = str;
            return div.innerHTML;
        }

        async function handleSend(e) {
            e.preventDefault();
            const input = document.getElementById('message-input');
            const message = input.value.trim();
            const senderName = nameSelect.value;

            if (!message) return;
            input.value = '';

            try {
                const res = await fetch('/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        sender_name: senderName,
                        message: message
                    })
                });

                const json = await res.json();
                if (res.ok && !document.querySelector(`[data-id="${json.data.id}"]`)) {
                    appendBubble(json.data);
                }
            } catch (err) {
                console.error(err);
            }
        }

        async function clearChat() {
            if (!confirm('Hapus semua pesan chat di database?')) return;

            try {
                const res = await fetch('/chat/clear', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                if (res.ok) {
                    chatArea.innerHTML = '';
                }
            } catch (err) {
                console.error(err);
                alert('Gagal menghapus pesan.');
            }
        }

        window.addEventListener('DOMContentLoaded', () => {
            refreshBubbleAlignment();
            scrollToBottom();
        });
    </script>
</body>
</html>
