<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test Order Realtime - Reverb</title>
    
    <!-- Pusher & Echo CDN (Bisa langsung jalan tanpa perlu npm compile) -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>

    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #f1f5f9; color: #1e293b; padding: 2rem; }
        .card { max-width: 650px; margin: 0 auto; background: white; border-radius: 12px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); padding: 1.75rem; }
        .btn { background: #2563eb; color: white; padding: 0.7rem 1.4rem; border-radius: 8px; border: none; font-weight: 600; font-size: 1rem; cursor: pointer; transition: 0.2s; }
        .btn:hover { background: #1d4ed8; }
        .btn:disabled { opacity: 0.5; cursor: not-allowed; }
        .input { width: 100%; padding: 0.7rem; border: 1px solid #cbd5e1; border-radius: 6px; margin: 0.5rem 0 1.2rem; font-size: 1rem; box-sizing: border-box; }
        .logs { margin-top: 1.5rem; padding: 1rem; background: #0f172a; color: #38bdf8; border-radius: 8px; min-height: 200px; font-family: monospace; font-size: 0.875rem; overflow-y: auto; max-height: 320px; line-height: 1.5; }
        .badge { display: inline-block; padding: 0.3rem 0.75rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 600; }
        .badge-success { background: #dcfce7; color: #15803d; }
        .badge-warning { background: #fef3c7; color: #b45309; }
        .badge-danger { background: #fee2e2; color: #b91c1c; }
        .info-box { background: #eff6ff; border-left: 4px solid #3b82f6; padding: 0.75rem 1rem; border-radius: 4px; font-size: 0.875rem; color: #1e40af; margin-bottom: 1.25rem; }
    </style>
</head>
<body>
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 1rem;">
            <h2 style="margin:0; font-size: 1.35rem;">🧪 Test Order Tanpa Login</h2>
            <span id="ws-status" class="badge badge-warning">Menghubungkan ke Reverb...</span>
        </div>

        <div class="info-box">
            Fitur ini menguji order & realtime event Reverb tanpa login. Jika belum login, order otomatis diasosiasikan dengan akun tester default.
        </div>

        <label style="font-weight: 600; font-size: 0.95rem;" for="total">Nominal Total Order (Rp):</label>
        <input type="number" id="total" class="input" value="150000" min="1000" step="5000">

        <button id="btn-order" class="btn" onclick="kirimOrder()">🚀 Kirim Test Order</button>

        <h3 style="margin-top: 1.75rem; margin-bottom: 0.5rem; font-size: 1rem;">📡 Log Event Realtime Reverb (Channel: <code>orders</code>)</h3>
        <div id="logs" class="logs">
            <div>[Menghubungkan ke ws://{{ env('REVERB_HOST', '127.0.0.1') }}:{{ env('REVERB_PORT', 8080) }}...]</div>
        </div>
    </div>

    <script>
        function logMessage(msg) {
            const logs = document.getElementById('logs');
            const time = new Date().toLocaleTimeString();
            logs.innerHTML += `<div>[${time}] ${msg}</div>`;
            logs.scrollTop = logs.scrollHeight;
        }

        // Inisialisasi Echo via CDN
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
            const status = document.getElementById('ws-status');
            status.className = 'badge badge-success';
            status.innerText = '🟢 Reverb Terhubung';
            logMessage('✅ Sukses terhubung ke server Laravel Reverb!');
        });

        window.Echo.connector.pusher.connection.bind('error', (err) => {
            const status = document.getElementById('ws-status');
            status.className = 'badge badge-danger';
            status.innerText = '🔴 Reverb Gagal';
            logMessage(`❌ WebSocket error. Pastikan "php artisan reverb:start" sedang berjalan.`);
        });

        // Dengarkan broadcast channel public 'orders'
        window.Echo.channel('orders')
            .listen('.order.placed', (e) => {
                logMessage(`🎉 REALTIME EVENT MASUK: Order #${e.order_id} senilai Rp ${Number(e.total).toLocaleString('id-ID')} (User: ${e.user_name})`);
                alert(`🔔 Realtime Notifikasi Reverb!\nOrder #${e.order_id} berhasil diterima!\nTotal: Rp ${Number(e.total).toLocaleString('id-ID')}\nPemesan: ${e.user_name}`);
            });

        logMessage('Mendengarkan event .order.placed pada public channel "orders"...');

        async function kirimOrder() {
            const total = document.getElementById('total').value;
            const btn = document.getElementById('btn-order');
            btn.disabled = true;
            btn.innerText = 'Mengirim...';

            logMessage(`Mengirim request POST /orders (Total: Rp ${Number(total).toLocaleString('id-ID')})...`);

            try {
                const res = await fetch('/orders', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ total: total })
                });

                const data = await res.json();
                if (res.ok) {
                    logMessage(`✅ Order berhasil dibuat di database! ID: #${data.data.id}, Total: Rp ${Number(data.data.total).toLocaleString('id-ID')}`);
                } else {
                    logMessage(`❌ Gagal: ${JSON.stringify(data)}`);
                }
            } catch (err) {
                logMessage(`❌ Request error: ${err.message}`);
            } finally {
                btn.disabled = false;
                btn.innerText = '🚀 Kirim Test Order';
            }
        }
    </script>
</body>
</html>
