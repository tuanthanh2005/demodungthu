📚 HƯỚNG DẪN QUẢN LÝ DANH MỤC
================================

✨ Tính năng đã hoàn tất:
✅ Thêm danh mục mới
✅ Sửa danh mục (tên, mô tả)
✅ Xóa danh mục (nếu không có sản phẩm)
✅ Xem danh sách danh mục
✅ Hiển thị số sản phẩm trong từng danh mục
✅ Ngày tạo tự động

🎯 Cách sử dụng:
1. Vào Admin Panel: http://localhost:8000/admin
2. Click vào "Danh Mục" trong Sidebar
3. Nhấn nút "Thêm Danh Mục" để thêm mới

📋 Các bước:

THÊM DANH MỤC:
- Nhấn "➕ Thêm Danh Mục"
- Nhập tên danh mục
- Nhập mô tả (tùy chọn)
- Nhấn "Lưu Danh Mục"

SỬA DANH MỤC:
- Nhấn nút "✏️" trên hàng danh mục cần sửa
- Chỉnh sửa thông tin
- Nhấn "Lưu Danh Mục"

XÓA DANH MỤC:
- Nhấn nút "🗑️" trên hàng danh mục cần xóa
- Xác nhận xóa
- Lưu ý: Chỉ xóa được khi danh mục không có sản phẩm

⚙️ API Endpoints:
GET    /api/categories           - Lấy danh sách danh mục
GET    /api/categories/{id}      - Lấy chi tiết danh mục
POST   /api/categories           - Tạo danh mục mới
PUT    /api/categories/{id}      - Cập nhật danh mục
DELETE /api/categories/{id}      - Xóa danh mục

📊 Validation:
✓ Tên danh mục không được trống
✓ Tên danh mục phải duy nhất (không trùng lặp)
✓ Không thể xóa danh mục có sản phẩm
✓ Mô tả là tùy chọn

🔗 Liên kết với Sản Phẩm:
- Mỗi sản phẩm phải thuộc một danh mục
- Xóa danh mục sẽ hiển thị cảnh báo nếu có sản phẩm

💾 Dữ liệu:
- Tất cả dữ liệu được lưu vào database (bảng categories)
- Tự động ghi lại created_at và updated_at
- Có thể sử dụng trên tất cả các thiết bị
