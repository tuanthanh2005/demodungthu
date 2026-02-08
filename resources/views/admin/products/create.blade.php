@extends('admin.layouts.admin')

@section('title', 'Thêm sản phẩm mới')
@section('page-title', 'Thêm sản phẩm mới')

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
        border: 2px solid #fff;
        box-shadow: 0 0 0 1px #e5e7eb;
    }
    .input-group {
        display: flex;
        gap: 12px;
        align-items: center;
        margin-bottom: 12px;
    }
    .input-group select,
    .input-group input[type="text"] {
        flex: 2;
        padding: 10px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        font-size: 14px;
    }
    
    /* Color Palette */
    .color-palette {
        display: grid;
        grid-template-columns: repeat(10, 1fr);
        gap: 8px;
        padding: 12px;
        background: #f9fafb;
        border-radius: 8px;
        margin-bottom: 12px;
    }
    .color-option {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        cursor: pointer;
        border: 3px solid transparent;
        transition: all 0.2s;
        position: relative;
    }
    .color-option:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .color-option.selected {
        border-color: #4285f4;
        box-shadow: 0 0 0 2px #fff, 0 0 0 4px #4285f4;
    }
    .color-option.selected::after {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-weight: bold;
        font-size: 18px;
        text-shadow: 0 0 3px rgba(0,0,0,0.5);
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
        border-color: #4285f4;
        background: #f0f7ff;
    }
    .image-upload-area.dragover {
        border-color: #4285f4;
        background: #e3f2fd;
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
        border: 2px solid #e5e7eb;
        aspect-ratio: 1;
    }
    .thumbnail-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .thumbnail-item .remove-thumbnail {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 28px;
        height: 28px;
        background: #ef4444;
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        transition: all 0.2s;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
    .thumbnail-item .remove-thumbnail:hover {
        background: #dc2626;
        transform: scale(1.1);
    }
</style>
@endpush

@section('content')
    <div class="form-card">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label class="form-label required">Tên sản phẩm</label>
                <input type="text" 
                       name="name" 
                       class="form-control" 
                       value="{{ old('name') }}"
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
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                          required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- PRICE FIELDS -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label class="form-label required">Giá tiêu chuẩn (VNĐ)</label>
                    <input type="text" 
                           id="regularPriceDisplay"
                           class="form-control price-input" 
                           value="{{ old('regular_price') }}"
                           placeholder="0"
                           oninput="formatCurrency(this, 'regularPrice')"
                           onblur="calculateDiscount()"
                           required>
                    <input type="hidden" name="regular_price" id="regularPrice">
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
                           value="{{ old('sale_price') }}"
                           placeholder="0"
                           oninput="formatCurrency(this, 'salePrice')"
                           onblur="calculateDiscount()">
                    <input type="hidden" name="sale_price" id="salePrice">
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
                <img id="imagePreview" class="image-preview" alt="Preview">
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
                    <p style="margin: 8px 0 0 0; font-size: 12px; color: #9ca3af;">Có thể chọn nhiều ảnh cùng lúc (Mọi định dạng, tối đa 10MB/ảnh)</p>
                    <input type="file" 
                           name="thumbnails[]" 
                           id="thumbnailInput" 
                           accept="image/*"
                           multiple
                           style="display: none;">
                </div>
                <div id="thumbnailPreviewGallery" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 12px; margin-top: 16px;"></div>
                <div class="form-help">Chọn nhiều ảnh để hiển thị trong gallery sản phẩm</div>
                @error('thumbnails')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- SIZE VARIANTS -->
            <div class="form-group">
                <label class="form-label">Kích thước (Size) với giá riêng</label>
                <div class="input-group">
                    <select class="form-control" id="sizeSelect">
                        <option value="">-- Chọn size --</option>
                        <option value="XS">XS - Extra Small</option>
                        <option value="S">S - Small</option>
                        <option value="M">M - Medium</option>
                        <option value="L">L - Large</option>
                        <option value="XL">XL - Extra Large</option>
                        <option value="XXL">XXL - Double XL</option>
                        <option value="XXXL">XXXL - Triple XL</option>
                        <option value="FREE">FREE SIZE - Freesize</option>
                    </select>
                    <button type="button" class="btn btn-primary" onclick="addSizeFromSelect()">
                        <i class="fas fa-plus"></i> Thêm
                    </button>
                </div>
                <div id="sizeVariants"></div>
                <div class="form-help">Chọn size và nhấn "Thêm". Mỗi size có thể có giá và số lượng riêng.</div>
            </div>

            <!-- COLOR VARIANTS -->
            <div class="form-group">
                <label class="form-label">Màu sắc với giá riêng</label>
                
                <!-- Color Palette -->
                <div class="color-palette" id="colorPalette">
                    <div class="color-option" data-color="#000000" data-name="Đen" style="background: #000000;" title="Đen"></div>
                    <div class="color-option" data-color="#FFFFFF" data-name="Trắng" style="background: #FFFFFF; border: 1px solid #e5e7eb;" title="Trắng"></div>
                    <div class="color-option" data-color="#FF0000" data-name="Đỏ" style="background: #FF0000;" title="Đỏ"></div>
                    <div class="color-option" data-color="#00FF00" data-name="Xanh lá" style="background: #00FF00;" title="Xanh lá"></div>
                    <div class="color-option" data-color="#0000FF" data-name="Xanh dương" style="background: #0000FF;" title="Xanh dương"></div>
                    <div class="color-option" data-color="#FFFF00" data-name="Vàng" style="background: #FFFF00;" title="Vàng"></div>
                    <div class="color-option" data-color="#FF00FF" data-name="Hồng" style="background: #FF00FF;" title="Hồng"></div>
                    <div class="color-option" data-color="#00FFFF" data-name="Xanh ngọc" style="background: #00FFFF;" title="Xanh ngọc"></div>
                    <div class="color-option" data-color="#FFA500" data-name="Cam" style="background: #FFA500;" title="Cam"></div>
                    <div class="color-option" data-color="#800080" data-name="Tím" style="background: #800080;" title="Tím"></div>
                    
                    <div class="color-option" data-color="#808080" data-name="Xám" style="background: #808080;" title="Xám"></div>
                    <div class="color-option" data-color="#C0C0C0" data-name="Bạc" style="background: #C0C0C0;" title="Bạc"></div>
                    <div class="color-option" data-color="#8B4513" data-name="Nâu" style="background: #8B4513;" title="Nâu"></div>
                    <div class="color-option" data-color="#FFD700" data-name="Vàng gold" style="background: #FFD700;" title="Vàng gold"></div>
                    <div class="color-option" data-color="#4169E1" data-name="Xanh royal" style="background: #4169E1;" title="Xanh royal"></div>
                    <div class="color-option" data-color="#32CD32" data-name="Xanh lime" style="background: #32CD32;" title="Xanh lime"></div>
                    <div class="color-option" data-color="#FF1493" data-name="Hồng đậm" style="background: #FF1493;" title="Hồng đậm"></div>
                    <div class="color-option" data-color="#00CED1" data-name="Xanh ngọc đậm" style="background: #00CED1;" title="Xanh ngọc đậm"></div>
                    <div class="color-option" data-color="#FF6347" data-name="Đỏ cà chua" style="background: #FF6347;" title="Đỏ cà chua"></div>
                    <div class="color-option" data-color="#9370DB" data-name="Tím nhạt" style="background: #9370DB;" title="Tím nhạt"></div>
                    
                    <!-- Custom Color Button -->
                    <div class="color-option" onclick="showCustomColorModal()" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 20px; color: white; font-weight: bold;" title="Màu khác">
                        +
                    </div>
                </div>
                
                <div class="input-group">
                    <input type="text" 
                           class="form-control" 
                           id="colorNameInput"
                           placeholder="Tên màu sẽ tự động điền khi chọn màu..."
                           readonly>
                    <input type="hidden" id="selectedColorHex">
                    <button type="button" class="btn btn-primary" onclick="addColorFromPalette()" id="addColorBtn" disabled>
                        <i class="fas fa-plus"></i> Thêm
                    </button>
                </div>
                <div id="colorVariants"></div>
                <div class="form-help">Click vào màu bên trên để chọn, sau đó nhấn "Thêm". Hoặc click nút "+" để thêm màu tùy chỉnh.</div>
            </div>

            <!-- Custom Color Modal -->
            <div id="customColorModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
                <div style="background: white; padding: 30px; border-radius: 12px; max-width: 400px; width: 90%;">
                    <h3 style="margin: 0 0 20px 0; color: #374151;">Thêm màu tùy chỉnh</h3>
                    
                    <div style="margin-bottom: 16px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">Tên màu:</label>
                        <input type="text" id="customColorName" class="form-control" placeholder="VD: Hồng pastel, Xanh navy...">
                    </div>
                    
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">Chọn màu:</label>
                        <input type="color" id="customColorPicker" value="#FF69B4" style="width: 100%; height: 60px; border: 1px solid #e5e7eb; border-radius: 8px; cursor: pointer;">
                    </div>
                    
                    <div style="display: flex; gap: 12px;">
                        <button type="button" class="btn btn-primary" onclick="addCustomColor()" style="flex: 1;">
                            <i class="fas fa-check"></i> Xác nhận
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="closeCustomColorModal()" style="flex: 1;">
                            <i class="fas fa-times"></i> Hủy
                        </button>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Lưu sản phẩm
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
    // Vietnamese Currency Formatting
    function formatCurrency(input, hiddenInputId) {
        // Get raw value (remove all non-digits)
        let value = input.value.replace(/\D/g, '');
        
        // Update hidden input with raw number
        document.getElementById(hiddenInputId).value = value;
        
        // Format with thousand separators
        if (value) {
            input.value = parseInt(value).toLocaleString('vi-VN');
        } else {
            input.value = '';
        }
    }

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
            };
            reader.readAsDataURL(file);
        }
    });

    // Drag and drop
    imageUploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        imageUploadArea.classList.add('dragover');
    });

    imageUploadArea.addEventListener('dragleave', () => {
        imageUploadArea.classList.remove('dragover');
    });

    imageUploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        imageUploadArea.classList.remove('dragover');
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            imageInput.files = e.dataTransfer.files;
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.classList.add('show');
            };
            reader.readAsDataURL(file);
        }
    });

    // Thumbnail images handling
    const thumbnailUploadArea = document.getElementById('thumbnailUploadArea');
    const thumbnailInput = document.getElementById('thumbnailInput');
    const thumbnailPreviewGallery = document.getElementById('thumbnailPreviewGallery');
    let thumbnailFiles = [];

    thumbnailUploadArea.addEventListener('click', () => thumbnailInput.click());

    thumbnailInput.addEventListener('change', function(e) {
        handleThumbnailFiles(e.target.files);
    });

    // Drag and drop for thumbnails
    thumbnailUploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        thumbnailUploadArea.classList.add('dragover');
    });

    thumbnailUploadArea.addEventListener('dragleave', () => {
        thumbnailUploadArea.classList.remove('dragover');
    });

    thumbnailUploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        thumbnailUploadArea.classList.remove('dragover');
        handleThumbnailFiles(e.dataTransfer.files);
    });

    function handleThumbnailFiles(files) {
        Array.from(files).forEach(file => {
            if (file.type.startsWith('image/')) {
                thumbnailFiles.push(file);
                displayThumbnail(file, thumbnailFiles.length - 1);
            }
        });
        updateThumbnailInput();
    }

    function displayThumbnail(file, index) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const thumbnailItem = document.createElement('div');
            thumbnailItem.className = 'thumbnail-item';
            thumbnailItem.dataset.index = index;
            thumbnailItem.innerHTML = `
                <img src="${e.target.result}" alt="Thumbnail">
                <button type="button" class="remove-thumbnail" onclick="removeThumbnail(${index})">
                    <i class="fas fa-times"></i>
                </button>
            `;
            thumbnailPreviewGallery.appendChild(thumbnailItem);
        };
        reader.readAsDataURL(file);
    }

    function removeThumbnail(index) {
        thumbnailFiles.splice(index, 1);
        thumbnailPreviewGallery.innerHTML = '';
        thumbnailFiles.forEach((file, idx) => {
            displayThumbnail(file, idx);
        });
        updateThumbnailInput();
    }

    function updateThumbnailInput() {
        const dataTransfer = new DataTransfer();
        thumbnailFiles.forEach(file => {
            dataTransfer.items.add(file);
        });
        thumbnailInput.files = dataTransfer.files;
    }

    // Size variants management
    const sizeVariants = {};
    const sizeSelect = document.getElementById('sizeSelect');
    const sizeVariantsContainer = document.getElementById('sizeVariants');

    function addSizeFromSelect() {
        const size = sizeSelect.value;
        
        if (!size) {
            alert('Vui lòng chọn size!');
            return;
        }
        
        if (sizeVariants[size]) {
            alert('Size này đã tồn tại!');
            return;
        }
        
        addSizeVariant(size);
        sizeSelect.value = '';
    }

    function addSizeVariant(size) {
        sizeVariants[size] = { price: '', quantity: '' };
        
        const variantDiv = document.createElement('div');
        variantDiv.className = 'variant-item';
        variantDiv.dataset.size = size;
        variantDiv.innerHTML = `
            <span class="variant-label">${size}</span>
            <input type="number" 
                   name="size_prices[${size}][price]" 
                   placeholder="Giá (VNĐ)" 
                   min="0" 
                   step="1000"
                   value="">
            <input type="number" 
                   name="size_prices[${size}][quantity]" 
                   placeholder="Số lượng" 
                   min="0"
                   value="">
            <button type="button" class="btn-remove" onclick="removeSizeVariant('${size}')">
                <i class="fas fa-times"></i>
            </button>
        `;
        sizeVariantsContainer.appendChild(variantDiv);
    }

    function removeSizeVariant(size) {
        delete sizeVariants[size];
        const variantDiv = sizeVariantsContainer.querySelector(`[data-size="${size}"]`);
        if (variantDiv) variantDiv.remove();
    }

    // Color palette management
    const colorOptions = document.querySelectorAll('.color-option');
    const colorNameInput = document.getElementById('colorNameInput');
    const selectedColorHex = document.getElementById('selectedColorHex');
    const addColorBtn = document.getElementById('addColorBtn');
    let currentSelectedColor = null;

    colorOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Remove previous selection
            colorOptions.forEach(opt => opt.classList.remove('selected'));
            
            // Add selection to clicked option
            this.classList.add('selected');
            
            // Update inputs
            const colorName = this.dataset.name;
            const colorHex = this.dataset.color;
            
            colorNameInput.value = colorName;
            selectedColorHex.value = colorHex;
            currentSelectedColor = { name: colorName, hex: colorHex };
            
            // Enable add button
            addColorBtn.disabled = false;
        });
    });

    // Color variants management
    const colorVariants = {};
    const colorVariantsContainer = document.getElementById('colorVariants');

    function addColorFromPalette() {
        if (!currentSelectedColor) {
            alert('Vui lòng chọn màu!');
            return;
        }
        
        const colorName = currentSelectedColor.name;
        const colorHex = currentSelectedColor.hex;
        
        if (colorVariants[colorName]) {
            alert('Màu này đã tồn tại!');
            return;
        }
        
        addColorVariant(colorName, colorHex);
        
        // Reset selection
        colorOptions.forEach(opt => opt.classList.remove('selected'));
        colorNameInput.value = '';
        selectedColorHex.value = '';
        currentSelectedColor = null;
        addColorBtn.disabled = true;
    }

    function addColorVariant(colorName, colorHex) {
        colorVariants[colorName] = { hex: colorHex, price: '', quantity: '' };
        
        const variantDiv = document.createElement('div');
        variantDiv.className = 'variant-item';
        variantDiv.dataset.color = colorName;
        variantDiv.innerHTML = `
            <span class="variant-preview" style="background: ${colorHex}"></span>
            <span class="variant-label">${colorName}</span>
            <input type="hidden" name="color_prices[${colorName}][hex]" value="${colorHex}">
            <input type="number" 
                   name="color_prices[${colorName}][price]" 
                   placeholder="Giá (VNĐ)" 
                   min="0" 
                   step="1000"
                   value="">
            <input type="number" 
                   name="color_prices[${colorName}][quantity]" 
                   placeholder="Số lượng" 
                   min="0"
                   value="">
            <button type="button" class="btn-remove" onclick="removeColorVariant('${colorName}')">
                <i class="fas fa-times"></i>
            </button>
        `;
        colorVariantsContainer.appendChild(variantDiv);
    }

    function removeColorVariant(colorName) {
        delete colorVariants[colorName];
        const variantDiv = colorVariantsContainer.querySelector(`[data-color="${colorName}"]`);
        if (variantDiv) variantDiv.remove();
    }

    // Custom Color Modal Functions
    function showCustomColorModal() {
        const modal = document.getElementById('customColorModal');
        modal.style.display = 'flex';
        document.getElementById('customColorName').value = '';
        document.getElementById('customColorPicker').value = '#FF69B4';
    }

    function closeCustomColorModal() {
        const modal = document.getElementById('customColorModal');
        modal.style.display = 'none';
    }

    function addCustomColor() {
        const colorName = document.getElementById('customColorName').value.trim();
        const colorHex = document.getElementById('customColorPicker').value;
        
        if (!colorName) {
            alert('Vui lòng nhập tên màu!');
            return;
        }
        
        if (colorVariants[colorName]) {
            alert('Màu này đã tồn tại!');
            return;
        }
        
        // Add color variant
        addColorVariant(colorName, colorHex);
        
        // Close modal
        closeCustomColorModal();
    }

    // Close modal when clicking outside
    document.getElementById('customColorModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeCustomColorModal();
        }
    });
</script>
@endpush
