<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SettingsController extends Controller
{
    /**
     * Get footer settings
     */
    public function getFooterSettings(): JsonResponse
    {
        // Default footer settings
        $defaultSettings = [
            'site_name' => 'ShopPro',
            'footer_about' => 'Website bán hàng chuyên nghiệp với đội ngũ tư vấn nhiệt tình và sản phẩm chất lượng cao.',
            'copyright_text' => '© 2026 ShopPro | Made with ❤️ by Professional Team',
            'address' => '123 Đường Nguyễn Văn Linh, Quận 7, TP.HCM',
            'phone' => '0123 456 789',
            'email' => 'contact@shoppro.vn',
            'working_hours' => '8:00 - 22:00 (Thứ 2 - Chủ Nhật)',
            'social_facebook' => 'https://facebook.com/shoppro',
            'social_instagram' => 'https://instagram.com/shoppro',
            'social_tiktok' => 'https://tiktok.com/@shoppro',
            'social_youtube' => 'https://youtube.com/c/shoppro'
        ];

        // Try to load from cache/storage (for now, return defaults)
        $settings = $this->loadSettingsFromStorage() ?? $defaultSettings;

        return response()->json($settings);
    }

    /**
     * Save footer settings
     */
    public function saveFooterSettings(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'site_name' => 'nullable|string|max:100',
            'footer_about' => 'nullable|string|max:500',
            'copyright_text' => 'nullable|string|max:200',
            'address' => 'nullable|string|max:300',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'working_hours' => 'nullable|string|max:100',
            'social_facebook' => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'social_tiktok' => 'nullable|url|max:255',
            'social_youtube' => 'nullable|url|max:255',
        ]);

        // Save settings to storage
        $this->saveSettingsToStorage($validated);

        return response()->json([
            'success' => true,
            'message' => 'Footer settings saved successfully',
            'data' => $validated
        ]);
    }

    /**
     * Get website settings (theme, colors, name)
     */
    public function getWebsiteSettings(): JsonResponse
    {
        // Default website settings
        $defaultSettings = [
            'website_name' => 'ShopPro VIP',
            'website_tagline' => 'Website bán hàng',
            'primary_color' => '#7851A9',
            'secondary_color' => '#A583C7',
            'background_color' => '#f5f3f8',
            'card_color' => '#ffffff',
            'text_color' => '#2d1b47',
            'muted_color' => '#6b7280',
            'success_color' => '#10b981',
            'error_color' => '#ef4444',
            'warning_color' => '#f59e0b',
            'accent_color' => '#F39C12'
        ];

        // Try to load from storage
        $settings = $this->loadWebsiteSettingsFromStorage() ?? $defaultSettings;
        
        return response()->json($settings);
    }

    /**
     * Save website settings (theme, colors, name)
     */
    public function saveWebsiteSettings(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'website_name' => 'nullable|string|max:100',
            'website_tagline' => 'nullable|string|max:200',
            'primary_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'secondary_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'background_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'card_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'text_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'muted_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'success_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'error_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'warning_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'accent_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/'
        ]);

        // Save settings to storage
        $this->saveWebsiteSettingsToStorage($validated);

        return response()->json([
            'success' => true,
            'message' => 'Website settings saved successfully',
            'data' => $validated
        ]);
    }

    /**
     * Load settings from storage (JSON file for simplicity)
     */
    private function loadSettingsFromStorage(): ?array
    {
        $filePath = storage_path('app/settings/footer.json');
        
        if (!file_exists($filePath)) {
            return null;
        }

        $json = file_get_contents($filePath);
        return json_decode($json, true);
    }

    /**
     * Save settings to storage (JSON file for simplicity)
     */
    private function saveSettingsToStorage(array $settings): void
    {
        $directory = storage_path('app/settings');
        
        // Create directory if it doesn't exist
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $filePath = $directory . '/footer.json';
        file_put_contents($filePath, json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    /**
     * Load website settings from storage
     */
    private function loadWebsiteSettingsFromStorage(): ?array
    {
        $filePath = storage_path('app/settings/website.json');
        if (!file_exists($filePath)) {
            return null;
        }
        $json = file_get_contents($filePath);
        return json_decode($json, true);
    }

    /**
     * Save website settings to storage
     */
    private function saveWebsiteSettingsToStorage(array $settings): void
    {
        $directory = storage_path('app/settings');
        // Create directory if it doesn't exist
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        $filePath = $directory . '/website.json';
        file_put_contents($filePath, json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}