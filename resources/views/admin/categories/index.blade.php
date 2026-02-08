@extends('admin.layouts.admin')

@section('title', 'Quản lý danh mục')
@section('page-title', 'Quản lý danh mục')

@section('topbar-actions')
    <a href="/" class="btn-back"><i class="fas fa-home"></i> Về trang chủ</a>
@endsection

@section('content')
    <!-- Actions Bar -->
    <div class="actions-bar">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Tìm kiếm danh mục...">
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm danh mục mới
        </a>
    </div>

    <!-- Categories Table -->
    <div class="table-card">
        <table class="products-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Icon</th>
                    <th>Tên danh mục</th>
                    <th>Tổng sản phẩm</th>
                    <th>Ngày tạo</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>#{{ $category->id }}</td>
                        <td>
                            @if($category->icon)
                                <img src="{{ $category->icon }}" alt="{{ $category->name }}" class="product-thumb">
                            @else
                                <span class="text-muted">No Icon</span>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $category->name }}</strong>
                            <div class="text-muted small">{{ Str::limit($category->description, 50) }}</div>
                        </td>
                        <td>
                            <span class="badge badge-info">{{ $category->products_count }} sản phẩm</span>
                        </td>
                        <td>{{ $category->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.categories.edit', $category) }}" 
                                   class="btn-action btn-edit" 
                                   title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" 
                                      method="POST" 
                                      style="display: inline;"
                                      onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này? Lưu ý: Không thể xóa danh mục đang có sản phẩm.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            <div class="empty-state">
                                <i class="fas fa-tags"></i>
                                <p>Chưa có danh mục nào</p>
                                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                                    Thêm danh mục đầu tiên
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($categories->hasPages())
        <div class="pagination-wrapper">
            {{ $categories->links() }}
        </div>
    @endif
@endsection

@push('scripts')
<script>
    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('.products-table tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
</script>
@endpush
