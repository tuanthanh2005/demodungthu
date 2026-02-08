@extends('admin.layouts.admin')

@section('title', 'Thêm danh mục mới')
@section('page-title', 'Thêm danh mục mới')

@section('topbar-actions')
    <a href="{{ route('admin.categories.index') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Quay lại</a>
@endsection

@section('content')
<div class="form-container">
    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="name">Tên danh mục <span class="required">*</span></label>
            <input type="text" id="name" name="name" class="form-input @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Nhập tên danh mục">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea id="description" name="description" class="form-input" rows="4" placeholder="Mô tả danh mục">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="icon">Icon Danh mục</label>
            <div class="image-upload-wrapper">
                <div class="image-preview" id="iconPreview" onclick="document.getElementById('icon').click()">
                    <i class="fas fa-image"></i>
                    <span>Tải ảnh lên</span>
                </div>
                <input type="file" id="icon" name="icon" class="image-input" accept="image/*" onchange="previewImage(this, 'iconPreview')" style="display: none;">
            </div>
            @error('icon')
                <div class="text-error mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Hủy bỏ</a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Lưu danh mục
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const preview = document.getElementById(previewId);
                preview.innerHTML = `<img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">`;
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<style>
    .form-container {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        max-width: 800px;
        margin: 0 auto;
    }
    
    .form-group {
        margin-bottom: 24px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #374151;
        font-size: 0.95rem;
    }
    
    .required {
        color: #ef4444;
    }
    
    .form-input {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: border-color 0.15s, box-shadow 0.15s;
        box-sizing: border-box; /* Ensure padding doesn't affect width */
    }
    
    .form-input:focus {
        border-color: #3b82f6;
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .image-upload-wrapper {
        width: 150px;
        height: 150px;
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        position: relative;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.2s;
        background: #f9fafb;
    }
    
    .image-upload-wrapper:hover {
        border-color: #3b82f6;
        background: #eff6ff;
    }
    
    .image-preview {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #6b7280;
    }
    
    .image-preview i {
        font-size: 2rem;
        margin-bottom: 8px;
    }

    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .form-actions {
        margin-top: 32px;
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        border-top: 1px solid #e5e7eb;
        padding-top: 24px;
    }
    
    .btn-secondary {
        background: white;
        color: #374151;
        border: 1px solid #d1d5db;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .btn-secondary:hover {
        background: #f3f4f6;
        border-color: #9ca3af;
    }
    
    .btn-primary {
        background: #3b82f6;
        color: white;
        border: 1px solid transparent;
        padding: 8px 20px;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-primary:hover {
        background: #2563eb;
    }

    .is-invalid {
        border-color: #ef4444;
    }

    .invalid-feedback, .text-error {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 4px;
    }
</style>
@endpush
