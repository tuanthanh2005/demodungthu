<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Đơn hàng</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style-new.css">
    <link rel="stylesheet" href="/css/mobile-optimization.css">
    <style>
        :root {
            --primary: #7851A9;
            --primary-dark: #6b439a;
            --primary-light: rgba(120, 81, 169, 0.12);
            --secondary: #a583c7;
            --accent: #B085D2;
            --gradient: linear-gradient(135deg, #7851A9 0%, #9B6BC5 50%, #B085D2 100%);
            --gradient-hover: linear-gradient(135deg, #6b439a 0%, #8f5bb7 50%, #a86fcd 100%);
        }

        body { background: var(--gray-50); }

        .page {
            max-width: 1100px;
            margin: 0 auto;
            padding: 16px;
            padding-bottom: calc(var(--mobile-nav-height) + 32px);
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 9992;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 16px;
            padding: 12px;
            margin-bottom: 14px;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: var(--gray-100);
            color: var(--gray-900);
            text-decoration: none;
            font-weight: 700;
        }

        .title {
            font-size: 1rem;
            font-weight: 900;
            color: var(--gray-900);
        }

        .orders {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .card {
            background: white;
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 18px;
            padding: 14px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
        }

        .card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 10px;
        }

        .badge {
            padding: 6px 10px;
            border-radius: 999px;
            font-weight: 800;
            font-size: 0.8rem;
            border: 1px solid rgba(0, 0, 0, 0.06);
            background: var(--gray-100);
            color: var(--gray-900);
            white-space: nowrap;
        }

        .badge.pending { background: rgba(245, 158, 11, 0.12); color: #92400e; border-color: rgba(245, 158, 11, 0.25); }
        .badge.paid { background: rgba(16, 185, 129, 0.12); color: #065f46; border-color: rgba(16, 185, 129, 0.25); }
        .badge.completed { background: rgba(16, 185, 129, 0.12); color: #065f46; border-color: rgba(16, 185, 129, 0.25); }
        .badge.canceled { background: rgba(239, 68, 68, 0.12); color: #7f1d1d; border-color: rgba(239, 68, 68, 0.25); }

        .meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            color: var(--gray-700);
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .meta div span {
            color: var(--gray-500);
            font-weight: 700;
        }

        .items {
            border-top: 1px solid rgba(0, 0, 0, 0.06);
            padding-top: 10px;
            display: grid;
            gap: 8px;
        }

        .item {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            font-weight: 700;
            color: var(--gray-900);
        }

        .item small {
            display: block;
            color: var(--gray-500);
            font-weight: 700;
            margin-top: 2px;
        }

        .empty {
            text-align: center;
            padding: 46px 16px;
            color: var(--gray-600);
            font-weight: 700;
            background: white;
            border: 1px dashed rgba(0, 0, 0, 0.12);
            border-radius: 18px;
        }

        @media (max-width: 600px) {
            .meta { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="topbar">
            <a class="back-btn" href="/" aria-label="Về trang chủ">←</a>
            <div class="title">ĐƠN HÀNG</div>
        </div>

        <div id="ordersList" class="orders"></div>
    </div>

    <script>
        function formatVND(v) {
            try { return `₫${new Intl.NumberFormat('vi-VN').format(Number(v) || 0)}`; }
            catch { return `${v}`; }
        }

        function fmtDate(iso) {
            try { return new Date(iso).toLocaleString('vi-VN'); }
            catch { return iso || ''; }
        }

        function badgeClass(status) {
            const s = String(status || 'pending').toLowerCase();
            if (['paid', 'completed', 'success'].includes(s)) return 'paid';
            if (['canceled', 'cancelled', 'failed'].includes(s)) return 'canceled';
            if (['pending', 'processing'].includes(s)) return 'pending';
            return s;
        }

        async function loadOrders() {
            const el = document.getElementById('ordersList');
            if (!el) return;

            el.innerHTML = `<div class="empty">Đang tải đơn hàng...</div>`;
            const res = await fetch('/api/orders/my', { headers: { 'Accept': 'application/json' } });
            if (!res.ok) {
                el.innerHTML = `<div class="empty">Không tải được đơn hàng (HTTP ${res.status}).</div>`;
                return;
            }
            const orders = await res.json();
            if (!Array.isArray(orders) || orders.length === 0) {
                el.innerHTML = `<div class="empty">Bạn chưa có đơn hàng nào.</div>`;
                return;
            }

            el.innerHTML = orders.map(o => {
                const status = o.status || 'pending';
                const items = Array.isArray(o.items) ? o.items : [];
                const itemsHtml = items.map(it => {
                    const name = it.product?.name || `SP #${it.product_id}`;
                    const qty = it.quantity || 1;
                    const price = it.price ?? 0;
                    return `
                        <div class="item">
                            <div>
                                ${name}
                                <small>x${qty}</small>
                            </div>
                            <div>${formatVND(price)}</div>
                        </div>
                    `;
                }).join('');

                return `
                    <div class="card">
                        <div class="card-head">
                            <div style="font-weight: 900; color: var(--gray-900);">#${o.id}</div>
                            <div class="badge ${badgeClass(status)}">${status}</div>
                        </div>
                        <div class="meta">
                            <div><span>Ngày:</span> ${fmtDate(o.created_at)}</div>
                            <div><span>Tổng:</span> ${formatVND(o.total)}</div>
                            <div><span>Người nhận:</span> ${o.customer_name || ''}</div>
                            <div><span>SĐT:</span> ${o.customer_phone || ''}</div>
                            <div style="grid-column: 1 / -1;"><span>Địa chỉ:</span> ${o.customer_address || ''}</div>
                        </div>
                        <div class="items">${itemsHtml || '<div style=\"color: var(--gray-600); font-weight: 700;\">(Không có sản phẩm)</div>'}</div>
                    </div>
                `;
            }).join('');
        }

        document.addEventListener('DOMContentLoaded', () => {
            loadOrders().catch(err => {
                console.error(err);
                const el = document.getElementById('ordersList');
                if (el) el.innerHTML = `<div class="empty">Có lỗi khi tải đơn hàng.</div>`;
            });
        });
    </script>
</body>
</html>

