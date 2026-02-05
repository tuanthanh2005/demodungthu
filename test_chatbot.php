<?php

// Test script để kiểm tra AI chatbot
require_once 'vendor/autoload.php';
require_once 'app/Services/GroqAI.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use App\Services\GroqAI;

echo "=== KIỂM TRA AI CHATBOT ===" . PHP_EOL;

// Kiểm tra API key
$apiKey = $_ENV['GROQ_API_KEY'] ?? null;
echo "API Key: " . ($apiKey ? "✅ Đã cấu hình" : "❌ Chưa cấu hình") . PHP_EOL;

if (!$apiKey) {
    echo "Vui lòng cấu hình GROQ_API_KEY trong file .env" . PHP_EOL;
    exit(1);
}

// Test GroqAI service
try {
    echo "Đang test GroqAI service..." . PHP_EOL;
    
    $groq = new GroqAI();
    $response = $groq->chat("Xin chào, bạn là ai?");
    
    if (isset($response['choices'][0]['message']['content'])) {
        echo "✅ AI Response: " . $response['choices'][0]['message']['content'] . PHP_EOL;
    } else {
        echo "❌ Lỗi: Response không hợp lệ" . PHP_EOL;
        var_dump($response);
    }
    
} catch (Exception $e) {
    echo "❌ Lỗi: " . $e->getMessage() . PHP_EOL;
}

echo "=== KẾT THÚC TEST ===" . PHP_EOL;