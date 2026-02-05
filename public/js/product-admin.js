// ========== PRODUCT MANAGEMENT ==========

// Biến global để store additional images
let additionalImages = [];

window.currentProducts = [];
window.currentCategories = window.currentCategories || [];

// Load products page
window.loadProductsPage = function () {
    const pageContent = document.getElementById('page-content');

    // Ẩn tất cả admin pages
    const pages = document.querySelectorAll('.admin-page');
    pages.forEach(page => page.style.display = 'none');

    pageContent.innerHTML = `
        <div class="admin-page" id="productsPage">
            <div class="page-header">
                <div>
                    <h1>Quản Lý Sản Phẩm</h1>
                    <p class="page-subtitle">Thêm, sửa, xóa sản phẩm của bạn</p>
                </div>
                <button class="btn btn-primary" onclick="window.showAddProductModal()">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Thêm Sản Phẩm
                </button>
            </div>

            <div class="admin-table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên Sản Phẩm</th>
                            <th>Danh Mục</th>
                            <th>Giá</th>
                            <th>Mô Tả</th>
                            <th>Trạng thái</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody id="productsTable">
                        <tr><td colspan="6" style="text-align: center;">Đang tải...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Thêm/Sửa Sản Phẩm -->
        <div id="productModal" class="modal" style="display: none;">
            <div class="modal-content" style="max-width: 800px; max-height: 90vh; overflow-y: auto;">
                <div class="modal-header">
                    <h2 id="modalTitle">Thêm Sản Phẩm</h2>
                    <button class="modal-close" onclick="window.closeProductModal()">&times;</button>
                </div>
                <form id="productForm" onsubmit="window.saveProduct(event)">
                    <div class="form-group">
                        <label>Tên Sản Phẩm *</label>
                        <input type="text" id="productName" required placeholder="Nhập tên sản phẩm">
                    </div>

                    <div class="form-group">
                        <label>Danh Mục *</label>
                        <select id="productCategory" required>
                            <option value="">-- Chọn danh mục --</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Giá (đồng) *</label>
                        <input type="number" id="productPrice" required placeholder="0" step="0.01">
                    </div>

                    <div class="form-group">
                        <label>Mô Tả *</label>
                        <textarea id="productDescription" required placeholder="Nhập mô tả sản phẩm"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Mô Tả Chi Tiết</label>
                        <textarea id="productDetailDescription" placeholder="Nhập mô tả chi tiết... (có thể xuống dòng)"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Thông Số Kỹ Thuật</label>
                        <textarea id="productSpecs" placeholder="Mỗi dòng 1 thông số. VD:&#10;Thương hiệu: Apple&#10;Xuất xứ: Việt Nam"></textarea>
                        <div style="display: flex; gap: 8px; margin-top: 8px;">
                            <select id="productSpecsTemplate" style="flex: 1; padding: 10px; border: 2px solid #ddd; border-radius: 8px;">
                                <option value="auto">Tự chọn theo danh mục</option>
                                <option value="electronics">Điện tử</option>
                                <option value="fashion">Thời trang</option>
                                <option value="home">Gia dụng</option>
                                <option value="books">Sách</option>
                                <option value="custom">Tự do (không mẫu)</option>
                            </select>
                            <button type="button" class="btn btn-secondary" onclick="window.applySpecsTemplate()">Áp dụng mẫu</button>
                        </div>
                        <small style="color: #666; display: block; margin-top: 6px;">Chọn mẫu để gợi ý thông số theo danh mục, bạn có thể sửa tự do.</small>
                    </div>

                    <div class="form-group">
                        <label>Ảnh Sản Phẩm</label>
                        <div class="image-upload-section">
                            <div class="main-image-section">
                                <label>Ảnh Chính *</label>
                                
                                <!-- Tab buttons -->
                                <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                                    <button type="button" class="tab-btn active" onclick="window.switchImageTab('upload')" id="uploadTab" style="flex: 1; padding: 10px; border: 2px solid #7851A9; background: #7851A9; color: white; border-radius: 8px; cursor: pointer; font-weight: 600;">
                                        📤 Upload File
                                    </button>
                                    <button type="button" class="tab-btn" onclick="window.switchImageTab('url')" id="urlTab" style="flex: 1; padding: 10px; border: 2px solid #ddd; background: white; color: #666; border-radius: 8px; cursor: pointer; font-weight: 600;">
                                        🔗 Nhập URL
                                    </button>
                                </div>

                                <!-- Upload Tab -->
                                <div id="uploadTabContent" style="display: block;">
                                    <input type="file" id="mainImageUpload" accept="image/*" style="margin-bottom: 10px; width: 100%; padding: 10px; border: 2px dashed #7851A9; border-radius: 8px; cursor: pointer;">
                                    <button type="button" class="btn btn-primary" onclick="window.uploadMainImage()" id="uploadBtn" style="width: 100%; margin-bottom: 10px;">
                                        📤 Upload Ảnh
                                    </button>
                                    <div id="uploadProgress" style="display: none; margin-bottom: 10px;">
                                        <div style="background: #e0e0e0; height: 24px; border-radius: 12px; overflow: hidden; position: relative;">
                                            <div id="progressBar" style="background: linear-gradient(90deg, #7851A9, #a583c7); height: 100%; width: 0%; transition: width 0.3s;"></div>
                                            <span id="progressText" style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); color: white; font-weight: 600; font-size: 12px;">0%</span>
                                        </div>
                                    </div>
                                    <small style="color: #666; display: block;">
                                        ✓ Hỗ trợ: JPG, PNG, GIF, WebP<br>
                                        ✓ Tối đa: 5MB
                                    </small>
                                </div>

                                <!-- URL Tab -->
                                <div id="urlTabContent" style="display: none;">
                                    <input type="text" id="productMainImageUrl" placeholder="https://example.com/image.jpg" style="margin-bottom: 10px; width: 100%; padding: 10px; border: 2px solid #ddd; border-radius: 8px;">
                                    <button type="button" class="btn btn-secondary" onclick="window.previewUrlImage()" style="width: 100%; margin-bottom: 10px;">
                                        👁️ Xem Trước
                                    </button>
                                    <small style="color: #666; display: block;">
                                        💡 Nhập URL ảnh từ Unsplash, Imgur hoặc nguồn khác
                                    </small>
                                </div>

                                <!-- Hidden field to store final URL -->
                                <input type="hidden" id="productMainImage">
                                
                                <!-- Alt text -->
                                <input type="text" id="productImageAlt" placeholder="Mô tả ảnh (Alt text)" style="margin-top: 15px; width: 100%; padding: 10px; border: 2px solid #ddd; border-radius: 8px;">
                                
                                <!-- Preview -->
                                <div id="mainImagePreview" style="margin-top: 15px;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Ảnh Thumbnail</label>
                        <div class="image-upload-section">
                            <div class="additional-images-section">
                                <input type="file" id="additionalImagesUpload" accept="image/*" multiple style="margin-bottom: 10px; width: 100%; padding: 10px; border: 2px dashed #7851A9; border-radius: 8px; cursor: pointer;">
                                <button type="button" class="btn btn-secondary" onclick="window.uploadAdditionalImages()" id="uploadAdditionalBtn" style="width: 100%; margin-bottom: 10px;">
                                    🖼️ Upload Ảnh Phụ
                                </button>
                                <small style="color: #666; display: block;">
                                    ✓ Hỗ trợ: JPG, PNG, GIF, WebP<br>
                                    ✓ Tối đa: 5MB / ảnh
                                </small>
                                <div id="additionalImagesPreview" style="margin-top: 10px;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-actions">
                        <button type="button" class="btn btn-secondary" onclick="window.closeProductModal()">Hủy</button>
                        <button type="submit" class="btn btn-primary">Lưu Sản Phẩm</button>
                    </div>
                </form>
            </div>
        </div>
    `;

    // Load dữ liệu
    window.loadProducts();
    loadCategories();
}

// Load danh sách sản phẩm
window.loadProducts = function () {
    fetch('/api/products')
        .then(res => res.json())
        .then(data => {
            currentProducts = data;
            window.renderProductsTable();
        })
        .catch(err => {
            console.error('Lỗi load sản phẩm:', err);
            document.getElementById('productsTable').innerHTML =
                '<tr><td colspan="6" style="text-align: center; color: red;">Lỗi khi tải dữ liệu</td></tr>';
        });
}

// Load danh sách danh mục
function loadCategories() {
    fetch('/api/products/categories')
        .then(res => res.json())
        .then(data => {
            currentCategories = data;
            const select = document.getElementById('productCategory');
            if (select) {
                data.forEach(cat => {
                    const option = document.createElement('option');
                    option.value = cat.id;
                    option.textContent = cat.name;
                    select.appendChild(option);
                });
            }
        })
        .catch(err => console.error('Lỗi load danh mục:', err));
}

// Toggle product stock status
window.toggleProductStock = async function (productId, isChecked) {
    try {
        console.log('Toggling product stock:', productId, isChecked);

        const response = await fetch(`/api/products/${productId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                in_stock: isChecked ? 1 : 0
            })
        });

        if (response.ok) {
            console.log('Toggle success, reloading products...');
            // Reload products list
            window.loadProducts();
        } else {
            const errorData = await response.json();
            console.error('Toggle failed:', errorData);
            alert('Không thể cập nhật trạng thái: ' + (errorData.message || JSON.stringify(errorData)));
            // Revert checkbox
            event.target.checked = !isChecked;
        }
    } catch (error) {
        console.error('Lỗi khi toggle stock:', error);
        alert('Không thể cập nhật trạng thái: ' + error.message);
        // Revert checkbox
        event.target.checked = !isChecked;
    }
}

// Render bảng sản phẩm
window.renderProductsTable = function () {
    const tbody = document.getElementById('productsTable');

    if (currentProducts.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" style="text-align: center;">Chưa có sản phẩm nào</td></tr>';
        return;
    }

    tbody.innerHTML = currentProducts.map(product => {
        const isInStock = product.in_stock !== false;
        return `
        <tr style="${!isInStock ? 'opacity: 0.6;' : ''}">
            <td>#${product.id}</td>
            <td><strong>${product.name}</strong></td>
            <td>${product.category?.name || 'N/A'}</td>
            <td>${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(product.price)}</td>
            <td>${product.description.substring(0, 40)}...</td>
            <td>
                <label class="toggle-switch" style="display: inline-block; position: relative; width: 44px; height: 24px;">
                    <input 
                        type="checkbox" 
                        ${isInStock ? 'checked' : ''} 
                        onchange="window.toggleProductStock(${product.id}, this.checked)"
                        style="opacity: 0; width: 0; height: 0;"
                    >
                    <span style="
                        position: absolute;
                        cursor: pointer;
                        top: 0;
                        left: 0;
                        right: 0;
                        bottom: 0;
                        background-color: ${isInStock ? '#16a34a' : '#ccc'};
                        transition: 0.3s;
                        border-radius: 24px;
                    ">
                        <span style="
                            position: absolute;
                            content: '';
                            height: 18px;
                            width: 18px;
                            left: ${isInStock ? '23px' : '3px'};
                            bottom: 3px;
                            background-color: white;
                            transition: 0.3s;
                            border-radius: 50%;
                        "></span>
                    </span>
                </label>
                <span style="margin-left: 8px; font-size: 12px; color: ${isInStock ? '#16a34a' : '#ef4444'}; font-weight: 600;">
                    ${isInStock ? 'Còn hàng' : 'Hết hàng'}
                </span>
            </td>
            <td>
                <div class="action-buttons">
                    <button class="btn btn-sm btn-secondary" onclick="window.showEditProductModal(${product.id})" title="Sửa">✏️</button>
                    <button class="btn btn-sm btn-primary" onclick="window.openVariantsManager(${product.id}, '${product.name}')" title="Quản lý Variants">🎨</button>
                    <button class="btn btn-sm btn-danger" onclick="window.deleteProduct(${product.id})" title="Xóa">🗑️</button>
                </div>
            </td>
        </tr>
    `;
    }).join('');
}

// Hiển thị modal thêm sản phẩm
window.showAddProductModal = function () {
    document.getElementById('modalTitle').textContent = 'Thêm Sản Phẩm Mới';
    document.getElementById('productForm').reset();
    document.getElementById('productForm').dataset.productId = '';
    document.getElementById('productModal').style.display = 'flex';

    // Clear image preview
    const preview = document.getElementById('mainImagePreview');
    if (preview) preview.innerHTML = '';
    clearAdditionalImages();
    setTimeout(() => {
        updateSpecsPlaceholder();
    }, 0);

    // Initialize image upload after modal is visible
    setTimeout(() => {
        setupImageUpload();
    }, 100);
}

// Hiển thị modal sửa sản phẩm
window.showEditProductModal = function (id) {
    const product = currentProducts.find(p => p.id === id);
    if (!product) return;

    document.getElementById('modalTitle').textContent = 'Sửa Sản Phẩm';
    document.getElementById('productName').value = product.name;
    document.getElementById('productCategory').value = product.category_id;
    document.getElementById('productPrice').value = product.price;
    document.getElementById('productDescription').value = product.description || '';
    document.getElementById('productDetailDescription').value = product.detail_description || '';
    document.getElementById('productSpecs').value = product.specs || '';
    document.getElementById('productSpecsTemplate').value = 'auto';
    document.getElementById('productMainImage').value = product.main_image || product.image || '';
    document.getElementById('productImageAlt').value = product.image_alt || '';
    document.getElementById('productForm').dataset.productId = id;
    document.getElementById('productModal').style.display = 'flex';

    // Show existing main image if available
    const mainImageUrl = product.main_image || product.image;
    if (mainImageUrl) {
        // If it's a URL, switch to URL tab and fill the input
        if (mainImageUrl.startsWith('http')) {
            window.switchImageTab('url');
            document.getElementById('productMainImageUrl').value = mainImageUrl;
        }
        window.previewMainImageFromUrl(mainImageUrl);
    } else {
        document.getElementById('mainImagePreview').innerHTML = '';
    }

    // Load additional images if available
    if (product.additional_images) {
        let extraImages = [];
        if (Array.isArray(product.additional_images)) {
            extraImages = product.additional_images;
        } else {
            try {
                extraImages = JSON.parse(product.additional_images || '[]') || [];
            } catch (e) {
                extraImages = [];
            }
        }
        additionalImages = extraImages.filter(url => url && String(url).trim() !== '');
        updateAdditionalImagesPreview();
    } else {
        clearAdditionalImages();
    }

    // Initialize image upload after modal is visible
    setTimeout(() => {
        setupImageUpload();
        updateSpecsPlaceholder();
    }, 100);
}

// ============ QUẢN LÝ VARIANTS - MODAL RIÊNG ============

// Mở modal quản lý variants
window.openVariantsManager = function (productId, productName) {
    console.log('Opening variants manager for product:', productId, productName);

    const modalHtml = `
        <div class="modal-overlay" id="variantsManagerModal" style="
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        ">
            <div class="modal-container" style="
                background: white;
                border-radius: 12px;
                max-width: 900px;
                max-height: 90vh;
                overflow-y: auto;
                width: 90%;
                box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            ">
                <div class="modal-header" style="
                    display: flex;
                    justify-content: space-between;
                    align-items: start;
                    padding: 20px;
                    border-bottom: 1px solid #ddd;
                ">
                    <div>
                        <h2 style="margin: 0;">🎨 Quản Lý Variants</h2>
                        <p style="margin: 5px 0 0; color: #666; font-size: 14px;">Sản phẩm: <strong>${productName}</strong></p>
                    </div>
                    <button type="button" onclick="closeVariantsManager()" style="
                        background: none;
                        border: none;
                        font-size: 24px;
                        cursor: pointer;
                        color: #666;
                    ">✖</button>
                </div>
                <div style="padding: 20px;">
                    <div style="display: flex; gap: 10px; margin-bottom: 20px;">
                        <button type="button" class="btn btn-primary" onclick="window.openVariantForm(${productId})" style="padding: 10px 20px; cursor: pointer;">
                            ➕ Thêm Variant
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="window.openVariantQuickAdd(${productId})" style="padding: 10px 20px; cursor: pointer;">
                            ⚡ Thêm Nhanh (Tổ hợp)
                        </button>
                    </div>
                    <div id="variants-list-${productId}" style="min-height: 200px;">
                        <p style="text-align: center; color: #999;">Đang tải...</p>
                    </div>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', modalHtml);
    console.log('Modal HTML inserted, loading variants...');
    loadProductVariants(productId);
}

// Đóng modal quản lý variants
window.closeVariantsManager = function () {
    const modal = document.getElementById('variantsManagerModal');
    if (modal) modal.remove();
}

// Load và hiển thị variants của sản phẩm
async function loadProductVariants(productId) {
    try {
        const response = await fetch(`/api/products/${productId}/variants`);
        const variants = await response.json();

        const container = document.getElementById(`variants-list-${productId}`);
        if (!container) return;

        container.innerHTML = renderVariantsList(variants, productId);

    } catch (error) {
        console.error('Lỗi khi tải variants:', error);
        const container = document.getElementById(`variants-list-${productId}`);
        if (container) {
            container.innerHTML = '<p style="color: red; text-align: center;">Lỗi khi tải danh sách variants</p>';
        }
    }
}

// Render danh sách variants
function renderVariantsList(variants, productId) {
    if (!variants || variants.length === 0) {
        return '<p style="color: #999; text-align: center; padding: 20px;">Chưa có variant nào. Nhấn "Thêm Variant" để bắt đầu.</p>';
    }

    return `
        <table class="admin-table" style="font-size: 13px;">
            <thead>
                <tr>
                    <th>Size</th>
                    <th>Màu</th>
                    <th>Giá</th>
                    <th>Tồn kho</th>
                    <th>SKU</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                ${variants.map(v => {
        const isInStock = v.stock > 0;
        return `
                    <tr style="${!isInStock ? 'opacity: 0.6;' : ''}">
                        <td>${v.size || '-'}</td>
                        <td>${v.color || '-'}</td>
                        <td>${new Intl.NumberFormat('vi-VN').format(v.price)}đ</td>
                        <td>
                            <span style="color: ${isInStock ? '#16a34a' : '#ef4444'}; font-weight: 600;">
                                ${isInStock ? v.stock : 'Hết hàng'}
                            </span>
                        </td>
                        <td>${v.sku || '-'}</td>
                        <td style="white-space: nowrap;">
                            <label class="toggle-switch" style="display: inline-block; margin-right: 8px; position: relative; width: 44px; height: 24px;">
                                <input 
                                    type="checkbox" 
                                    ${isInStock ? 'checked' : ''} 
                                    onchange="window.toggleVariantStock(${v.id}, ${productId}, this.checked)"
                                    style="opacity: 0; width: 0; height: 0;"
                                >
                                <span style="
                                    position: absolute;
                                    cursor: pointer;
                                    top: 0;
                                    left: 0;
                                    right: 0;
                                    bottom: 0;
                                    background-color: ${isInStock ? '#16a34a' : '#ccc'};
                                    transition: 0.3s;
                                    border-radius: 24px;
                                ">
                                    <span style="
                                        position: absolute;
                                        content: '';
                                        height: 18px;
                                        width: 18px;
                                        left: ${isInStock ? '23px' : '3px'};
                                        bottom: 3px;
                                        background-color: white;
                                        transition: 0.3s;
                                        border-radius: 50%;
                                    "></span>
                                </span>
                            </label>
                            <button type="button" class="btn btn-sm btn-secondary" onclick="window.editVariant(${v.id}, ${productId})" title="Sửa" style="cursor: pointer; margin-right: 5px;">✏️</button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="window.deleteVariant(${v.id}, ${productId})" title="Xóa" style="cursor: pointer;">🗑️</button>
                        </td>
                    </tr>
                `;
    }).join('')}
            </tbody>
        </table>
    `;
}

// Mở form thêm variant
window.openVariantForm = function (productId, variantData = null) {
    console.log('Opening variant form for product:', productId);
    const isEdit = !!variantData;
    const title = isEdit ? 'Sửa Variant' : 'Thêm Variant Mới';

    const formHtml = `
        <div class="modal-overlay" id="variantModal" onclick="if(event.target.id === 'variantModal') window.closeVariantForm()" style="
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10000;
        ">
            <div class="modal-container" onclick="event.stopPropagation()" style="
                background: white;
                border-radius: 12px;
                max-width: 600px;
                width: 90%;
                box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            ">
                <div class="modal-header" style="
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 20px;
                    border-bottom: 1px solid #ddd;
                ">
                    <h2 style="margin: 0;">${title}</h2>
                    <button type="button" onclick="window.closeVariantForm()" style="
                        background: none;
                        border: none;
                        font-size: 24px;
                        cursor: pointer;
                        color: #666;
                    ">✖</button>
                </div>
                <form id="variantForm" onsubmit="window.saveVariant(event, ${productId}, ${isEdit ? variantData.id : 'null'})" style="padding: 20px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Size</label>
                            <input type="text" name="size" placeholder="VD: S, M, L, XL" value="${isEdit ? (variantData.size || '') : ''}" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Màu sắc</label>
                            <input type="text" name="color" placeholder="VD: Đỏ, Xanh, Đen" value="${isEdit ? (variantData.color || '') : ''}" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Giá <span style="color: red;">*</span></label>
                            <input type="number" name="price" required min="0" step="1000" placeholder="VD: 299000" value="${isEdit ? variantData.price : ''}" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Tồn kho <span style="color: red;">*</span></label>
                            <input type="number" name="stock" required min="0" placeholder="VD: 100" value="${isEdit ? variantData.stock : '0'}" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        </div>
                        <div style="grid-column: 1 / -1;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 500;">SKU (Mã sản phẩm)</label>
                            <input type="text" name="sku" placeholder="Tự động tạo nếu để trống" value="${isEdit ? (variantData.sku || '') : ''}" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        </div>
                    </div>
                    <div style="margin-top: 20px; display: flex; gap: 10px; justify-content: flex-end;">
                        <button type="button" class="btn btn-secondary" onclick="window.closeVariantForm()" style="padding: 10px 20px; cursor: pointer;">Hủy</button>
                        <button type="submit" class="btn btn-primary" style="padding: 10px 20px; cursor: pointer;">${isEdit ? 'Cập nhật' : 'Thêm'}</button>
                    </div>
                </form>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', formHtml);
}

// Đóng form variant
window.closeVariantForm = function () {
    const modal = document.getElementById('variantModal');
    if (modal) modal.remove();
}

// Lưu variant
window.saveVariant = async function (event, productId, variantId) {
    event.preventDefault();
    const form = event.target;
    const formData = {
        product_id: productId,
        size: form.size.value || null,
        color: form.color.value || null,
        price: parseFloat(form.price.value),
        stock: parseInt(form.stock.value),
        sku: form.sku.value || null
    };

    try {
        const url = variantId ? `/api/products/variants/${variantId}` : '/api/products/variants';
        const method = variantId ? 'PUT' : 'POST';

        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(formData)
        });

        if (response.ok) {
            alert(variantId ? 'Cập nhật variant thành công!' : 'Thêm variant thành công!');
            closeVariantForm();
            loadProductVariants(productId); // Reload variants list
        } else {
            const error = await response.json();
            alert('Lỗi: ' + JSON.stringify(error));
        }
    } catch (error) {
        console.error('Lỗi khi lưu variant:', error);
        alert('Không thể lưu variant');
    }
}

// Sửa variant
window.editVariant = async function (variantId, productId) {
    try {
        const response = await fetch(`/api/products/${productId}/variants`);
        const variants = await response.json();
        const variant = variants.find(v => v.id === variantId);

        if (variant) {
            openVariantForm(productId, variant);
        }
    } catch (error) {
        console.error('Lỗi khi load variant:', error);
        alert('Không thể load thông tin variant');
    }
}

// Xóa variant
window.deleteVariant = async function (variantId, productId) {
    if (!confirm('Bạn có chắc muốn xóa variant này?')) return;

    try {
        const response = await fetch(`/api/products/variants/${variantId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        if (response.ok) {
            alert('Xóa variant thành công!');
            loadProductVariants(productId);
        } else {
            alert('Không thể xóa variant');
        }
    } catch (error) {
        console.error('Lỗi khi xóa variant:', error);
        alert('Không thể xóa variant');
    }
}

// Toggle stock status (còn hàng/hết hàng)
window.toggleVariantStock = async function (variantId, productId, isChecked) {
    try {
        // Lấy thông tin variant hiện tại
        const response = await fetch(`/api/products/${productId}/variants`);
        const variants = await response.json();
        const variant = variants.find(v => v.id === variantId);

        if (!variant) {
            alert('Không tìm thấy variant');
            return;
        }

        // Nếu bật (còn hàng) thì set stock = 100, nếu tắt (hết hàng) thì set stock = 0
        const newStock = isChecked ? 100 : 0;

        const updateResponse = await fetch(`/api/products/variants/${variantId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                size: variant.size,
                color: variant.color,
                price: variant.price,
                stock: newStock,
                sku: variant.sku
            })
        });

        if (updateResponse.ok) {
            loadProductVariants(productId); // Reload variants list
        } else {
            alert('Không thể cập nhật trạng thái');
            // Revert checkbox
            event.target.checked = !isChecked;
        }
    } catch (error) {
        console.error('Lỗi khi toggle stock:', error);
        alert('Không thể cập nhật trạng thái');
        // Revert checkbox
        event.target.checked = !isChecked;
    }
}

// Thêm nhanh nhiều variants
window.openVariantQuickAdd = function (productId) {
    const formHtml = `
        <div class="modal-overlay" id="variantQuickModal" onclick="if(event.target.id === 'variantQuickModal') closeVariantQuickAdd()">
            <div class="modal-container" style="max-width: 700px;">
                <div class="modal-header">
                    <h2>Thêm Nhanh Nhiều Variants</h2>
                    <button type="button" onclick="closeVariantQuickAdd()">✖</button>
                </div>
                <form id="variantQuickForm" onsubmit="saveQuickVariants(event, ${productId})">
                    <div class="form-group">
                        <label>Sizes (phân cách bằng dấu phẩy)</label>
                        <input type="text" name="sizes" placeholder="VD: S, M, L, XL" required>
                        <small style="color: #666;">Nhập các size, mỗi size cách nhau bởi dấu phẩy</small>
                    </div>
                    <div class="form-group">
                        <label>Màu sắc (phân cách bằng dấu phẩy)</label>
                        <input type="text" name="colors" placeholder="VD: Đỏ, Xanh, Đen, Trắng" required>
                        <small style="color: #666;">Nhập các màu, mỗi màu cách nhau bởi dấu phẩy</small>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Giá cơ bản <span style="color: red;">*</span></label>
                            <input type="number" name="base_price" required min="0" step="1000" placeholder="299000">
                            <small style="color: #666;">Giá áp dụng cho tất cả variants</small>
                        </div>
                        <div class="form-group">
                            <label>Tồn kho cho mỗi variant</label>
                            <input type="number" name="stock" required min="0" placeholder="50">
                        </div>
                    </div>
                    <div class="alert" style="background: #e3f2fd; padding: 15px; border-radius: 8px; margin: 15px 0;">
                        <strong>📌 Lưu ý:</strong> Hệ thống sẽ tạo tất cả tổ hợp có thể. 
                        VD: 4 sizes × 4 màu = 16 variants
                    </div>
                    <div class="form-actions" style="margin-top: 20px;">
                        <button type="button" class="btn btn-secondary" onclick="closeVariantQuickAdd()">Hủy</button>
                        <button type="submit" class="btn btn-primary">Tạo Variants</button>
                    </div>
                </form>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', formHtml);
}

// Đóng form quick add
window.closeVariantQuickAdd = function () {
    const modal = document.getElementById('variantQuickModal');
    if (modal) modal.remove();
}

// Lưu nhiều variants cùng lúc
window.saveQuickVariants = async function (event, productId) {
    event.preventDefault();
    const form = event.target;

    const sizes = form.sizes.value.split(',').map(s => s.trim()).filter(s => s);
    const colors = form.colors.value.split(',').map(c => c.trim()).filter(c => c);
    const basePrice = parseFloat(form.base_price.value);
    const stock = parseInt(form.stock.value);

    if (sizes.length === 0 || colors.length === 0) {
        alert('Vui lòng nhập ít nhất 1 size và 1 màu');
        return;
    }

    // Tạo tất cả tổ hợp
    const variants = [];
    for (const size of sizes) {
        for (const color of colors) {
            variants.push({
                size: size,
                color: color,
                price: basePrice,
                stock: stock,
                sku: `${productId}-${size}-${color}`
            });
        }
    }

    if (!confirm(`Bạn sắp tạo ${variants.length} variants. Tiếp tục?`)) return;

    try {
        const response = await fetch('/api/products/variants/bulk', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                product_id: productId,
                variants: variants
            })
        });

        if (response.ok) {
            alert(`Đã tạo ${variants.length} variants thành công!`);
            closeVariantQuickAdd();
            loadProductVariants(productId);
        } else {
            const error = await response.json();
            alert('Lỗi: ' + JSON.stringify(error));
        }
    } catch (error) {
        console.error('Lỗi khi tạo variants:', error);
        alert('Không thể tạo variants');
    }
}

// Đóng modal
window.closeProductModal = function () {
    // Reset form and hide modal
    document.getElementById('productModal').style.display = 'none';
    document.getElementById('productForm').reset();
    document.getElementById('productForm').dataset.productId = '';

    // Clear all images
    clearAdditionalImages();
    document.getElementById('mainImagePreview').innerHTML = '';
}

// Lưu sản phẩm (thêm/sửa)
window.saveProduct = function (event) {
    event.preventDefault();

    const productId = document.getElementById('productForm').dataset.productId;

    // Get description from textarea (no TinyMCE)
    const description = document.getElementById('productDescription').value;

    // Get main image URL
    const mainImageUrl = document.getElementById('productMainImage').value.trim();
    const imageAlt = document.getElementById('productImageAlt')?.value || '';

    // Validate required fields
    if (!document.getElementById('productName').value.trim()) {
        alert('Vui lòng nhập tên sản phẩm!');
        return;
    }

    if (!document.getElementById('productCategory').value) {
        alert('Vui lòng chọn danh mục!');
        return;
    }

    if (!document.getElementById('productPrice').value) {
        alert('Vui lòng nhập giá!');
        return;
    }

    // Validate image URL if provided
    if (mainImageUrl && !isValidUrl(mainImageUrl)) {
        alert('URL ảnh không hợp lệ! Vui lòng nhập URL đầy đủ (bắt đầu với http:// hoặc https://)');
        return;
    }

    const data = {
        name: document.getElementById('productName').value,
        category_id: document.getElementById('productCategory').value,
        price: document.getElementById('productPrice').value,
        description: description,
        detail_description: document.getElementById('productDetailDescription')?.value || '',
        specs: document.getElementById('productSpecs')?.value || '',
        image: mainImageUrl || null,
        main_image: mainImageUrl || null,
        image_alt: imageAlt,
        additional_images: additionalImages,
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
                window.closeProductModal();
                window.loadProducts();
            }
        })
        .catch(err => {
            console.error('Lỗi:', err);
            alert('Lỗi khi lưu sản phẩm');
        });
}

// Helper function to validate URL
function isValidUrl(string) {
    try {
        if (string.startsWith('data:image/')) return true;
        if (string.startsWith('/') || string.startsWith('./')) return true;
        if (string.startsWith('images/') || string.startsWith('storage/')) return true;
        const url = new URL(string);
        return url.protocol === 'http:' || url.protocol === 'https:';
    } catch (_) {
        return false;
    }
}

function getCategoryNameById(categoryId) {
    const id = Number(categoryId);
    const cat = (window.currentCategories || []).find(c => Number(c.id) === id);
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

window.applySpecsTemplate = function () {
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

// Update specs placeholder when category changes
document.addEventListener('change', function (e) {
    if (e.target && e.target.id === 'productCategory') {
        updateSpecsPlaceholder();
    }
});

// Upload main image
window.uploadMainImage = async function () {
    const fileInput = document.getElementById('mainImageUpload');
    const uploadBtn = document.getElementById('uploadBtn');
    const progressDiv = document.getElementById('uploadProgress');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    const imageUrlInput = document.getElementById('productMainImage');

    const file = fileInput.files[0];
    if (!file) {
        alert('Vui lòng chọn file ảnh!');
        return;
    }

    // Validate file type
    if (!file.type.startsWith('image/')) {
        alert('Vui lòng chọn file ảnh (jpg, png, gif, webp)!');
        return;
    }

    // Validate file size (max 5MB)
    if (file.size > 5 * 1024 * 1024) {
        alert('Kích thước file không được vượt quá 5MB!');
        return;
    }

    try {
        // Show progress
        uploadBtn.disabled = true;
        uploadBtn.textContent = '⏳ Đang upload...';
        progressDiv.style.display = 'block';
        progressBar.style.width = '0%';

        // Create form data
        const formData = new FormData();
        formData.append('image', file);

        // Simulate progress
        let progress = 0;
        const progressInterval = setInterval(() => {
            progress += 10;
            if (progress <= 90) {
                progressBar.style.width = progress + '%';
                progressText.textContent = `Đang upload... ${progress}%`;
            }
        }, 100);

        // Upload
        const response = await fetch('/api/upload-image', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            },
            body: formData
        });

        clearInterval(progressInterval);

        const result = await response.json();

        if (result.success) {
            progressBar.style.width = '100%';
            progressText.textContent = '100% ✓';

            // Set URL to hidden input
            document.getElementById('productMainImage').value = result.url;

            // Show preview
            window.previewMainImageFromUrl(result.url);

            // Reset after 2s
            setTimeout(() => {
                progressDiv.style.display = 'none';
                progressBar.style.width = '0%';
                progressText.textContent = '0%';
                uploadBtn.disabled = false;
                uploadBtn.textContent = '📤 Upload Ảnh';
            }, 2000);

        } else {
            throw new Error(result.message || 'Upload thất bại');
        }

    } catch (error) {
        console.error('Upload error:', error);
        alert('Lỗi upload ảnh: ' + error.message);
        progressDiv.style.display = 'none';
        uploadBtn.disabled = false;
        uploadBtn.textContent = '📤 Upload Ảnh';
    }
}

// Switch between upload and URL tabs
window.switchImageTab = function (tab) {
    const uploadTab = document.getElementById('uploadTab');
    const urlTab = document.getElementById('urlTab');
    const uploadContent = document.getElementById('uploadTabContent');
    const urlContent = document.getElementById('urlTabContent');

    if (tab === 'upload') {
        uploadTab.style.background = '#7851A9';
        uploadTab.style.color = 'white';
        uploadTab.style.borderColor = '#7851A9';
        urlTab.style.background = 'white';
        urlTab.style.color = '#666';
        urlTab.style.borderColor = '#ddd';
        uploadContent.style.display = 'block';
        urlContent.style.display = 'none';
    } else {
        urlTab.style.background = '#7851A9';
        urlTab.style.color = 'white';
        urlTab.style.borderColor = '#7851A9';
        uploadTab.style.background = 'white';
        uploadTab.style.color = '#666';
        uploadTab.style.borderColor = '#ddd';
        urlContent.style.display = 'block';
        uploadContent.style.display = 'none';
    }
}

// Preview URL image
window.previewUrlImage = function () {
    const url = document.getElementById('productMainImageUrl').value.trim();

    if (!url) {
        alert('Vui lòng nhập URL ảnh!');
        return;
    }

    if (!isValidUrl(url)) {
        alert('URL không hợp lệ! Vui lòng nhập URL đầy đủ (bắt đầu với http:// hoặc https://)');
        return;
    }

    // Set to hidden input
    document.getElementById('productMainImage').value = url;

    // Show preview
    window.previewMainImageFromUrl(url);
}

// Xóa sản phẩm
window.deleteProduct = function (id) {
    if (!confirm('Bạn chắc chắn muốn xóa sản phẩm này?')) return;

    fetch(`/api/products/${id}`, {
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
                window.loadProducts();
            }
        })
        .catch(err => {
            console.error('Lỗi:', err);
            alert('Lỗi khi xóa sản phẩm');
        });
}

// ========== TINYMCE & IMAGE HANDLING ==========

let mainImageFile = null;

// Handle main image upload
// Handle main image upload setup
function setupImageUpload() {
    // No need for event listeners anymore as we use buttons
    // Just ensure the modal is ready
    console.log('Image upload ready');
}

// Preview main image from file
function previewMainImage(file) {
    const preview = document.getElementById('mainImagePreview');
    const reader = new FileReader();

    reader.onload = function (e) {
        preview.innerHTML = `
            <div style="position: relative; display: inline-block;">
                <img src="${e.target.result}" alt="Preview" style="max-width: 200px; max-height: 150px; border: 1px solid #ddd; border-radius: 4px;">
                <button type="button" onclick="removeMainImage()" style="position: absolute; top: -5px; right: -5px; background: red; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer;">×</button>
            </div>
        `;
    };

    reader.readAsDataURL(file);
}

// Preview main image from URL
window.previewMainImageFromUrl = function (url) {
    if (!url || url.trim() === '') {
        document.getElementById('mainImagePreview').innerHTML = '';
        return;
    }

    const preview = document.getElementById('mainImagePreview');
    preview.innerHTML = '';

    const container = document.createElement('div');
    container.style.cssText = 'position: relative; display: inline-block;';

    const img = document.createElement('img');
    img.src = url;
    img.alt = 'Preview';
    img.style.cssText = 'max-width: 200px; max-height: 150px; border: 1px solid #ddd; border-radius: 4px;';
    img.onerror = function () {
        container.innerHTML = '';
        const errorBox = document.createElement('div');
        errorBox.textContent = '❌ URL ảnh không hợp lệ';
        errorBox.style.cssText = 'padding: 10px; background: #fee; border: 1px solid #fcc; border-radius: 4px; color: #c33;';
        container.appendChild(errorBox);
    };

    const removeBtn = document.createElement('button');
    removeBtn.type = 'button';
    removeBtn.textContent = '×';
    removeBtn.onclick = window.removeMainImage;
    removeBtn.style.cssText = 'position: absolute; top: -5px; right: -5px; background: red; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer;';

    container.appendChild(img);
    container.appendChild(removeBtn);
    preview.appendChild(container);
}

// Preview additional images
function previewAdditionalImages(files) {
    const preview = document.getElementById('additionalImagesPreview');
    preview.innerHTML = '';

    files.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function (e) {
            const imageDiv = document.createElement('div');
            imageDiv.style.position = 'relative';
            imageDiv.style.display = 'inline-block';
            imageDiv.innerHTML = `
                <img src="${e.target.result}" alt="Additional ${index + 1}" style="width: 80px; height: 80px; object-fit: cover; border: 1px solid #ddd; border-radius: 4px;">
                <button type="button" onclick="removeAdditionalImage(${index})" style="position: absolute; top: -5px; right: -5px; background: red; color: white; border: none; border-radius: 50%; width: 18px; height: 18px; cursor: pointer; font-size: 12px;">×</button>
            `;
            preview.appendChild(imageDiv);
        };
        reader.readAsDataURL(file);
    });
}

// Remove main image
window.removeMainImage = function () {
    const preview = document.getElementById('mainImagePreview');
    const input = document.getElementById('productMainImage');
    const uploadInput = document.getElementById('mainImageUpload');

    if (preview) preview.innerHTML = '';
    if (input) input.value = '';
    if (uploadInput) uploadInput.value = '';

    console.log('Main image removed');
}

// Remove additional image
window.removeAdditionalImage = function (index) {
    additionalImages.splice(index, 1);
    updateAdditionalImagesPreview();
}

// ========== ADDITIONAL IMAGES FUNCTIONS ==========

window.uploadAdditionalImages = async function () {
    const input = document.getElementById('additionalImagesUpload');
    const uploadBtn = document.getElementById('uploadAdditionalBtn');
    if (!input) return;

    const files = Array.from(input.files || []);
    if (files.length === 0) {
        alert('Vui lòng chọn ít nhất 1 ảnh phụ!');
        return;
    }

    const invalidFile = files.find(file => !file.type.startsWith('image/'));
    if (invalidFile) {
        alert('Vui lòng chỉ chọn file ảnh (jpg, png, gif, webp)!');
        return;
    }

    const oversized = files.find(file => file.size > 5 * 1024 * 1024);
    if (oversized) {
        alert('Có ảnh vượt quá 5MB. Vui lòng chọn ảnh nhỏ hơn!');
        return;
    }

    uploadBtn.disabled = true;
    uploadBtn.textContent = '⏳ Đang upload...';

    let successCount = 0;
    let errorCount = 0;

    for (const file of files) {
        try {
            const formData = new FormData();
            formData.append('image', file);

            const response = await fetch('/api/upload-image', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                },
                body: formData
            });

            const result = await response.json();
            if (result.success && result.url) {
                additionalImages.push(result.url);
                successCount++;
            } else {
                errorCount++;
            }
        } catch (error) {
            console.error('Upload additional image error:', error);
            errorCount++;
        }
    }

    updateAdditionalImagesPreview();
    input.value = '';
    uploadBtn.disabled = false;
    uploadBtn.textContent = '🖼️ Upload Ảnh Phụ';

    if (errorCount > 0) {
        alert(`Upload xong: ${successCount} ảnh thành công, ${errorCount} ảnh lỗi`);
    }
}

function updateAdditionalImagesPreview() {
    const preview = document.getElementById('additionalImagesPreview');
    if (!preview) return;

    preview.innerHTML = '';

    additionalImages.forEach((imageUrl, index) => {
        const imageContainer = document.createElement('div');
        imageContainer.style.cssText = 'position: relative; display: inline-block; margin: 5px;';

        const img = document.createElement('img');
        img.src = imageUrl;
        img.style.cssText = 'width: 80px; height: 80px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;';

        const removeBtn = document.createElement('button');
        removeBtn.innerHTML = '×';
        removeBtn.type = 'button';
        removeBtn.style.cssText = 'position: absolute; top: -5px; right: -5px; background: red; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 12px; line-height: 1;';
        removeBtn.onclick = () => removeAdditionalImage(index);

        imageContainer.appendChild(img);
        imageContainer.appendChild(removeBtn);
        preview.appendChild(imageContainer);
    });
}

function clearAdditionalImages() {
    additionalImages = [];
    const preview = document.getElementById('additionalImagesPreview');
    if (preview) preview.innerHTML = '';
}


