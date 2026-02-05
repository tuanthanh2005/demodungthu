/* global Intl */

let allProducts = [];
let allCategories = [];
let cart = [];

function getQueryParams() {
    const params = new URLSearchParams(window.location.search);
    const category = params.get('category') || 'all';
    const q = (params.get('q') || '').trim().toLowerCase();
    return { category, q };
}

function setQueryParams(next) {
    const params = new URLSearchParams(window.location.search);
    if (next.category) params.set('category', next.category);
    if (next.q !== undefined) {
        if (next.q) params.set('q', next.q);
        else params.delete('q');
    }
    if (next.category === 'all') params.delete('category');
    const url = `${window.location.pathname}${params.toString() ? `?${params.toString()}` : ''}`;
    window.history.replaceState({}, '', url);
}

function formatVND(value) {
    try {
        return `₫${new Intl.NumberFormat('vi-VN').format(Number(value) || 0)}`;
    } catch {
        return `${value}`;
    }
}

function showMobileToast(message, type = 'success') {
    const toast = document.getElementById('mobileToast');
    const text = document.getElementById('mobileToastText');
    const icon = toast?.querySelector('.mobile-toast-icon');
    if (!toast || !text || !icon) return;

    text.textContent = message;
    toast.className = `mobile-toast ${type}`;
    icon.textContent = type === 'error' ? '✕' : '✓';

    toast.classList.add('show');
    window.clearTimeout(showMobileToast._t);
    showMobileToast._t = window.setTimeout(() => toast.classList.remove('show'), 2500);
}

function getProductImage(product) {
    const raw = product?.main_image || product?.image || '';
    return raw && typeof raw === 'string' ? raw : '';
}

function getProductDetailUrl(product) {
    const slug = product?.slug;
    return slug ? `/products/${slug}` : '#';
}

function addToCart(productId) {
    const id = Number(productId);
    if (!Number.isFinite(id)) return;

    const product = allProducts.find(p => Number(p.id) === id);
    if (!product) {
        showMobileToast('Không tìm thấy sản phẩm', 'error');
        return;
    }

    const existing = cart.find(i => Number(i.id) === id);
    if (existing) {
        existing.quantity = (Number(existing.quantity) || 1) + 1;
    } else {
        cart.push({
            id: product.id,
            name: product.name,
            price: product.price,
            slug: product.slug || null,
            image: product.main_image || product.image || null,
            in_stock: product.in_stock ?? null,
            quantity: 1,
        });
    }
    saveCart();
    updateCartCount();

    showMobileToast('Đã thêm vào giỏ hàng', 'success');
}

function loadCart() {
    try {
        const saved = localStorage.getItem('cart');
        cart = saved ? JSON.parse(saved) : [];
        if (!Array.isArray(cart)) cart = [];
    } catch {
        cart = [];
    }
}

function saveCart() {
    try {
        localStorage.setItem('cart', JSON.stringify(cart));
    } catch {
        // ignore
    }
}

function getCartCount() {
    return cart.reduce((sum, item) => sum + (Number(item.quantity) || 1), 0);
}

function updateCartCount() {
    const countEl = document.getElementById('cartCount');
    if (countEl) countEl.textContent = String(getCartCount());
}

function formatTotalAmount() {
    const total = cart.reduce((sum, item) => sum + (Number(item.price) || 0) * (Number(item.quantity) || 1), 0);
    return formatVND(total);
}

function openCartModal() {
    const overlay = document.getElementById('cartOverlay');
    const modal = document.getElementById('cartModal');
    if (!overlay || !modal) return;

    overlay.classList.add('active');
    modal.classList.add('active');
    modal.setAttribute('aria-hidden', 'false');
    renderCartModal();
}

function closeCartModal() {
    const overlay = document.getElementById('cartOverlay');
    const modal = document.getElementById('cartModal');
    if (!overlay || !modal) return;

    overlay.classList.remove('active');
    modal.classList.remove('active');
    modal.setAttribute('aria-hidden', 'true');
}

function toggleCart() {
    openCartModal();
}

function removeFromCart(productId) {
    const id = Number(productId);
    cart = cart.filter(i => Number(i.id) !== id);
    saveCart();
    updateCartCount();
    renderCartModal();
}

function changeQty(productId, delta) {
    const id = Number(productId);
    const item = cart.find(i => Number(i.id) === id);
    if (!item) return;

    const next = (Number(item.quantity) || 1) + delta;
    if (next <= 0) {
        removeFromCart(id);
        return;
    }
    item.quantity = next;
    saveCart();
    updateCartCount();
    renderCartModal();
}

function renderCartModal() {
    const itemsEl = document.getElementById('cartItems');
    const totalEl = document.getElementById('cartTotalAmount');
    if (!itemsEl || !totalEl) return;

    if (cart.length === 0) {
        itemsEl.innerHTML = `
            <div class="empty-cart">
                <p>Giỏ hàng trống</p>
                <small>Hãy thêm sản phẩm để tiếp tục.</small>
            </div>
        `;
        totalEl.textContent = formatVND(0);
        return;
    }

    itemsEl.innerHTML = cart.map(item => {
        const img = item.image || 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=200&h=200&fit=crop&q=80';
        const name = item.name || `SP #${item.id}`;
        return `
            <div class="cart-modal-item">
                <img src="${img}" alt="${name}" onerror="this.src='https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=200&h=200&fit=crop&q=80'"/>
                <div class="cart-item-info">
                    <div class="cart-item-name">${name}</div>
                    <div class="cart-item-price">${formatVND(item.price)}</div>
                    <div class="cart-item-controls">
                        <button type="button" class="qty-btn" data-qty-minus="${item.id}">-</button>
                        <div class="qty-display">${Number(item.quantity) || 1}</div>
                        <button type="button" class="qty-btn" data-qty-plus="${item.id}">+</button>
                        <button type="button" class="cart-item-remove" data-remove="${item.id}" aria-label="Xóa">×</button>
                    </div>
                </div>
            </div>
        `;
    }).join('');

    totalEl.textContent = formatTotalAmount();

    itemsEl.querySelectorAll('[data-qty-minus]').forEach(btn => {
        btn.addEventListener('click', () => changeQty(btn.getAttribute('data-qty-minus'), -1));
    });
    itemsEl.querySelectorAll('[data-qty-plus]').forEach(btn => {
        btn.addEventListener('click', () => changeQty(btn.getAttribute('data-qty-plus'), 1));
    });
    itemsEl.querySelectorAll('[data-remove]').forEach(btn => {
        btn.addEventListener('click', () => removeFromCart(btn.getAttribute('data-remove')));
    });
}

function goToCheckout() {
    if (cart.length === 0) {
        showMobileToast('Giỏ hàng trống', 'error');
        return;
    }
    saveCart();
    window.location.href = '/checkout';
}

function renderCategories(activeCategoryId) {
    const wrap = document.getElementById('productsCategories');
    if (!wrap) return;

    const buttons = [
        { id: 'all', name: 'Tất cả' },
        ...allCategories.map(c => ({ id: String(c.id), name: c.name }))
    ];

    wrap.innerHTML = buttons.map(btn => {
        const isActive = String(activeCategoryId) === String(btn.id);
        return `<button type="button" class="filter-btn ${isActive ? 'active' : ''}" data-cat-id="${btn.id}">${btn.name}</button>`;
    }).join('');

    wrap.querySelectorAll('[data-cat-id]').forEach(el => {
        el.addEventListener('click', () => {
            const nextId = el.getAttribute('data-cat-id') || 'all';
            setQueryParams({ category: nextId });
            renderAll();
        });
    });
}

function renderProducts(activeCategoryId, q) {
    const list = document.getElementById('productsList');
    const countEl = document.getElementById('productsCount');
    const activeEl = document.getElementById('productsActiveCategory');
    if (!list) return;

    const activeName = activeCategoryId === 'all'
        ? 'Tất cả'
        : (allCategories.find(c => String(c.id) === String(activeCategoryId))?.name || 'Danh mục');
    if (activeEl) activeEl.textContent = activeName;

    let filtered = allProducts;
    if (activeCategoryId !== 'all') {
        filtered = filtered.filter(p => String(p.category_id) === String(activeCategoryId));
    }
    if (q) {
        filtered = filtered.filter(p => (p.name || '').toLowerCase().includes(q));
    }

    if (countEl) countEl.textContent = `${filtered.length} sản phẩm`;

    if (filtered.length === 0) {
        list.innerHTML = `<div class="empty-state">Không có sản phẩm phù hợp.</div>`;
        return;
    }

    list.innerHTML = filtered.map(p => {
        const img = getProductImage(p);
        const detailUrl = getProductDetailUrl(p);
        const inStock = p.in_stock === 1 || p.in_stock === true;

        return `
            <div class="product-card">
                <a href="${detailUrl}" style="text-decoration:none; color:inherit;">
                    <div class="product-image">
                        <img src="${img || 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&h=400&fit=crop&q=80'}" alt="${(p.image_alt || p.name || 'Sản phẩm')}" loading="lazy"
                            onerror="this.src='https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&h=400&fit=crop&q=80'"/>
                    </div>
                    <div class="product-info">
                        <div class="product-name">${p.name || ''}</div>
                        <div class="product-price">
                            <div class="price-current">${formatVND(p.price)}</div>
                        </div>
                    </div>
                </a>
                <button type="button" class="add-to-cart" data-add-cart="${p.id}" ${inStock ? '' : 'disabled style="opacity:0.6; cursor:not-allowed;"'}>
                    ${inStock ? 'Thêm vào giỏ' : 'Hết hàng'}
                </button>
            </div>
        `;
    }).join('');

    list.querySelectorAll('[data-add-cart]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            const id = btn.getAttribute('data-add-cart');
            addToCart(id);
        });
    });
}

function renderAll() {
    const { category, q } = getQueryParams();
    renderCategories(category);
    renderProducts(category, q);

    const search = document.getElementById('productsSearch');
    if (search && document.activeElement !== search) {
        search.value = q || '';
    }
}

async function loadData() {
    const [productsRes, categoriesRes] = await Promise.all([
        fetch('/api/products').then(r => r.json()),
        fetch('/api/products/categories').then(r => r.json())
    ]);

    allProducts = Array.isArray(productsRes) ? productsRes : [];
    allCategories = Array.isArray(categoriesRes) ? categoriesRes : [];
}

document.addEventListener('DOMContentLoaded', async () => {
    const search = document.getElementById('productsSearch');
    if (search) {
        let t;
        search.addEventListener('input', () => {
            window.clearTimeout(t);
            t = window.setTimeout(() => {
                setQueryParams({ q: search.value.trim().toLowerCase() });
                renderAll();
            }, 200);
        });
    }

    try {
        await loadData();
        loadCart();
        updateCartCount();
        renderAll();
    } catch (e) {
        console.error('Failed to load products page data:', e);
        showMobileToast('Không tải được dữ liệu', 'error');
    }
});

document.addEventListener('click', (e) => {
    const overlay = document.getElementById('cartOverlay');
    if (overlay && e.target === overlay) closeCartModal();
}, true);

// Expose for inline handlers in Blade
window.toggleCart = toggleCart;
window.closeCartModal = closeCartModal;
window.goToCheckout = goToCheckout;
