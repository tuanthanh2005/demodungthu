<!-- Quick Add to Cart Modal -->
<div class="modal fade" id="quickAddModal" tabindex="-1" aria-labelledby="quickAddModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="quickAddModalLabel">Chọn tùy chọn sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Product Info -->
                <div class="d-flex gap-3 mb-4 pb-3 border-bottom">
                    <img id="modalProductImage" src="" alt="" class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                    <div class="flex-grow-1">
                        <h6 class="mb-1 fw-bold" id="modalProductName"></h6>
                        <p class="mb-0 text-danger fw-bold fs-5" id="modalProductPrice"></p>
                    </div>
                </div>

                <!-- Size Selection -->
                <div class="mb-4" id="modalSizeSection" style="display: none;">
                    <label class="fw-bold mb-2 d-block">Kích thước: <span class="text-danger">*</span></label>
                    <div class="d-flex gap-2 flex-wrap" id="modalSizeOptions">
                        <!-- Size options will be inserted here -->
                    </div>
                    <small class="text-danger d-none" id="sizeError">Vui lòng chọn kích thước</small>
                </div>

                <!-- Color Selection -->
                <div class="mb-4" id="modalColorSection" style="display: none;">
                    <label class="fw-bold mb-2 d-block">Màu sắc: <span class="text-danger">*</span></label>
                    <div class="d-flex gap-2 flex-wrap" id="modalColorOptions">
                        <!-- Color options will be inserted here -->
                    </div>
                    <small class="text-danger d-none" id="colorError">Vui lòng chọn màu sắc</small>
                </div>

                <!-- Quantity -->
                <div class="mb-3">
                    <label class="fw-bold mb-2 d-block">Số lượng:</label>
                    <div class="input-group" style="width: 140px;">
                        <button class="btn btn-outline-secondary" type="button" id="modalQtyMinus">-</button>
                        <input type="number" class="form-control text-center" value="1" min="1" id="modalQtyInput">
                        <button class="btn btn-outline-secondary" type="button" id="modalQtyPlus">+</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary px-4" id="modalAddToCartBtn">
                    <i class="fas fa-shopping-cart me-2"></i> Thêm vào giỏ hàng
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Modal Styles */
#quickAddModal .modal-content {
    border-radius: 15px;
    border: none;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

#quickAddModal .modal-header {
    padding: 1.5rem 1.5rem 0.5rem;
}

#quickAddModal .modal-body {
    padding: 1rem 1.5rem;
}

#quickAddModal .modal-footer {
    padding: 0.5rem 1.5rem 1.5rem;
}

/* Size Options */
.modal-size-option {
    display: none;
}

.modal-size-label {
    padding: 0.5rem 1rem;
    border: 2px solid #dee2e6;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
    background: white;
    font-weight: 500;
}

.modal-size-option:checked + .modal-size-label {
    border-color: var(--primary);
    background: var(--primary);
    color: white;
}

.modal-size-label:hover {
    border-color: var(--primary);
}

/* Color Options */
.modal-color-option {
    display: none;
}

.modal-color-label {
    width: 40px;
    height: 40px;
    border: 3px solid #dee2e6;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3px;
}

.modal-color-option:checked + .modal-color-label {
    border-color: var(--primary);
    box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.3);
}

.modal-color-label:hover {
    transform: scale(1.1);
}

.modal-color-swatch {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    display: block !important;
}

/* Force background color to be applied */
#quickAddModal .modal-color-swatch {
    background-color: inherit;
}

#quickAddModal .modal-color-label .modal-color-swatch[style*="background-color"] {
    /* Ensure inline styles are not overridden */
    background: var(--swatch-bg) !important;
}
</style>

<script>
// Quick Add Modal Logic
(function() {
    let currentProductData = null;

    // Quantity controls
    document.getElementById('modalQtyMinus')?.addEventListener('click', function() {
        const input = document.getElementById('modalQtyInput');
        let val = parseInt(input.value) || 1;
        if (val > 1) input.value = val - 1;
    });

    document.getElementById('modalQtyPlus')?.addEventListener('click', function() {
        const input = document.getElementById('modalQtyInput');
        let val = parseInt(input.value) || 1;
        input.value = val + 1;
    });

    // Open modal function
    window.openQuickAddModal = function(productData) {
        currentProductData = productData;
        
        // Set product info
        document.getElementById('modalProductImage').src = productData.image;
        document.getElementById('modalProductName').textContent = productData.name;
        document.getElementById('modalProductPrice').textContent = productData.price;
        
        // Reset quantity
        document.getElementById('modalQtyInput').value = 1;
        
        // Setup sizes
        const sizeSection = document.getElementById('modalSizeSection');
        const sizeOptions = document.getElementById('modalSizeOptions');
        if (productData.sizes && productData.sizes.length > 0) {
            sizeSection.style.display = 'block';
            sizeOptions.innerHTML = '';
            productData.sizes.forEach((size, index) => {
                const sizeHtml = `
                    <input type="radio" class="modal-size-option" name="modal-size" id="modal-size-${index}" value="${size}">
                    <label class="modal-size-label" for="modal-size-${index}">${size}</label>
                `;
                sizeOptions.innerHTML += sizeHtml;
            });
        } else {
            sizeSection.style.display = 'none';
        }
        
        // Setup colors
        const colorSection = document.getElementById('modalColorSection');
        const colorOptions = document.getElementById('modalColorOptions');
        console.log('Product colors:', productData.colors); // Debug
        if (productData.colors && productData.colors.length > 0) {
            colorSection.style.display = 'block';
            colorOptions.innerHTML = '';
            productData.colors.forEach((color, index) => {
                console.log('Color item:', color); // Debug
                // Handle both object {hex, name} and string formats
                const colorHex = typeof color === 'string' ? color : (color.hex || '#000');
                const colorName = typeof color === 'string' ? color : (color.name || color.hex || 'Color');
                
                // Validate hex color (must start with # and be 4 or 7 characters)
                // REMOVED VALIDATION to allow names like 'red', 'blue' or Vietnamese names
                
                // Color mapping for Vietnamese names
                const colorMap = {
                    'nâu': '#8B4513',
                    'đỏ': '#DC143C',
                    'vàng': '#FFD700',
                    'vàng gold': '#FFD700',
                    'xanh': '#0000FF',
                    'xanh dương': '#0000FF', 
                    'xanh lá': '#008000',
                    'đen': '#000000',
                    'trắng': '#FFFFFF',
                    'tím': '#800080',
                    'hồng': '#FFC0CB',
                    'cam': '#FFA500',
                    'xám': '#808080',
                    'ghi': '#808080',
                    'kem': '#FFFDD0'
                };

                let displayColor = colorHex;
                // Try to find mapped color if it's a name
                if (!colorHex.startsWith('#') && !colorHex.startsWith('rgb')) {
                    const lowerName = colorHex.toLowerCase().trim();
                    if (colorMap[lowerName]) {
                        displayColor = colorMap[lowerName];
                    }
                }
                
                // Create elements programmatically to avoid escaping issues
                const input = document.createElement('input');
                input.type = 'radio';
                input.className = 'modal-color-option';
                input.name = 'modal-color';
                input.id = `modal-color-${index}`;
                // USE NAME for value to match with price data correctly (e.g. "Vàng gold")
                input.value = colorName; 
                input.dataset.hex = colorHex; // Store hex for reference if needed
                
                const label = document.createElement('label');
                label.className = 'modal-color-label';
                label.htmlFor = `modal-color-${index}`;
                label.title = colorName;
                
                const swatch = document.createElement('span');
                swatch.className = 'modal-color-swatch';
                // Use cssText to ensure background-color is applied
                swatch.style.cssText = `background-color: ${displayColor} !important; width: 100%; height: 100%; border-radius: 50%; display: block;`;
                
                label.appendChild(swatch);
                colorOptions.appendChild(input);
                colorOptions.appendChild(label);
            });
        } else {
            colorSection.style.display = 'none';
        }
        
        // Hide errors
        document.getElementById('sizeError').classList.add('d-none');
        document.getElementById('colorError').classList.add('d-none');
        
        // Add event listeners for price update
        document.querySelectorAll('input[name="modal-size"], input[name="modal-color"]').forEach(input => {
            input.addEventListener('change', updateModalPrice);
        });
        
        // Initial price update
        updateModalPrice();

        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('quickAddModal'));
        modal.show();
    };

    // Hàm tính toán giá tự động (Auto Calculate Price)
    // Logic: CỘNG DỒN giá = Giá gốc + Giá phụ thu size + Giá phụ thu màu
    function updateModalPrice() {
        if (!currentProductData) return;

        // 1. Lấy giá gốc (ưu tiên rawPrice, nếu không có thì parse từ chuỗi)
        let basePrice = parseFloat(currentProductData.rawPrice);
        if (isNaN(basePrice)) {
            // Fallback: parse từ chuỗi giá hiển thị (vd: "552.500đ")
            basePrice = parseFloat(currentProductData.price.replace(/[^\d]/g, '')) || 0;
        }

        // 2. Lấy lựa chọn hiện tại của khách
        const selectedSizeInput = document.querySelector('input[name="modal-size"]:checked');
        const selectedColorInput = document.querySelector('input[name="modal-color"]:checked');
        
        console.log('=== updateModalPrice Debug ===');
        console.log('Base price:', basePrice);
        console.log('Selected size:', selectedSizeInput?.value);
        console.log('Selected color:', selectedColorInput?.value);

        // Helper: Convert to array if needed
        const toArray = (data) => {
            if (Array.isArray(data)) return data;
            if (typeof data === 'object' && data !== null) {
                return Object.entries(data).map(([key, val]) => ({...val, name: key, size: key}));
            }
            return [];
        };
        
        const sizePricesArr = toArray(currentProductData.sizePrices);
        const colorPricesArr = toArray(currentProductData.colorPrices);
        
        // Bắt đầu với giá gốc
        let finalPrice = basePrice;
        let sizeExtra = 0;
        let colorExtra = 0;

        // --- CỘNG THÊM giá SIZE ---
        if (selectedSizeInput && sizePricesArr.length > 0) {
            const selectedVal = selectedSizeInput.value.toString().trim().toLowerCase();

            const sizeData = sizePricesArr.find(s => {
                const sSize = (s.size || s.name || '').toString().trim().toLowerCase();
                return sSize === selectedVal;
            });

            console.log('Size lookup:', selectedVal, '=> Found:', sizeData);

            if (sizeData && sizeData.price) {
                sizeExtra = parseFloat(sizeData.price) || 0;
                console.log('Size extra price:', sizeExtra);
            }
        }

        // --- CỘNG THÊM giá MÀU SẮC ---
        if (selectedColorInput && colorPricesArr.length > 0) {
            const selectedVal = selectedColorInput.value.toString().trim().toLowerCase();

            const colorData = colorPricesArr.find(c => {
                const cName = (c.name || '').toString().trim().toLowerCase();
                const cHex = (c.hex || '').toString().trim().toLowerCase();
                return cName === selectedVal || cHex === selectedVal;
            });

            console.log('Color lookup:', selectedVal, '=> Found:', colorData);

            if (colorData && colorData.price) {
                colorExtra = parseFloat(colorData.price) || 0;
                console.log('Color extra price:', colorExtra);
            }
        }

        // 3. CỘNG DỒN: Giá gốc + Phụ thu size + Phụ thu màu
        finalPrice = basePrice + sizeExtra + colorExtra;
        
        console.log('=== FINAL CALCULATION ===');
        console.log('Base:', basePrice, '+ Size:', sizeExtra, '+ Color:', colorExtra, '= Total:', finalPrice);

        // 4. Cập nhật hiển thị (Format tiền Việt: 100.000đ)
        const formatted = new Intl.NumberFormat('vi-VN').format(finalPrice) + 'đ';
        document.getElementById('modalProductPrice').textContent = formatted;
        
        // 5. Lưu giá hiện tại để gửi lên server khi thêm vào giỏ hàng
        currentProductData.calculatedPrice = finalPrice;
    }

    // Add to cart from modal
    document.getElementById('modalAddToCartBtn')?.addEventListener('click', function() {
        if (!currentProductData) return;

        const btn = this;
        const originalText = btn.innerHTML;
        
        // Validate size
        const sizeSection = document.getElementById('modalSizeSection');
        const selectedSize = document.querySelector('input[name="modal-size"]:checked');
        if (sizeSection.style.display !== 'none' && !selectedSize) {
            document.getElementById('sizeError').classList.remove('d-none');
            return;
        } else {
            document.getElementById('sizeError').classList.add('d-none');
        }
        
        // Validate color
        const colorSection = document.getElementById('modalColorSection');
        const selectedColor = document.querySelector('input[name="modal-color"]:checked');
        if (colorSection.style.display !== 'none' && !selectedColor) {
            document.getElementById('colorError').classList.remove('d-none');
            return;
        } else {
            document.getElementById('colorError').classList.add('d-none');
        }
        
        const quantity = parseInt(document.getElementById('modalQtyInput').value) || 1;
        const size = selectedSize ? selectedSize.value : 'Standard';
        const color = selectedColor ? selectedColor.value : 'Standard';
        
        // Loading state
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang thêm...';
        btn.disabled = true;
        
        // Add to cart
        fetch('{{ route('cart.add') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                id: currentProductData.id,
                quantity: quantity,
                size: size,
                color: color,
                calculated_price: currentProductData.calculatedPrice || null
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            // Success
            btn.innerHTML = '<i class="fas fa-check"></i> Đã thêm!';
            
            // Update cart badge
            if (data.cart_count !== undefined && typeof updateCartBadge === 'function') {
                updateCartBadge(data.cart_count);
            }
            
            // Show toast
            if (typeof showToast === 'function') {
                showToast(data.success || 'Đã thêm sản phẩm vào giỏ hàng!', 'success');
            }
            
            // Close modal after delay
            setTimeout(() => {
                bootstrap.Modal.getInstance(document.getElementById('quickAddModal')).hide();
                btn.innerHTML = originalText;
                btn.disabled = false;
            }, 1000);
        })
        .catch(error => {
            console.error('Error:', error);
            btn.innerHTML = originalText;
            btn.disabled = false;
            const msg = error.error || error.message || 'Có lỗi xảy ra, vui lòng thử lại.';
            if (typeof showToast === 'function') {
                showToast(msg, 'danger');
            } else {
                alert(msg);
            }
        });
    });
})();
</script>
