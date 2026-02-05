<!-- Categories Management Page -->
<div class="admin-page" id="categoriesPage" style="display: none;">
    <div class="page-header">
        <div>
            <h1>Quản Lý Danh Mục</h1>
            <p class="page-subtitle">Thêm, sửa, xóa danh mục sản phẩm</p>
        </div>
        <button class="btn btn-primary" onclick="window.showAddCategoryModal()">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Thêm Danh Mục
        </button>
    </div>

    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Danh Mục</th>
                    <th>Mô Tả</th>
                    <th>Số Sản Phẩm</th>
                    <th>Ngày Tạo</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody id="categoriesTable">
                <tr><td colspan="6" style="text-align: center;">Đang tải...</td></tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Thêm/Sửa Danh Mục -->
<div id="categoryModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="categoryModalTitle">Thêm Danh Mục</h2>
            <button class="modal-close" onclick="window.closeCategoryModal()">&times;</button>
        </div>
        <form id="categoryForm" onsubmit="window.saveCategory(event)">
            <div class="form-group">
                <label>Tên Danh Mục *</label>
                <input type="text" id="categoryName" required placeholder="Nhập tên danh mục">
            </div>

            <div class="form-group">
                <label>Mô Tả</label>
                <textarea id="categoryDescription" placeholder="Nhập mô tả danh mục" rows="4"></textarea>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="window.closeCategoryModal()">Hủy</button>
                <button type="submit" class="btn btn-primary">Lưu Danh Mục</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Show categories page
    window.showCategoriesPage = function() {
        console.log('showCategoriesPage function executing...');
        
        // Ẩn tất cả admin pages
        const pages = document.querySelectorAll('.admin-page');
        console.log('Found ' + pages.length + ' admin pages to hide');
        pages.forEach(page => page.style.display = 'none');
        
        // Hiện trang danh mục
        const categoriesPage = document.getElementById('categoriesPage');
        console.log('categoriesPage element:', categoriesPage);
        
        if (categoriesPage) {
            categoriesPage.style.display = 'block';
            console.log('Categories page displayed');
            console.log('window.loadCategories:', window.loadCategories);
            if (window.loadCategories) {
                window.loadCategories();
            } else {
                console.error('loadCategories function not found');
            }
        } else {
            console.error('categoriesPage element not found');
        }
    };

    window.currentCategories = window.currentCategories || [];

    // Load danh sách danh mục
    window.loadCategories = function() {
        console.log('loadCategories called, fetching from /api/categories');
        fetch('/api/categories')
            .then(res => res.json())
            .then(data => {
                console.log('Categories fetched:', data);
                window.currentCategories = data;
                window.renderCategoriesTable();
            })
            .catch(err => {
                console.error('Lỗi load danh mục:', err);
                document.getElementById('categoriesTable').innerHTML = 
                    '<tr><td colspan="6" style="text-align: center; color: red;">Lỗi khi tải dữ liệu</td></tr>';
            });
    }

    // Render bảng danh mục
    window.renderCategoriesTable = function() {
        const tbody = document.getElementById('categoriesTable');
        
        if (currentCategories.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" style="text-align: center;">Chưa có danh mục nào</td></tr>';
            return;
        }

        tbody.innerHTML = currentCategories.map(category => {
            const createdDate = new Date(category.created_at).toLocaleDateString('vi-VN');
            return `
                <tr>
                    <td>#${category.id}</td>
                    <td><strong>${category.name}</strong></td>
                    <td>${category.description || 'N/A'}</td>
                    <td><span class="badge">${category.products_count || 0}</span></td>
                    <td>${createdDate}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-sm btn-secondary" onclick="window.showEditCategoryModal(${category.id})" title="Sửa">✏️</button>
                            <button class="btn btn-sm btn-danger" onclick="window.deleteCategory(${category.id})" title="Xóa">🗑️</button>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');
    }

    // Hiển thị modal thêm danh mục
    window.showAddCategoryModal = function() {
        document.getElementById('categoryModalTitle').textContent = 'Thêm Danh Mục Mới';
        document.getElementById('categoryForm').reset();
        document.getElementById('categoryForm').dataset.categoryId = '';
        document.getElementById('categoryModal').style.display = 'flex';
    }

    // Hiển thị modal sửa danh mục
    window.showEditCategoryModal = function(id) {
        const category = currentCategories.find(c => c.id === id);
        if (!category) return;

        document.getElementById('categoryModalTitle').textContent = 'Sửa Danh Mục';
        document.getElementById('categoryName').value = category.name;
        document.getElementById('categoryDescription').value = category.description || '';
        document.getElementById('categoryForm').dataset.categoryId = id;
        document.getElementById('categoryModal').style.display = 'flex';
    }

    // Đóng modal
    window.closeCategoryModal = function() {
        document.getElementById('categoryModal').style.display = 'none';
        document.getElementById('categoryForm').reset();
        document.getElementById('categoryForm').dataset.categoryId = '';
    }

    // Lưu danh mục (thêm/sửa)
    window.saveCategory = function(event) {
        event.preventDefault();

        const categoryId = document.getElementById('categoryForm').dataset.categoryId;
        const data = {
            name: document.getElementById('categoryName').value,
            description: document.getElementById('categoryDescription').value || null,
        };

        const url = categoryId ? `/api/categories/${categoryId}` : '/api/categories';
        const method = categoryId ? 'PUT' : 'POST';

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
                alert(categoryId ? 'Cập nhật danh mục thành công!' : 'Thêm danh mục thành công!');
                window.closeCategoryModal();
                window.loadCategories();
            }
        })
        .catch(err => {
            console.error('Lỗi:', err);
            alert('Lỗi khi lưu danh mục');
        });
    }

    // Xóa danh mục
    window.deleteCategory = function(id) {
        const category = currentCategories.find(c => c.id === id);
        
        if (category && category.products_count > 0) {
            alert(`Không thể xóa danh mục "${category.name}" vì đang có ${category.products_count} sản phẩm.\n\nVui lòng xóa hoặc chuyển sản phẩm sang danh mục khác trước.`);
            return;
        }

        if (!confirm('Bạn chắc chắn muốn xóa danh mục này?')) return;

        fetch(`/api/categories/${id}`, {
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
                alert('Xóa danh mục thành công!');
                window.loadCategories();
            }
        })
        .catch(err => {
            console.error('Lỗi:', err);
            alert('Lỗi khi xóa danh mục');
        });
    }

    // Close modal khi click ngoài
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('categoryModal');
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
</script>


