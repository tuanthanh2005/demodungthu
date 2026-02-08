@extends('admin.layouts.admin')

@section('title', 'Sửa sản phẩm')
@section('page-title', 'Sửa sản phẩm: ' . $product->name)

@section('topbar-actions')
    <a href="{{ route('admin.products.index') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Quay lại
    </a>
@endsection

@push('styles')
<style>
    .variant-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        background: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 8px;
    }
    .variant-item .variant-label {
        min-width: 100px;
        font-weight: 600;
        color: #374151;
    }
    .variant-item input {
        flex: 1;
        padding: 8px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        font-size: 14px;
    }
    .variant-item .btn-remove {
        padding: 8px 12px;
        background: #ef4444;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .variant-item .btn-remove:hover {
        background: #dc2626;
    }
    .variant-preview {
        display: inline-block;
        width: 32px;
        height: 32px;
        border-radius: 6px;
        border: 2px solid #e5e7eb;
    }
    .price-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
    }
    .color-item {
        position: relative;
        display: inline-block;
        margin: 4px;
    }
    .color-item .color-preview {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        border: 2px solid #e5e7eb;
        cursor: pointer;
        transition: all 0.2s;
    }
    .color-item .color-preview:hover {
        transform: scale(1.1);
        border-color: #3b82f6;
    }
    .color-item .color-name {
        position: absolute;
        bottom: -20px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 11px;
        color: #6b7280;
        white-space: nowrap;
    }
    .color-item .btn-remove-color {
        position: absolute;
        top: -6px;
        right: -6px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #ef4444;
        color: white;
        border: 2px solid white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        transition: all 0.2s;
    }
    .color-item .btn-remove-color:hover {
        background: #dc2626;
        transform: scale(1.1);
    }
    
    .image-upload-area {
        border: 2px dashed #e5e7eb;
        border-radius: 12px;
        padding: 30px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        background: #f9fafb;
    }
    .image-upload-area:hover {
        border-color: #3b82f6;
        background: #eff6ff;
    }
    .image-preview {
        max-width: 200px;
        max-height: 200px;
        border-radius: 8px;
        margin-top: 12px;
        display: none;
    }
    .image-preview.show {
        display: block;
    }
    
    /* Thumbnail Gallery */
    .thumbnail-item {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
    }
    .thumbnail-item img {
        width: 100%;
        height: 120px;
        object-fit: cover;
    }
    .thumbnail-item .btn-remove-thumb {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: rgba(239, 68, 68, 0.9);
        color: white;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        transition: all 0.2s;
    }
    .thumbnail-item .btn-remove-thumb:hover {
        background: #dc2626;
        transform: scale(1.1);
    }
</style>
@endpush

@section('content')
    <div class="form-card">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- PRODUCT NAME -->
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

            <!-- CATEGORY -->
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

            <!-- DESCRIPTION -->
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
                    <input type="text" 
                           id="regularPriceDisplay"
                           class="form-control price-input" 
                           value="{{ old('regular_price', number_format($product->regular_price, 0, ',', ',')) }}"
                           placeholder="0"
                           oninput="formatCurrency(this, 'regularPrice')"
                           onblur="calculateDiscount()"
                           required>
                    <input type="hidden" name="regular_price" id="regularPrice" value="{{ old('regular_price', $product->regular_price) }}">
                    <div class="form-help">Giá gốc trước khi giảm</div>
                    @error('regular_price')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Giá đã giảm (VNĐ)</label>
                    <input type="text" 
                           id="salePriceDisplay"
                           class="form-control price-input" 
                           value="{{ old('sale_price', $product->sale_price ? number_format($product->sale_price, 0, ',', ',') : '') }}"
                           placeholder="0"
                           oninput="formatCurrency(this, 'salePrice')"
                           onblur="calculateDiscount()">
                    <input type="hidden" name="sale_price" id="salePrice" value="{{ old('sale_price', $product->sale_price) }}">
                    <div class="form-help">Giá sau khi giảm (để trống nếu không giảm giá)</div>
                    @error('sale_price')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- DISCOUNT DISPLAY -->
            <div class="form-group" id="discountDisplay" style="display: none;">
                <div style="padding: 12px; background: #e6f4ea; border-radius: 8px; border-left: 4px solid #34a853;">
                    <strong style="color: #137333;">
                        <i class="fas fa-tag"></i> Giảm giá: <span id="discountPercentage">0</span>%
                    </strong>
                    <span style="color: #5f6368; margin-left: 12px;">
                        Tiết kiệm: <span id="discountAmount">0</span> đ
                    </span>
                </div>
                <input type="hidden" name="discount_percentage" id="discountPercentageInput">
            </div>

            <!-- IMAGE UPLOAD -->
            <div class="form-group">
                <label class="form-label">Hình ảnh sản phẩm</label>
                <div class="image-upload-area" id="imageUploadArea">
                    <i class="fas fa-cloud-upload-alt" style="font-size: 48px; color: #9ca3af; margin-bottom: 12px;"></i>
                    <p style="margin: 0; color: #6b7280;">Kéo thả ảnh vào đây hoặc click để chọn</p>
                    <p style="margin: 8px 0 0 0; font-size: 12px; color: #9ca3af;">Mọi định dạng ảnh, tối đa 10MB</p>
                    <input type="file" 
                           name="image" 
                           id="imageInput" 
                           accept="image/*"
                           style="display: none;">
                </div>
                <img id="imagePreview" class="image-preview {{ $product->image ? 'show' : '' }}" src="{{ $product->image }}" alt="Preview">
                <div class="form-help">Chọn hình ảnh chính cho sản phẩm</div>
                @error('image')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- MULTIPLE THUMBNAIL IMAGES -->
            <div class="form-group">
                <label class="form-label">Ảnh thumbnail (Nhiều ảnh)</label>
                <div class="image-upload-area" id="thumbnailUploadArea">
                    <i class="fas fa-images" style="font-size: 48px; color: #9ca3af; margin-bottom: 12px;"></i>
                    <p style="margin: 0; color: #6b7280;">Kéo thả nhiều ảnh vào đây hoặc click để chọn</p>
                    <p style="margin: 8px 0 0 0; font-size: 12px; color: #9ca3af;">Có thể chọn nhiều ảnh cùng lúc (PNG, JPG, GIF tối đa 5MB/ảnh)</p>
                    <input type="file" 
                           name="thumbnails[]" 
                           id="thumbnailInput" 
                           accept="image/*"
                           multiple
                           style="display: none;">
                </div>
                <div id="thumbnailPreview" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 12px; margin-top: 16px;"></div>
                <div class="form-help">Chọn nhiều ảnh phụ để hiển thị trong gallery sản phẩm</div>
            </div>

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

            <!-- SIZE VARIANTS -->
            <div class="form-group">
                <label class="form-label">Kích thước & Giá theo size</label>
                <div id="sizeVariants">
                    @if(old('size_prices') || (isset($product->size_prices) && count($product->size_prices) > 0))
                        @foreach(old('size_prices', $product->size_prices ?? []) as $index => $sizePrice)
                            <div class="variant-item">
                                <span class="variant-label">Size:</span>
                                <input type="text" name="size_prices[{{ $index }}][size]" value="{{ $sizePrice['size'] ?? '' }}" placeholder="VD: S, M, L, XL" required>
                                <span class="variant-label">Giá:</span>
                                <input type="number" name="size_prices[{{ $index }}][price]" value="{{ $sizePrice['price'] ?? '' }}" placeholder="0" min="0" step="1000">
                                <button type="button" class="btn-remove" onclick="this.parentElement.remove()">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        @endforeach
                    @endif
                </div>
                <button type="button" class="btn btn-secondary" onclick="addSizeVariant()" style="margin-top: 8px;">
                    <i class="fas fa-plus"></i> Thêm size
                </button>
                <div class="form-help">Thêm các kích thước khác nhau với giá riêng (tùy chọn)</div>
            </div>

            <!-- COLOR VARIANTS -->
            <div class="form-group">
                <label class="form-label">Màu sắc</label>
                <div id="colorVariants" style="margin-bottom: 12px;">
                    <!-- Existing colors will be loaded here -->
                </div>
                <button type="button" class="btn btn-secondary" onclick="openColorModal()">
                    <i class="fas fa-palette"></i> Thêm màu
                </button>
                <div class="form-help">Thêm các màu sắc khác nhau cho sản phẩm (tùy chọn)</div>
            </div>

            <!-- SUBMIT BUTTONS -->
            <div class="form-actions" style="display: flex; gap: 12px; margin-top: 32px; padding-top: 24px; border-top: 1px solid #e5e7eb;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Cập nhật sản phẩm
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Hủy
                </a>
            </div>
        </form>
    </div>

    <!-- COLOR PICKER MODAL -->
    <div id="colorModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
        <div style="background: white; border-radius: 16px; padding: 24px; max-width: 500px; width: 90%;">
            <h3 style="margin: 0 0 20px 0; font-size: 20px; font-weight: 700; color: #1f2937;">Thêm màu sắc</h3>
            
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">Tên màu:</label>
                <input type="text" id="customColorName" class="form-control" placeholder="VD: Hồng pastel, Xanh navy...">
            </div>
            
            <div style="margin-bottom: 24px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">Chọn màu:</label>
                <input type="color" id="customColorPicker" style="width: 100%; height: 60px; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer;">
            </div>
            
            <div style="display: flex; gap: 12px;">
                <button type="button" class="btn btn-primary" onclick="addCustomColor()" style="flex: 1;">
                    <i class="fas fa-check"></i> Thêm màu
                </button>
                <button type="button" class="btn btn-secondary" onclick="closeColorModal()">
                    <i class="fas fa-times"></i> Hủy
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Discount calculation
    function calculateDiscount() {
        const regularPrice = parseFloat(document.getElementById('regularPrice').value) || 0;
        const salePrice = parseFloat(document.getElementById('salePrice').value) || 0;
        const discountDisplay = document.getElementById('discountDisplay');
        
        if (salePrice > 0 && salePrice < regularPrice) {
            const discountAmount = regularPrice - salePrice;
            const discountPercentage = Math.round((discountAmount / regularPrice) * 100);
            
            document.getElementById('discountPercentage').textContent = discountPercentage;
            document.getElementById('discountAmount').textContent = discountAmount.toLocaleString('vi-VN');
            document.getElementById('discountPercentageInput').value = discountPercentage;
            
            discountDisplay.style.display = 'block';
        } else {
            discountDisplay.style.display = 'none';
            document.getElementById('discountPercentageInput').value = '';
        }
    }

    // Currency formatting
    function formatCurrency(input, hiddenFieldId) {
        let value = input.value.replace(/[^0-9]/g, '');
        
        if (value) {
            document.getElementById(hiddenFieldId).value = value;
            input.value = parseInt(value).toLocaleString('vi-VN');
        } else {
            document.getElementById(hiddenFieldId).value = '';
            input.value = '';
        }
    }

    // Image upload handling
    const imageUploadArea = document.getElementById('imageUploadArea');
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');

    imageUploadArea.addEventListener('click', () => imageInput.click());

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.classList.add('show');
            }
            reader.readAsDataURL(file);
        }
    });

    // Thumbnail upload handling
    const thumbnailUploadArea = document.getElementById('thumbnailUploadArea');
    const thumbnailInput = document.getElementById('thumbnailInput');
    const thumbnailPreview = document.getElementById('thumbnailPreview');
    let thumbnailFiles = [];

    thumbnailUploadArea.addEventListener('click', () => thumbnailInput.click());

    thumbnailInput.addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        files.forEach(file => {
            if (file.size > 5 * 1024 * 1024) {
                alert(`File ${file.name} quá lớn. Tối đa 5MB.`);
                return;
            }
            
            thumbnailFiles.push(file);
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'thumbnail-item';
                div.innerHTML = `
                    <img src="${e.target.result}" alt="Thumbnail">
                    <button type="button" class="btn-remove-thumb" onclick="removeThumbnail(this, '${file.name}')">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                thumbnailPreview.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    });

    function removeThumbnail(btn, fileName) {
        thumbnailFiles = thumbnailFiles.filter(f => f.name !== fileName);
        btn.closest('.thumbnail-item').remove();
    }

    // Size variants
    let sizeIndex = {{ count(old('size_prices', $product->size_prices ?? [])) }};
    function addSizeVariant() {
        const container = document.getElementById('sizeVariants');
        const div = document.createElement('div');
        div.className = 'variant-item';
        div.innerHTML = `
            <span class="variant-label">Size:</span>
            <input type="text" name="size_prices[${sizeIndex}][size]" placeholder="VD: S, M, L, XL" required>
            <span class="variant-label">Giá:</span>
            <input type="number" name="size_prices[${sizeIndex}][price]" placeholder="0" min="0" step="1000">
            <button type="button" class="btn-remove" onclick="this.parentElement.remove()">
                <i class="fas fa-trash"></i>
            </button>
        `;
        container.appendChild(div);
        sizeIndex++;
    }

    // Color variants
    let colors = @json(old('colors', $product->colors ?? []));
    
    function renderColors() {
        const container = document.getElementById('colorVariants');
        container.innerHTML = '';
        
        colors.forEach((color, index) => {
            const div = document.createElement('div');
            div.className = 'color-item';
            div.innerHTML = `
                <div class="color-preview" style="background: ${color.code};"></div>
                <div class="color-name">${color.name}</div>
                <button type="button" class="btn-remove-color" onclick="removeColor(${index})">
                    <i class="fas fa-times"></i>
                </button>
                <input type="hidden" name="colors[${index}][name]" value="${color.name}">
                <input type="hidden" name="colors[${index}][code]" value="${color.code}">
            `;
            container.appendChild(div);
        });
    }

    function openColorModal() {
        document.getElementById('colorModal').style.display = 'flex';
        document.getElementById('customColorName').value = '';
        document.getElementById('customColorPicker').value = '#000000';
    }

    function closeColorModal() {
        document.getElementById('colorModal').style.display = 'none';
    }

    function addCustomColor() {
        const name = document.getElementById('customColorName').value.trim();
        const code = document.getElementById('customColorPicker').value;
        
        if (!name) {
            alert('Vui lòng nhập tên màu');
            return;
        }
        
        colors.push({ name, code });
        renderColors();
        closeColorModal();
    }

    function removeColor(index) {
        colors.splice(index, 1);
        renderColors();
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        renderColors();
        calculateDiscount();
    });
</script>
@endpush
