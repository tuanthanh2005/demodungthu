// Product Variant Selector
function renderVariantSelectors(product) {
    if (!product.variants || product.variants.length === 0) {
        return '';
    }

    // Get unique sizes and colors
    const sizes = [...new Set(product.variants.map(v => v.size).filter(Boolean))];
    const colors = [...new Set(product.variants.map(v => v.color).filter(Boolean))];

    let html = '<div class="variant-selectors" style="margin: 20px 0;">';

    // Size selector
    if (sizes.length > 0) {
        html += `
            <div class="variant-group" style="margin-bottom: 16px;">
                <label style="display: block; font-weight: 700; margin-bottom: 8px;">
                    ${product.category?.name?.includes('Thời trang') ? 'Kích thước:' : 'Dung lượng:'}
                </label>
                <div class="size-options" style="display: flex; gap: 8px; flex-wrap: wrap;">
                    ${sizes.map(size => `
                        <button class="size-btn" data-size="${size}" 
                            style="padding: 10px 16px; border: 2px solid #e5e7eb; border-radius: 8px; 
                            background: white; cursor: pointer; font-weight: 600; transition: all 0.2s;">
                            ${size}
                        </button>
                    `).join('')}
                </div>
            </div>
        `;
    }

    // Color selector
    if (colors.length > 0) {
        html += `
            <div class="variant-group" style="margin-bottom: 16px;">
                <label style="display: block; font-weight: 700; margin-bottom: 8px;">Màu sắc:</label>
                <div class="color-options" style="display: flex; gap: 8px; flex-wrap: wrap;">
                    ${colors.map(color => `
                        <button class="color-btn" data-color="${color}"
                            style="padding: 10px 16px; border: 2px solid #e5e7eb; border-radius: 8px; 
                            background: white; cursor: pointer; font-weight: 600; transition: all 0.2s;">
                            ${color}
                        </button>
                    `).join('')}
                </div>
            </div>
        `;
    }

    html += '<div class="variant-price" style="font-size: 1.8rem; font-weight: 800; color: var(--primary); margin: 12px 0;"></div>';
    html += '<div class="variant-stock" style="color: var(--muted); font-size: 0.9rem;"></div>';
    html += '</div>';

    return html;
}

function setupVariantHandlers(product) {
    if (!product.variants || product.variants.length === 0) {
        window.selectedVariant = null;
        return;
    }

    let selectedSize = null;
    let selectedColor = null;

    const sizeBtns = document.querySelectorAll('.size-btn');
    const colorBtns = document.querySelectorAll('.color-btn');

    // Size button handlers
    sizeBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            selectedSize = btn.getAttribute('data-size');
            sizeBtns.forEach(b => {
                b.style.borderColor = '#e5e7eb';
                b.style.background = 'white';
                b.style.color = 'var(--text)';
            });
            btn.style.borderColor = 'var(--primary)';
            btn.style.background = 'var(--primary)';
            btn.style.color = 'white';
            updateSelectedVariant();
        });
    });

    // Color button handlers
    colorBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            selectedColor = btn.getAttribute('data-color');
            colorBtns.forEach(b => {
                b.style.borderColor = '#e5e7eb';
                b.style.background = 'white';
                b.style.color = 'var(--text)';
            });
            btn.style.borderColor = 'var(--primary)';
            btn.style.background = 'var(--primary)';
            btn.style.color = 'white';
            updateSelectedVariant();
        });
    });

    function updateSelectedVariant() {
        // Find matching variant
        const variant = product.variants.find(v => {
            const sizeMatch = !selectedSize || v.size === selectedSize;
            const colorMatch = !selectedColor || v.color === selectedColor;
            return sizeMatch && colorMatch;
        });

        if (variant) {
            window.selectedVariant = variant;
            document.querySelector('.variant-price').textContent = formatPrice(variant.price);
            document.querySelector('.variant-stock').textContent =
                variant.stock > 0 ? `Còn ${variant.stock} sản phẩm` : '❌ Hết hàng';

            // Update main price display
            const mainPrice = document.querySelector('.price');
            if (mainPrice) {
                mainPrice.textContent = formatPrice(variant.price);
            }
        } else {
            window.selectedVariant = null;
        }
    }

    // Auto-select first variant
    if (sizeBtns.length > 0) sizeBtns[0].click();
    if (colorBtns.length > 0) colorBtns[0].click();
}
