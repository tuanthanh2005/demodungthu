// Test function for debugging
function debugCategories() {
    console.log('=== DEBUGGING CATEGORIES ===');
    console.log('window.showCategoriesPage:', typeof window.showCategoriesPage);
    console.log('categoriesTable element:', document.getElementById('categoriesTable'));

    // Test API directly
    fetch('/api/categories?debug=1&t=' + Date.now())
        .then(res => res.json())
        .then(data => {
            console.log('API Response:', data);

            // Try to manually render
            const tbody = document.getElementById('categoriesTable');
            if (tbody && data.length > 0) {
                tbody.innerHTML = data.map(category => `
                    <tr>
                        <td>#${category.id}</td>
                        <td><strong>${category.name}</strong></td>
                        <td>${category.description || 'N/A'}</td>
                        <td><span class="badge">${category.products_count || 0}</span></td>
                        <td>${new Date(category.created_at).toLocaleDateString('vi-VN')}</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn btn-sm btn-secondary">✏️</button>
                                <button class="btn btn-sm btn-danger">🗑️</button>
                            </div>
                        </td>
                    </tr>
                `).join('');
            }
        })
        .catch(err => {
            console.error('API Error:', err);
        });
}

// Call test function when script loads
window.debugCategories = debugCategories;