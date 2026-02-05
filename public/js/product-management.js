// ========== PRODUCT MANAGEMENT FOR HOME PAGE ==========

let allProducts = [];
let allCategories = [];
let isAdmin = false;

// Check if user is admin (tạm thời dùng localStorage)
function checkAdminStatus() {
    isAdmin = localStorage.getItem('isAdmin') === 'true';
    window.isAdmin = isAdmin; // Update global
}

// Filter products by category - ĐỊNH NGHĨA SỚM
function filterByCategory(categoryId) {
    console.log('Filter by category:', categoryId);

    // Update active state
    document.querySelectorAll('.category-card').forEach(card => {
        card.classList.remove('active');
    });

    const activeCard = document.querySelector(`[data-category-id="${categoryId}"]`);
    if (activeCard) {
        activeCard.classList.add('active');
    }

    // Filter products
    const productsGrid = document.getElementById('productsGrid');
    if (!productsGrid) {
        console.error('productsGrid not found');
        return;
    }

    let filteredProducts;
    if (categoryId === 'all') {
        filteredProducts = allProducts;
    } else {
        filteredProducts = allProducts.filter(p => p.category_id == categoryId);
    }

    console.log('Filtered products:', filteredProducts.length);

    // Render filtered products
    if (filteredProducts.length === 0) {
        productsGrid.innerHTML = `
            <div style="grid-column: 1/-1; text-align: center; padding: 3rem;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">📦</div>
                <h3 style="color: #666; font-size: 1.2rem;">Không có sản phẩm trong danh mục này</h3>
            </div>
        `;
    } else {
        productsGrid.innerHTML = filteredProducts.map((p, index) => createProductCard(p, true, index)).join('');
    }

    window.refreshScrollReveal?.();

    // Scroll to products section
    const productsSection = document.getElementById('products');
    if (productsSection) {
        productsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

// Expose to global scope NGAY LẬP TỨC
window.filterByCategory = filterByCategory;
window.isAdmin = false;

// Load products on page load
document.addEventListener('DOMContentLoaded', function () {
    checkAdminStatus();
    loadAllProducts();
    loadAllCategories();

    // Close modal khi click ngoài
    const modals = document.querySelectorAll('.product-modal');
    modals.forEach(modal => {
        modal.addEventListener('click', function (e) {
            if (e.target === this) {
                this.style.display = 'none';
            }
        });
    });
});

// Load all products
function loadAllProducts() {
    fetch('/api/products')
        .then(res => res.json())
        .then(data => {
            allProducts = data;
            renderProducts();
        })
        .catch(err => console.error('Lỗi load sản phẩm:', err));
}

// Load categories
function loadAllCategories() {
    fetch('/api/products/categories')
        .then(res => res.json())
        .then(data => {
            allCategories = data;
            renderCategories(); // Render categories sau khi load xong
        })
        .catch(err => console.error('Lỗi load danh mục:', err));
}

// Render categories
function renderCategories() {
    const categoriesGrid = document.getElementById('categoriesGrid');
    if (!categoriesGrid) return;

    // Icon mapping cho các danh mục
    const iconMap = {
        'Điện Tử': '📱',
        'Thời Trang': '👕',
        'Gia Dụng': '🏠',
        'Làm Đẹp': '💄',
        'Thể Thao': '⚽',
        'Sách': '📚',
        'Đồ Chơi': '🎮',
        'Thực Phẩm': '🍕',
        'Mỹ Phẩm': '💄',
        'Điện Thoại': '📱',
        'Laptop': '💻',
        'Phụ Kiện': '🎧'
    };

    // Lấy icon từ tên danh mục hoặc dùng icon mặc định
    const getIcon = (name) => {
        return iconMap[name] || '🏷️';
    };

    // Thêm nút "Tất Cả" ở đầu
    const allCategoryCard = `
        <div class="category-card reveal active" data-category-id="all" onclick="window.location.href='/products'" style="--reveal-delay: 0ms;">
            <div class="category-icon">🌟</div>
            <div class="category-name">Tất Cả</div>
        </div>
    `;

    categoriesGrid.innerHTML = allCategoryCard + allCategories.map((cat, index) => `
        <div class="category-card reveal" data-category-id="${cat.id}" onclick="window.location.href='/products?category=${cat.id}'" style="--reveal-delay: ${Math.min(240, (index + 1) * 60)}ms;">
            <div class="category-icon">${getIcon(cat.name)}</div>
            <div class="category-name">${cat.name}</div>
        </div>
    `).join('');

    window.refreshScrollReveal?.();
}

// Render products
function renderProducts(categoryFilter = null) {
    const containers = {
        'hot-products': document.querySelector('[data-products-container="hot"]'),
        'categories': document.querySelector('[data-products-container="category"]'),
        'all-products': document.querySelector('[data-products-container="all"]')
    };

    let productsToShow = allProducts;

    // Apply category filter if specified
    if (categoryFilter && categoryFilter !== 'all') {
        productsToShow = allProducts.filter(p => p.category_id == categoryFilter);
    }

    if (containers['hot-products']) {
        const hotProducts = productsToShow.slice(0, 8);
        containers['hot-products'].innerHTML = hotProducts.map((p, index) =>
            createProductCard(p, true, index)
        ).join('');
    }

    if (containers['all-products']) {
        containers['all-products'].innerHTML = productsToShow.map((p, index) =>
            createProductCard(p, false, index)
        ).join('');
    }

    window.refreshScrollReveal?.();
}

// Create product card HTML
function createProductCard(product, isHot = false, index = 0) {
    const categoryName = allCategories.find(c => c.id === product.category_id)?.name || 'Khác';
    const detailUrl = product.slug ? `/products/${product.slug}` : '#';
    const revealDelay = Math.min(280, Math.max(0, index) * 60);

    // Kiểm tra hàng còn hay hết
    const isInStock = product.in_stock === 1 || product.in_stock === true;

    // Ưu tiên main_image, fallback về image với debug logging
    let productImage = product.main_image || product.image;

    // Debug logging
    console.log('Product:', product.name, 'main_image:', product.main_image, 'image:', product.image, 'in_stock:', product.in_stock, 'isInStock:', isInStock);

    // Nếu không có ảnh hoặc ảnh không hợp lệ, dùng placeholder từ Unsplash
    if (!productImage || productImage.trim() === '') {
        productImage = `https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&h=400&fit=crop&q=80`;
    }

    return `
        <div class="product-card reveal" data-product-id="${product.id}" style="--reveal-delay: ${revealDelay}ms;">
            <a class="product-link" href="${detailUrl}">
                <div class="product-image">
                    <img src="${productImage}" alt="${product.image_alt || product.name}" class="product-image-img" onerror="this.src='https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&h=400&fit=crop&q=80'" loading="lazy" style="${!isInStock ? 'opacity: 0.6; filter: grayscale(30%);' : ''}">
                </div>
                ${isHot ? '<span class="hot-badge">🔥 HOT</span>' : ''}
                ${!isInStock ? '<span class="hot-badge" style="background: #ef4444; border-radius: 3px; cursor: not-allowed; font-size: 0.8em; color: white;">Hết hàng</span>' : ''}
                <h3 class="product-title">${product.name}</h3>
            </a>
            <div class="product-category" style="font-size: 0.8em; color: #666; margin-bottom: 5px;">${categoryName}</div>
            <div class="product-price">₫${new Intl.NumberFormat('vi-VN').format(product.price)}</div>
            <div style="display: flex; gap: 8px; margin-top: 10px;">
                <button class="btn-add-cart" onclick="addToCart(${product.id})" style="flex: 1; ${!isInStock ? 'opacity: 0.5; cursor: not-allowed; pointer-events: none;' : ''}" ${!isInStock ? 'disabled' : ''}>
                    ${isInStock ? '⚡ GIỎ HÀNG' : '❌ Hết hàng'}
                </button>
                ${isAdmin ? `
                    <button class="btn-edit-small" onclick="showEditProductModal(${product.id})" title="Sửa">✏️</button>
                    <button class="btn-delete-small" onclick="deleteProductFromHome(${product.id})" title="Xóa">🗑️</button>
                ` : ''}
            </div>
        </div>
    `;
}

// Show add product modal
function showAddProductModal() {
    const modal = document.getElementById('addProductModal');
    if (modal) {
        document.getElementById('productForm').reset();
        document.getElementById('productForm').dataset.productId = '';
        modal.style.display = 'flex';

        // Load categories
        const select = document.getElementById('productCategory');
        if (select && select.children.length <= 1) {
            allCategories.forEach(cat => {
                const option = document.createElement('option');
                option.value = cat.id;
                option.textContent = cat.name;
                select.appendChild(option);
            });
        }
        updateSpecsPlaceholder();
    }
}

// Show edit product modal
function showEditProductModal(productId) {
    if (!isAdmin) {
        alert('Bạn không có quyền sửa sản phẩm');
        return;
    }

    const product = allProducts.find(p => p.id === productId);
    if (!product) return;

    const modal = document.getElementById('addProductModal');
    if (modal) {
        document.getElementById('productForm').dataset.productId = productId;
        document.getElementById('productName').value = product.name;
        document.getElementById('productCategory').value = product.category_id;
        document.getElementById('productPrice').value = product.price;
        document.getElementById('productDescription').value = product.description;
        document.getElementById('productDetailDescription').value = product.detail_description || '';
        document.getElementById('productSpecs').value = product.specs || '';
        document.getElementById('productSpecsTemplate').value = 'auto';
        document.getElementById('productImage').value = product.image || '';

        // Update modal title
        const modalTitle = document.querySelector('#addProductModal .modal-header h2');
        if (modalTitle) {
            modalTitle.textContent = 'Sửa Sản Phẩm';
        }

        modal.style.display = 'flex';
        updateSpecsPlaceholder();
    }
}

// Close modal
function closeProductModal() {
    const modal = document.getElementById('addProductModal');
    if (modal) {
        modal.style.display = 'none';
    }
    document.getElementById('productForm').reset();
    document.getElementById('productForm').dataset.productId = '';
}

// Save product (add or edit)
function saveProduct(event) {
    event.preventDefault();

    if (!isAdmin) {
        alert('Bạn không có quyền thực hiện hành động này');
        return;
    }

    const productId = document.getElementById('productForm').dataset.productId;
    const data = {
        name: document.getElementById('productName').value,
        category_id: document.getElementById('productCategory').value,
        price: document.getElementById('productPrice').value,
        description: document.getElementById('productDescription').value,
        detail_description: document.getElementById('productDetailDescription')?.value || '',
        specs: document.getElementById('productSpecs')?.value || '',
        image: document.getElementById('productImage').value || null,
    };

    const url = productId ? `/api/products/${productId}` : '/api/products';
    const method = productId ? 'PUT' : 'POST';

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
        },
        body: JSON.stringify(data)
    })
        .then(res => res.json())
        .then(result => {
            if (result.error) {
                alert('Lỗi: ' + result.error);
            } else {
                alert(productId ? 'Cập nhật sản phẩm thành công!' : 'Thêm sản phẩm thành công!');
                closeProductModal();
                loadAllProducts();
            }
        })
        .catch(err => {
            console.error('Lỗi:', err);
            alert('Lỗi khi lưu sản phẩm');
        });
}

// Delete product
function deleteProductFromHome(productId) {
    if (!isAdmin) {
        alert('Bạn không có quyền xóa sản phẩm');
        return;
    }

    if (!confirm('Bạn chắc chắn muốn xóa sản phẩm này?')) return;

    fetch(`/api/products/${productId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
        }
    })
        .then(res => res.json())
        .then(result => {
            if (result.error) {
                alert('Lỗi: ' + result.error);
            } else {
                alert('Xóa sản phẩm thành công!');
                loadAllProducts();
            }
        })
        .catch(err => {
            console.error('Lỗi:', err);
            alert('Lỗi khi xóa sản phẩm');
        });
}

// Add to cart (avoid overriding real cart logic if it already exists)
if (typeof window.addToCart !== 'function') {
    window.addToCart = function (productId) {
        const product = allProducts.find(p => Number(p.id) === Number(productId));
        if (product) {
            alert(`???? th??m "${product.name}" v??o gi??? h??ng!`);
            // TODO: Implement cart logic
        }
    };
}

// Enable admin mode (for testing)
function enableAdminMode(password) {
    if (password === 'admin123') {
        localStorage.setItem('isAdmin', 'true');
        checkAdminStatus();
        loadAllProducts(); // Re-render to show admin buttons
        alert('Bạn đã vào chế độ admin!');
    } else {
        alert('Mật khẩu không đúng');
    }
}

function getCategoryNameById(categoryId) {
    const id = Number(categoryId);
    const cat = (allCategories || []).find(c => Number(c.id) === id);
    return cat ? String(cat.name || '').trim() : '';
}

function getSpecsTemplateByCategoryName(name) {
    const normalized = name.toLowerCase();
    if (normalized.includes('điện') || normalized.includes('dien')) {
        return [
            'Thương hiệu:',
            'Model:',
            'CPU:',
            'RAM:',
            'Bộ nhớ:',
            'Màn hình:',
            'Pin:',
            'Bảo hành:'
        ].join('\n');
    }
    if (normalized.includes('thời trang') || normalized.includes('thoi trang')) {
        return [
            'Chất liệu:',
            'Size:',
            'Màu sắc:',
            'Kiểu dáng:',
            'Hướng dẫn giặt:',
            'Xuất xứ:'
        ].join('\n');
    }
    if (normalized.includes('gia dụng') || normalized.includes('gia dung')) {
        return [
            'Chất liệu:',
            'Công suất:',
            'Kích thước:',
            'Trọng lượng:',
            'Bảo hành:',
            'Xuất xứ:'
        ].join('\n');
    }
    if (normalized.includes('sách') || normalized.includes('sach')) {
        return [
            'Tác giả:',
            'Nhà xuất bản:',
            'Năm xuất bản:',
            'Số trang:',
            'Kích thước:'
        ].join('\n');
    }
    return '';
}

function getSpecsTemplateByKey(key, categoryId) {
    if (key === 'auto') {
        return getSpecsTemplateByCategoryName(getCategoryNameById(categoryId));
    }
    if (key === 'electronics') return getSpecsTemplateByCategoryName('điện tử');
    if (key === 'fashion') return getSpecsTemplateByCategoryName('thời trang');
    if (key === 'home') return getSpecsTemplateByCategoryName('gia dụng');
    if (key === 'books') return getSpecsTemplateByCategoryName('sách');
    return '';
}

function updateSpecsPlaceholder() {
    const specsInput = document.getElementById('productSpecs');
    const categorySelect = document.getElementById('productCategory');
    if (!specsInput || !categorySelect) return;
    const template = getSpecsTemplateByKey('auto', categorySelect.value);
    specsInput.placeholder = template || 'Mỗi dòng 1 thông số. VD:\nThương hiệu: Apple\nXuất xứ: Việt Nam';
}

function applySpecsTemplate() {
    const specsInput = document.getElementById('productSpecs');
    const categorySelect = document.getElementById('productCategory');
    const templateSelect = document.getElementById('productSpecsTemplate');
    if (!specsInput || !categorySelect || !templateSelect) return;

    const template = getSpecsTemplateByKey(templateSelect.value, categorySelect.value);
    if (!template) return;

    if (specsInput.value.trim() !== '') {
        if (!confirm('Bạn có muốn ghi đè thông số hiện tại bằng mẫu?')) return;
    }
    specsInput.value = template;
}

document.addEventListener('change', function (e) {
    if (e.target && e.target.id === 'productCategory') {
        updateSpecsPlaceholder();
    }
});
