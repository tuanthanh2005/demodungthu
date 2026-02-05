// INLINE CATEGORIES MANAGEMENT
let currentCategoriesInline = [];

function showCategoriesPageInline() {
    const pageContent = document.getElementById('page-content');

    pageContent.innerHTML = `
        <div class="admin-page">
            <div class="page-header">
                <div>
                    <h1>Quản Lý Danh Mục</h1>
                    <p class="page-subtitle">Thêm, sửa, xóa danh mục sản phẩm</p>
                </div>
                <button class="btn btn-primary" onclick="showAddCategoryModalInline()">
                    + Thêm Danh Mục
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
        <div id="categoryModalInline" class="modal" style="display: none;">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 id="categoryModalTitleInline">Thêm Danh Mục</h2>
                    <button class="modal-close" onclick="closeCategoryModalInline()">&times;</button>
                </div>
                <form id="categoryFormInline" onsubmit="saveCategoryInline(event)">
                    <div class="form-group">
                        <label>Tên Danh Mục *</label>
                        <input type="text" id="categoryNameInline" required placeholder="Nhập tên danh mục">
                    </div>
                    <div class="form-group">
                        <label>Mô Tả</label>
                        <textarea id="categoryDescriptionInline" placeholder="Nhập mô tả danh mục" rows="4"></textarea>
                    </div>
                    <div class="modal-actions">
                        <button type="button" class="btn btn-secondary" onclick="closeCategoryModalInline()">Hủy</button>
                        <button type="submit" class="btn btn-primary">Lưu Danh Mục</button>
                    </div>
                </form>
            </div>
        </div>
    `;

    // Load data immediately
    loadCategoriesDataInline();
}

function loadCategoriesDataInline() {
    fetch('/api/categories?inline=1&t=' + Date.now())
        .then(res => res.json())
        .then(data => {
            currentCategoriesInline = data;
            const tbody = document.getElementById('categoriesTable');
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" style="text-align: center;">Chưa có danh mục nào</td></tr>';
                return;
            }

            tbody.innerHTML = data.map(category => {
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
                                <button class="btn btn-sm btn-secondary" onclick="showEditCategoryModalInline(${category.id})" title="Sửa">✏️</button>
                                <button class="btn btn-sm btn-danger" onclick="deleteCategoryInline(${category.id})" title="Xóa">🗑️</button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
        })
        .catch(err => {
            console.error('Lỗi load danh mục:', err);
            document.getElementById('categoriesTable').innerHTML =
                '<tr><td colspan="6" style="text-align: center; color: red;">Lỗi khi tải dữ liệu</td></tr>';
        });
}

// Modal Functions
function showAddCategoryModalInline() {
    document.getElementById('categoryModalTitleInline').textContent = 'Thêm Danh Mục Mới';
    document.getElementById('categoryFormInline').reset();
    document.getElementById('categoryFormInline').dataset.categoryId = '';
    document.getElementById('categoryModalInline').style.display = 'flex';
}

function showEditCategoryModalInline(id) {
    const category = currentCategoriesInline.find(c => c.id === id);
    if (!category) return;

    document.getElementById('categoryModalTitleInline').textContent = 'Sửa Danh Mục';
    document.getElementById('categoryNameInline').value = category.name;
    document.getElementById('categoryDescriptionInline').value = category.description || '';
    document.getElementById('categoryFormInline').dataset.categoryId = id;
    document.getElementById('categoryModalInline').style.display = 'flex';
}

function closeCategoryModalInline() {
    document.getElementById('categoryModalInline').style.display = 'none';
    document.getElementById('categoryFormInline').reset();
    document.getElementById('categoryFormInline').dataset.categoryId = '';
}

// CRUD Functions
function saveCategoryInline(event) {
    event.preventDefault();

    const categoryId = document.getElementById('categoryFormInline').dataset.categoryId;
    const data = {
        name: document.getElementById('categoryNameInline').value,
        description: document.getElementById('categoryDescriptionInline').value || null,
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
                closeCategoryModalInline();
                loadCategoriesDataInline();
            }
        })
        .catch(err => {
            console.error('Lỗi:', err);
            alert('Lỗi khi lưu danh mục');
        });
}

function deleteCategoryInline(id) {
    const category = currentCategoriesInline.find(c => c.id === id);

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
                loadCategoriesDataInline();
            }
        })
        .catch(err => {
            console.error('Lỗi:', err);
            alert('Lỗi khi xóa danh mục');
        });
}

// Override the categories function
window.showCategoriesPage = showCategoriesPageInline;