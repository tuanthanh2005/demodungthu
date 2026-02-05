// Quản lý variants trong admin panel

class VariantAdmin {
    constructor(productId) {
        this.productId = productId;
        this.variants = [];
        this.currentEditId = null;
    }

    // Lấy danh sách variants
    async loadVariants() {
        try {
            const response = await fetch(`/api/products/${this.productId}/variants`);
            this.variants = await response.json();
            this.renderVariantList();
        } catch (error) {
            console.error('Lỗi khi tải variants:', error);
            alert('Không thể tải danh sách variants');
        }
    }

    // Hiển thị danh sách variants
    renderVariantList() {
        const container = document.getElementById('variant-list');
        if (!container) return;

        if (this.variants.length === 0) {
            container.innerHTML = '<p class="text-gray-500">Chưa có variant nào</p>';
            return;
        }

        container.innerHTML = `
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2 text-left">Size</th>
                        <th class="border p-2 text-left">Màu</th>
                        <th class="border p-2 text-right">Giá</th>
                        <th class="border p-2 text-right">Tồn kho</th>
                        <th class="border p-2 text-left">SKU</th>
                        <th class="border p-2 text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    ${this.variants.map(variant => `
                        <tr>
                            <td class="border p-2">${variant.size || '-'}</td>
                            <td class="border p-2">${variant.color || '-'}</td>
                            <td class="border p-2 text-right">${this.formatPrice(variant.price)}</td>
                            <td class="border p-2 text-right">${variant.stock}</td>
                            <td class="border p-2">${variant.sku || '-'}</td>
                            <td class="border p-2 text-center">
                                <button onclick="variantAdmin.editVariant(${variant.id})" 
                                    class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 mr-1">
                                    Sửa
                                </button>
                                <button onclick="variantAdmin.deleteVariant(${variant.id})" 
                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                    Xóa
                                </button>
                            </td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        `;
    }

    // Mở form thêm/sửa variant
    openVariantForm(variantId = null) {
        this.currentEditId = variantId;
        const modal = document.getElementById('variant-modal');
        const form = document.getElementById('variant-form');
        const title = document.getElementById('variant-modal-title');

        if (variantId) {
            // Sửa variant
            const variant = this.variants.find(v => v.id === variantId);
            title.textContent = 'Sửa Variant';
            form.size.value = variant.size || '';
            form.color.value = variant.color || '';
            form.price.value = variant.price;
            form.stock.value = variant.stock;
            form.sku.value = variant.sku || '';
        } else {
            // Thêm mới
            title.textContent = 'Thêm Variant Mới';
            form.reset();
        }

        modal.classList.remove('hidden');
    }

    // Đóng form
    closeVariantForm() {
        document.getElementById('variant-modal').classList.add('hidden');
        this.currentEditId = null;
    }

    // Lưu variant
    async saveVariant(event) {
        event.preventDefault();
        const form = event.target;
        const formData = {
            product_id: this.productId,
            size: form.size.value || null,
            color: form.color.value || null,
            price: parseFloat(form.price.value),
            stock: parseInt(form.stock.value),
            sku: form.sku.value || null
        };

        try {
            let response;
            if (this.currentEditId) {
                // Cập nhật
                response = await fetch(`/api/products/variants/${this.currentEditId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(formData)
                });
            } else {
                // Tạo mới
                response = await fetch('/api/products/variants', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(formData)
                });
            }

            if (response.ok) {
                alert('Lưu variant thành công!');
                this.closeVariantForm();
                this.loadVariants();
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
    editVariant(variantId) {
        this.openVariantForm(variantId);
    }

    // Xóa variant
    async deleteVariant(variantId) {
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
                this.loadVariants();
            } else {
                alert('Không thể xóa variant');
            }
        } catch (error) {
            console.error('Lỗi khi xóa variant:', error);
            alert('Không thể xóa variant');
        }
    }

    // Tạo nhiều variants cùng lúc
    async bulkCreateVariants() {
        const sizes = document.getElementById('bulk-sizes').value.split(',').map(s => s.trim()).filter(s => s);
        const colors = document.getElementById('bulk-colors').value.split(',').map(c => c.trim()).filter(c => c);
        const basePrice = parseFloat(document.getElementById('bulk-base-price').value);
        const stock = parseInt(document.getElementById('bulk-stock').value);

        if (sizes.length === 0 || colors.length === 0 || isNaN(basePrice) || isNaN(stock)) {
            alert('Vui lòng điền đầy đủ thông tin');
            return;
        }

        const variants = [];
        for (const size of sizes) {
            for (const color of colors) {
                variants.push({
                    size: size,
                    color: color,
                    price: basePrice,
                    stock: stock,
                    sku: `${this.productId}-${size}-${color}`
                });
            }
        }

        try {
            const response = await fetch('/api/products/variants/bulk', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    product_id: this.productId,
                    variants: variants
                })
            });

            if (response.ok) {
                alert(`Đã tạo ${variants.length} variants thành công!`);
                document.getElementById('bulk-modal').classList.add('hidden');
                this.loadVariants();
            } else {
                const error = await response.json();
                alert('Lỗi: ' + JSON.stringify(error));
            }
        } catch (error) {
            console.error('Lỗi khi tạo variants:', error);
            alert('Không thể tạo variants');
        }
    }

    // Format giá tiền
    formatPrice(price) {
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(price);
    }
}

// Khởi tạo khi trang load
let variantAdmin;

function initVariantAdmin(productId) {
    variantAdmin = new VariantAdmin(productId);
    variantAdmin.loadVariants();
}
