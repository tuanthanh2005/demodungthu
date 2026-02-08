<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Shop thời trang online')">
    <title>@yield('title', 'Shop')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/ecommerce.css') }}?v={{ filemtime(public_path('css/ecommerce.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/product-stock.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

    @stack('styles')
</head>
<body>
    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <!-- Toast Notification -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100;">
        <div id="liveToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-check-circle me-2"></i> <span id="toastMessage">Thành công!</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Quick Add Modal -->
    @include('partials.quick-add-modal')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Global Helper Functions
        function showToast(message, type = 'success') {
            const toastEl = document.getElementById('liveToast');
            const toastBody = document.getElementById('toastMessage');
            const toast = new bootstrap.Toast(toastEl);
            
            toastEl.className = `toast align-items-center text-white bg-${type} border-0`;
            toastBody.textContent = message;
            toast.show();
        }

        function updateCartBadge(count) {
            console.log('updateCartBadge called with count:', count);
            // Use more specific selector to avoid selecting wishlist badge
            const cartBadge = document.querySelector('.navx-badge:not(.navx-badge-wishlist)');
            console.log('Found cart badge element:', cartBadge);
            if (cartBadge) {
                cartBadge.textContent = count;
                cartBadge.classList.remove('d-none');
                console.log('Badge updated, classes:', cartBadge.className);
                
                // Animation
                cartBadge.classList.remove('bump-animate');
                void cartBadge.offsetWidth; // Force reflow
                cartBadge.classList.add('bump-animate');
            } else {
                console.error('Cart badge element not found!');
            }
        }

        function updateWishlistBadge(count) {
            const wishlistBadge = document.querySelector('.navx-badge-wishlist');
            if (wishlistBadge) {
                wishlistBadge.textContent = count;
                if (count > 0) {
                    wishlistBadge.classList.remove('d-none');
                } else {
                    wishlistBadge.classList.add('d-none');
                }
                
                // Animation
                wishlistBadge.classList.remove('bump-animate');
                void wishlistBadge.offsetWidth; // Force reflow
                wishlistBadge.classList.add('bump-animate');
            }
        }

        // Helper function to format price
        function formatPrice(price) {
            return new Intl.NumberFormat('vi-VN').format(price) + 'đ';
        }

        // Helper function to prepare colors array
        function prepareColors(product) {
            console.log('prepareColors input:', product); // Debug
            let colors = [];
            
            // Try color_prices first
            if (product.color_prices && Array.isArray(product.color_prices)) {
                console.log('Using color_prices:', product.color_prices); // Debug
                colors = product.color_prices.map(c => ({
                    hex: c.hex || '#000',
                    name: c.name || c.hex || 'Color'
                }));
            }
            // Fallback to colors array
            else if (product.colors && Array.isArray(product.colors)) {
                console.log('Using colors:', product.colors); // Debug
                colors = product.colors.map(c => ({
                    hex: c,
                    name: c
                }));
            }
            
            console.log('prepareColors output:', colors); // Debug
            return colors;
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Global Event Delegation for Product Cards
            document.body.addEventListener('click', function(e) {
                if (e.target.closest('.btn-add-cart')) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const btn = e.target.closest('.btn-add-cart');
                    if(btn.disabled) return;

                    const productId = btn.dataset.productId;
                    if (!productId) {
                        console.error('Product ID not found');
                        return;
                    }
                    
                    // Fetch product details to show in modal
                    fetch(`/api/product/${productId}`)
                        .then(response => response.json())
                        .then(product => {
                            console.log('Full product data from API:', product); // Debug
                            console.log('product.colors:', product.colors); // Debug
                            console.log('product.color_prices:', product.color_prices); // Debug
                            
                            // Prepare product data for modal
                            const productData = {
                                id: product.id,
                                name: product.name,
                                image: product.image || 'https://via.placeholder.com/400',
                                price: formatPrice(product.sale_price > 0 ? product.sale_price : product.regular_price),
                                sizes: product.sizes || [],
                                colors: prepareColors(product),
                                sizePrices: product.size_prices || [],
                                colorPrices: product.color_prices || []
                            };
                            
                            console.log('Prepared productData:', productData); // Debug
                            
                            // Open modal
                            if (typeof openQuickAddModal === 'function') {
                                openQuickAddModal(productData);
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching product:', error);
                            showToast('Không thể tải thông tin sản phẩm', 'danger');
                        });
                }

                // Wishlist (Grid Buttons)
                if (e.target.closest('.btn-wishlist')) {
                    const btn = e.target.closest('.btn-wishlist');
                    if(btn.disabled) return;

                    const productId = btn.dataset.productId;
                    const icon = btn.querySelector('i');
                    const isActive = icon.classList.contains('fas');

                    if (!isActive) {
                        fetch('{{ route('wishlist.add') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ id: productId })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                icon.classList.remove('far');
                                icon.classList.add('fas');
                                btn.classList.add('text-danger');
                                
                                // Update wishlist badge
                                if (data.count !== undefined) {
                                    updateWishlistBadge(data.count);
                                }
                                
                                showToast(data.success || 'Đã thêm vào danh sách yêu thích!', 'success');
                            } else if (data.info) {
                                showToast(data.info, 'info');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showToast('Có lỗi xảy ra, vui lòng thử lại.', 'danger');
                        });
                    } else {
                        // Optional: remove from wishlist or redirect
                        window.location.href = "{{ route('wishlist.index') }}";
                    }
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
