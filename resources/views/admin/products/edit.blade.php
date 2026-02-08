@extends('admin.layouts.admin')

@section('title', 'Sửa sản phẩm')
@section('page-title', 'Sửa sản phẩm: ' . $product->name)

@section('topbar-actions')
    <a href="{{ route('admin.products.index') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Quay lại
    </a>
@endsection

@section('content')
    <div class="form-card">
        <form action="{{ route('admin.products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label class="form-label required">Tên sản phẩm</label>
                <input type="text" 
                       name="name" 
                       class="form-control" 
                       value="{{ old('name', $product->name) }}"
                       placeholder="Nhập tên sản phẩm..."
                       required>
                @error('name')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label required">Danh mục</label>
                <select name="category_id" class="form-control" required>
                    <option value="">-- Chọn danh mục --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" 
                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label required">Mô tả</label>
                <textarea name="description" 
                          class="form-control" 
                          placeholder="Nhập mô tả sản phẩm..."
                          required>{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- PRICING SECTION -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label class="form-label required">Giá tiêu chuẩn (VNĐ)</label>
                    <input type="number" 
                           id="regularPriceEdit"
                           name="regular_price" 
                           class="form-control" 
                           value="{{ old('regular_price', $product->regular_price) }}"
                           placeholder="0"
                           min="0"
                           step="1000"
                           required
                           onchange="calculateDiscountEdit()">
                    <div class="form-help">Giá gốc trước khi giảm</div>
                    @error('regular_price')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Giá đã giảm (VNĐ)</label>
                    <input type="number" 
                           id="salePriceEdit"
                           name="sale_price" 
                           class="form-control" 
                           value="{{ old('sale_price', $product->sale_price) }}"
                           placeholder="0"
                           min="0"
                           step="1000"
                           onchange="calculateDiscountEdit()">
                    <div class="form-help">Giá sau khi giảm (để trống nếu không giảm)</div>
                    @error('sale_price')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- DISCOUNT DISPLAY -->
            <div id="discountDisplayEdit" style="display: none; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 12px; padding: 16px; margin-bottom: 24px; color: white;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-tag" style="font-size: 24px;"></i>
                    <div style="flex: 1;">
                        <div style="font-size: 20px; font-weight: 700; margin-bottom: 4px;">
                            🏷️ Giảm giá: <span id="discountPercentageEdit">0</span>%
                        </div>
                        <div style="font-size: 14px; opacity: 0.95;">
                            Tiết kiệm: <span id="discountAmountEdit">0</span> đ
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="discount_percentage" id="discountPercentageInputEdit">

            <!-- QUANTITY -->
            <div class="form-group">
                <label class="form-label required">Số lượng</label>
                <input type="number" 
                       name="quantity" 
                       class="form-control" 
                       value="{{ old('quantity', $product->quantity) }}"
                       placeholder="0"
                       min="0"
                       required>
                @error('quantity')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Hình ảnh (URL)</label>
                <input type="text" 
                       name="image" 
                       class="form-control" 
                       value="{{ old('image', $product->image) }}"
                       placeholder="https://example.com/image.jpg">
                <div class="form-help">Nhập URL hình ảnh sản phẩm</div>
                @error('image')
                    <div class="form-error">{{ $message }}</div>
                @enderror
                @if($product->image)
                    <div style="margin-top: 12px;">
                        <img src="{{ $product->image }}" alt="Preview" style="max-width: 200px; border-radius: 8px; border: 1px solid #e0e0e0;">
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label class="form-label">Kích thước (Size)</label>
                <div class="input-tags" id="sizesContainer">
                    <input type="text" 
                           class="tag-input" 
                           id="sizeInput"
                           placeholder="Nhập size và nhấn Enter (VD: S, M, L, XL)">
                </div>
                <div class="form-help">Nhấn Enter để thêm size mới</div>
            </div>

            <div class="form-group">
                <label class="form-label">Màu sắc</label>
                <div class="input-tags" id="colorsContainer">
                    <input type="text" 
                           class="tag-input" 
                           id="colorInput"
                           placeholder="Nhập mã màu và nhấn Enter (VD: #FF0000, #00FF00)">
                </div>
                <div class="form-help">Nhập mã màu hex (VD: #FF0000 cho màu đỏ) và nhấn Enter</div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Cập nhật sản phẩm
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Hủy
                </a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    // Initialize existing sizes
    const sizes = @json($product->sizes ?? []);
    const sizesContainer = document.getElementById('sizesContainer');
    const sizeInput = document.getElementById('sizeInput');

    // Load existing sizes
    sizes.forEach(size => addSizeTag(size));

    sizeInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const value = this.value.trim().toUpperCase();
            if (value && !sizes.includes(value)) {
                sizes.push(value);
                addSizeTag(value);
                this.value = '';
            }
        }
    });

    function addSizeTag(size) {
        const tag = document.createElement('div');
        tag.className = 'input-tag';
        tag.innerHTML = `
            ${size}
            <button type="button" onclick="removeSize('${size}')">
                <i class="fas fa-times"></i>
            </button>
            <input type="hidden" name="sizes[]" value="${size}">
        `;
        sizesContainer.insertBefore(tag, sizeInput);
    }

    function removeSize(size) {
        const index = sizes.indexOf(size);
        if (index > -1) {
            sizes.splice(index, 1);
        }
        event.target.closest('.input-tag').remove();
    }

    // Initialize existing colors
    const colors = @json($product->colors ?? []);
    const colorsContainer = document.getElementById('colorsContainer');
    const colorInput = document.getElementById('colorInput');

    // Load existing colors
    colors.forEach(color => addColorTag(color));

    colorInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            let value = this.value.trim();
            
            // Add # if not present
            if (value && !value.startsWith('#')) {
                value = '#' + value;
            }
            
            // Validate hex color
            if (value && /^#[0-9A-F]{6}$/i.test(value) && !colors.includes(value)) {
                colors.push(value);
                addColorTag(value);
                this.value = '';
            }
        }
    });

    function addColorTag(color) {
        const tag = document.createElement('div');
        tag.className = 'input-tag';
        tag.innerHTML = `
            <span class="color-dot" style="background: ${color}; width: 16px; height: 16px; display: inline-block; margin-right: 4px;"></span>
            ${color}
            <button type="button" onclick="removeColor('${color}')">
                <i class="fas fa-times"></i>
            </button>
            <input type="hidden" name="colors[]" value="${color}">
        `;
        colorsContainer.insertBefore(tag, colorInput);
    }

    function removeColor(color) {
        const index = colors.indexOf(color);
        if (index > -1) {
            colors.splice(index, 1);
        }
        event.target.closest('.input-tag').remove();
    }

    // Discount calculation for Edit form
    function calculateDiscountEdit() {
        const regularPrice = parseFloat(document.getElementById('regularPriceEdit').value) || 0;
        const salePrice = parseFloat(document.getElementById('salePriceEdit').value) || 0;
        const discountDisplay = document.getElementById('discountDisplayEdit');
        
        if (salePrice > 0 && salePrice < regularPrice) {
            const discountAmount = regularPrice - salePrice;
            const discountPercentage = Math.round((discountAmount / regularPrice) * 100);
            
            document.getElementById('discountPercentageEdit').textContent = discountPercentage;
            document.getElementById('discountAmountEdit').textContent = discountAmount.toLocaleString('vi-VN');
            document.getElementById('discountPercentageInputEdit').value = discountPercentage;
            
            discountDisplay.style.display = 'block';
        } else {
            discountDisplay.style.display = 'none';
            document.getElementById('discountPercentageInputEdit').value = '';
        }
    }

    // Calculate discount on page load
    document.addEventListener('DOMContentLoaded', function() {
        calculateDiscountEdit();
    });
</script>
@endpush
