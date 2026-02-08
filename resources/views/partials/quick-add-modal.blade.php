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
                
                // Create elements programmatically to avoid escaping issues
                const input = document.createElement('input');
                input.type = 'radio';
                input.className = 'modal-color-option';
                input.name = 'modal-color';
                input.id = `modal-color-${index}`;
                input.value = colorHex;
                
                const label = document.createElement('label');
                label.className = 'modal-color-label';
                label.htmlFor = `modal-color-${index}`;
                label.title = colorName;
                
                const swatch = document.createElement('span');
                swatch.className = 'modal-color-swatch';
                // Use cssText to ensure background-color is applied
                swatch.style.cssText = `background-color: ${colorHex} !important; width: 100%; height: 100%; border-radius: 50%; display: block;`;
                
                console.log('Created swatch with color:', colorHex, 'Element:', swatch); // Debug
                
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
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('quickAddModal'));
        modal.show();
    };

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
                color: color
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
