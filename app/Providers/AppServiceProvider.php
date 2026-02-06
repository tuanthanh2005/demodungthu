<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $cart = session('cart', []);
            $cartCount = collect($cart)->sum('quantity');

            $footerSettings = $this->loadFooterSettings();
            $websiteSettings = $this->loadWebsiteSettings();

            $view->with('cartCount', $cartCount);
            $view->with('footerSettings', $footerSettings);
            $view->with('websiteSettings', $websiteSettings);
        });
    }

    private function loadFooterSettings(): array
    {
        $defaults = [
            'site_name' => 'ShopPro VIP',
            'footer_about' => 'Website bán hàng chuyên nghiệp với đội ngũ tư vấn nhiệt tình và sản phẩm chất lượng cao.',
            'copyright_text' => '© ' . date('Y') . ' ShopPro VIP | Made with love by Professional Team',
            'address' => '123 Đường Nguyễn Văn Linh, Quận 7, TP.HCM',
            'phone' => '0123 456 789',
            'email' => 'contact@shoppro.vn',
            'working_hours' => '8:00 - 22:00 (Thứ 2 - Chủ Nhật)',
            'social_facebook' => 'https://facebook.com/shoppro',
            'social_instagram' => 'https://instagram.com/shoppro',
            'social_tiktok' => 'https://tiktok.com/@shoppro',
            'social_youtube' => 'https://youtube.com/c/shoppro'
        ];

        $path = storage_path('app/settings/footer.json');
        if (!file_exists($path)) {
            return $defaults;
        }

        $json = file_get_contents($path);
        $data = json_decode($json, true);
        if (!is_array($data)) {
            return $defaults;
        }

        return array_merge($defaults, $data);
    }

    private function loadWebsiteSettings(): array
    {
        $defaults = [
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

        $path = storage_path('app/settings/website.json');
        if (!file_exists($path)) {
            return $defaults;
        }

        $json = file_get_contents($path);
        $data = json_decode($json, true);
        if (!is_array($data)) {
            return $defaults;
        }

        return array_merge($defaults, $data);
    }
}
