// Product data - will be loaded from API
let products = [];

console.log('🔥🔥🔥 SCRIPT.JS LOADED - VERSION 2.0 🔥🔥🔥');

// State management - Load cart from localStorage first
let cart = [];
const savedCart = localStorage.getItem('cart');
if (savedCart) {
    try {
        cart = JSON.parse(savedCart);
        console.log('Cart loaded from localStorage:', cart);
    } catch (e) {
        console.error('Error loading cart:', e);
        cart = [];
    }
}

let currentFilter = 'all';

// DOM elements
let productGrid;
let cartModal;
let cartOverlay;
let cartCloseBtn;
let cartBtn;
let cartCount;
let cartItems;
let totalPrice;
let productModal;
let productOverlay;
let productCloseBtn;
let productDetail;

// Load products from API
async function loadProducts() {
    try {
        const response = await fetch('/api/products');
        if (!response.ok) throw new Error('Failed to load products');

        const data = await response.json();
        console.log('Products loaded from API:', data);

        // Convert API data to internal format
        products = data.map(product => ({
            id: product.id,
            name: product.name,
            category: product.category_id ? 'category_' + product.category_id : 'all',
            price: parseFloat(product.price) || 0,
            rating: 5, // Default rating
            badge: null,
            image: product.main_image || product.images?.[0] || 'https://via.placeholder.com/400/6a4c93/ffffff?text=Product',
            description: product.description || ''
        }));

        console.log('Products converted:', products);
        renderProducts();
        console.log('✅ renderProducts() called, buttons should be ready');
    } catch (error) {
        console.error('Error loading products:', error);
        // Keep using empty array if API fails
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', async () => {
    console.log('🚀 DOMContentLoaded event fired');

    // Initialize DOM elements
    productGrid = document.getElementById('product-grid');
    cartModal = document.getElementById('cart-modal');
    cartOverlay = document.getElementById('cart-overlay');
    cartCloseBtn = document.getElementById('cart-close');
    cartBtn = document.getElementById('cart-btn');
    cartCount = document.getElementById('cart-count');
    cartItems = document.getElementById('cart-items');
    totalPrice = document.getElementById('total-price');
    productModal = document.getElementById('product-modal');
    productOverlay = document.getElementById('product-overlay');
    productCloseBtn = document.getElementById('product-close');
    productDetail = document.getElementById('product-detail');

    console.log('✅ DOM elements initialized:');
    console.log('  - productGrid:', productGrid);
    console.log('  - cartBtn:', cartBtn);
    console.log('  - cartCount:', cartCount);

    // Load products from API first
    await loadProducts();

    setupEventListeners();
    updateCartUI();
});

// Setup event listeners
function setupEventListeners() {
    // Filter buttons
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            e.target.classList.add('active');
            currentFilter = e.target.dataset.filter;
            renderProducts();
        });
    });

    // Category cards
    document.querySelectorAll('.category-card').forEach(card => {
        card.addEventListener('click', (e) => {
            const category = e.currentTarget.dataset.category;
            document.querySelectorAll('.filter-btn').forEach(btn => {
                if (btn.dataset.filter === category) {
                    btn.click();
                }
            });
            document.getElementById('products').scrollIntoView({ behavior: 'smooth' });
        });
    });

    // Cart modal
    cartBtn.addEventListener('click', () => {
        cartModal.classList.add('active');
    });

    cartCloseBtn.addEventListener('click', () => {
        cartModal.classList.remove('active');
    });

    cartOverlay.addEventListener('click', () => {
        cartModal.classList.remove('active');
    });

    // Product modal
    productCloseBtn.addEventListener('click', () => {
        productModal.classList.remove('active');
    });

    productOverlay.addEventListener('click', () => {
        productModal.classList.remove('active');
    });

    // Mobile menu
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const navMenu = document.getElementById('nav-menu');

    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', () => {
            navMenu.style.display = navMenu.style.display === 'flex' ? 'none' : 'flex';
        });
    }

    // Smooth scroll for nav links
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = e.target.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({ behavior: 'smooth' });
            }

            // Update active state
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            e.target.classList.add('active');
        });
    });
}

// Render products
function renderProducts() {
    console.log('🎨 renderProducts() called');
    console.log('📦 Products to render:', products.length);
    console.log('🎯 productGrid element:', productGrid);

    if (!productGrid) {
        console.error('❌ productGrid is NULL! Cannot render products');
        return;
    }

    const filteredProducts = currentFilter === 'all'
        ? products
        : products.filter(p => p.category === currentFilter);

    productGrid.innerHTML = filteredProducts.map(product => `
        <div class="product-card" data-product-id="${product.id}">
            <div class="product-image-wrapper">
                <img src="${product.image}" alt="${product.name}" class="product-image">
                ${product.badge ? `<div class="product-badge">${product.badge}</div>` : ''}
            </div>
            <div class="product-info">
                <div class="product-category">${getCategoryName(product.category)}</div>
                <h3 class="product-title">${product.name}</h3>
                <div class="product-rating">
                    ${generateStars(product.rating)}
                </div>
                <div class="product-footer">
                    <div class="product-price">${formatPrice(product.price)}</div>
                    <button class="add-to-cart-btn" data-product-id="${product.id}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 5v14M5 12h14"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    `).join('');

    // Add click event to product cards
    document.querySelectorAll('.product-card').forEach(card => {
        card.addEventListener('click', (e) => {
            // Không mở modal nếu click vào nút thêm giỏ hàng
            if (e.target.closest('.add-to-cart-btn')) return;

            const productId = parseInt(e.currentTarget.dataset.productId);
            showProductDetail(productId);
        });
    });

    // Add click event to add-to-cart buttons
    document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation(); // Ngăn event bubble lên product-card
            const productId = parseInt(e.currentTarget.dataset.productId);
            console.log('🛒 Button clicked! ProductId:', productId);
            addToCart(productId);
        });
    });

    const buttonCount = document.querySelectorAll('.add-to-cart-btn').length;
    console.log(`✅ Attached event listeners to ${buttonCount} add-to-cart buttons`);
}

// Show product detail
function showProductDetail(productId) {
    const product = products.find(p => p.id === productId);
    if (!product) return;

    productDetail.innerHTML = `
        <div>
            <img src="${product.image}" alt="${product.name}" class="product-detail-image">
        </div>
        <div class="product-detail-info">
            <div class="product-detail-category">${getCategoryName(product.category)}</div>
            <h2>${product.name}</h2>
            <div class="product-rating">
                ${generateStars(product.rating)}
            </div>
            <p class="product-detail-description">${product.description}</p>
            <div class="product-detail-price">${formatPrice(product.price)}</div>
            <button class="btn btn-primary btn-block modal-add-to-cart-btn" data-product-id="${product.id}">
                Thêm Vào Giỏ Hàng
            </button>
        </div>
    `;

    // Add event listener cho nút thêm giỏ hàng trong modal
    const modalBtn = productDetail.querySelector('.modal-add-to-cart-btn');
    if (modalBtn) {
        modalBtn.addEventListener('click', () => {
            const productId = parseInt(modalBtn.dataset.productId);
            addToCart(productId);
            closeProductModal();
        });
    }

    productModal.classList.add('active');
}

function closeProductModal() {
    productModal.classList.remove('active');
}

// Add to cart - Dùng function thông thường, không cần window
function addToCart(productId) {
    console.log('🛒 Adding to cart, productId:', productId);
    console.log('📦 Current cart BEFORE:', JSON.parse(JSON.stringify(cart)));

    const product = products.find(p => p.id === productId);
    if (!product) {
        console.error('❌ Product not found:', productId);
        console.log('Available products:', products);
        return;
    }

    const existingItem = cart.find(item => item.id === productId);
    if (existingItem) {
        existingItem.quantity++;
        console.log('➕ Increased quantity:', existingItem);
    } else {
        cart.push({ ...product, quantity: 1 });
        console.log('✅ Added new item to cart:', product);
    }

    console.log('📦 Current cart AFTER:', JSON.parse(JSON.stringify(cart)));
    console.log('📊 Total items:', cart.reduce((sum, item) => sum + item.quantity, 0));

    updateCartUI();
    showNotification('Đã thêm vào giỏ hàng!');
}

// Remove from cart
function removeFromCart(productId) {
    cart = cart.filter(item => item.id !== productId);
    updateCartUI();
}

// Update quantity
function updateQuantity(productId, delta) {
    const item = cart.find(item => item.id === productId);
    if (!item) return;

    item.quantity += delta;
    if (item.quantity <= 0) {
        removeFromCart(productId);
    } else {
        updateCartUI();
    }
}

// Make functions global for onclick in cartItems HTML
window.updateQuantity = updateQuantity;
window.removeFromCart = removeFromCart;

// Update cart UI
function updateCartUI() {
    console.log('🔄 Updating cart UI...');
    console.log('📦 Cart data:', JSON.parse(JSON.stringify(cart)));
    console.log('🔢 Cart length:', cart.length);

    // Update cart count
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    console.log('📊 Total items calculated:', totalItems);

    if (cartCount) {
        cartCount.textContent = totalItems;
        console.log('✅ Cart count element updated to:', totalItems);
    } else {
        console.error('❌ cartCount element is NULL!');
    }

    // Update cart items
    if (!cartItems) {
        console.error('❌ cartItems element not found');
        return;
    }

    if (cart.length === 0) {
        cartItems.innerHTML = '<p class="empty-cart">Giỏ hàng trống</p>';
    } else {
        cartItems.innerHTML = cart.map(item => `
            <div class="cart-item">
                <img src="${item.image}" alt="${item.name}" class="cart-item-image">
                <div class="cart-item-info">
                    <div class="cart-item-title">${item.name}</div>
                    <div class="cart-item-price">${formatPrice(item.price)} x ${item.quantity}</div>
                    <div class="cart-item-actions">
                        <button onclick="updateQuantity(${item.id}, -1)">-</button>
                        <span>${item.quantity}</span>
                        <button onclick="updateQuantity(${item.id}, 1)">+</button>
                        <button onclick="removeFromCart(${item.id})" style="margin-left: auto; color: var(--color-error);">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
    }

    // Update total price
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    if (totalPrice) {
        totalPrice.textContent = formatPrice(total);
    }

    // Save to localStorage
    try {
        localStorage.setItem('cart', JSON.stringify(cart));
        console.log('💾 Cart saved to localStorage');
    } catch (e) {
        console.error('❌ Error saving cart:', e);
    }
}

// Utility functions
function formatPrice(price) {
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND'
    }).format(price);
}

function getCategoryName(category) {
    const names = {
        electronics: 'Điện Tử',
        fashion: 'Thời Trang',
        home: 'Gia Dụng',
        beauty: 'Làm Đẹp',
        sports: 'Thể Thao',
        books: 'Sách'
    };
    return names[category] || category;
}

function generateStars(rating) {
    let stars = '';
    for (let i = 0; i < 5; i++) {
        stars += i < rating ? '<span>⭐</span>' : '<span style="opacity: 0.3;">⭐</span>';
    }
    return stars;
}

function showNotification(message) {
    // Create notification element
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        background: var(--gradient-primary);
        color: white;
        padding: 16px 24px;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-lg);
        z-index: 3000;
        animation: slideInRight 0.3s ease-out;
    `;
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease-out';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 2000);
}

// Load cart from localStorage
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes slideOutRight {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(100px);
        }
    }
`;
document.head.appendChild(style);
