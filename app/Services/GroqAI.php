<?php

namespace App\Services;

class GroqAI
{
    private $apiKey;
    private $apiUrl = 'https://api.groq.com/openai/v1/chat/completions';

    public function __construct()
    {
        $this->apiKey = env('GROQ_API_KEY');
    }

    public function chat($message, $context = [])
    {
        $messages = [
            [
                'role' => 'system',
                'content' => 'Bạn là trợ lý AI thông minh của ShopPro - website bán hàng online. Hãy trả lời câu hỏi của khách hàng một cách thân thiện, chuyên nghiệp và hữu ích. Trả lời bằng tiếng Việt.'
            ]
        ];

        // Add context if provided
        foreach ($context as $msg) {
            $messages[] = $msg;
        }

        // Add user message
        $messages[] = [
            'role' => 'user',
            'content' => $message
        ];

        $data = [
            'model' => 'llama-3.3-70b-versatile',
            'messages' => $messages,
            'temperature' => 0.7,
            'max_tokens' => 1024,
            'top_p' => 1,
            'stream' => false
        ];

        return $this->makeRequest($data);
    }

    public function productSearch($query)
    {
        $message = "Khách hàng đang tìm kiếm: '$query'. Hãy gợi ý 3-5 từ khóa tìm kiếm liên quan hoặc sản phẩm phù hợp. Chỉ trả về danh sách ngắn gọn, mỗi gợi ý trên 1 dòng.";

        $messages = [
            [
                'role' => 'system',
                'content' => 'Bạn là chuyên gia tìm kiếm sản phẩm. Hãy gợi ý các từ khóa tìm kiếm phù hợp cho website bán hàng điện tử, thời trang, mỹ phẩm. Trả lời ngắn gọn.'
            ],
            [
                'role' => 'user',
                'content' => $message
            ]
        ];

        $data = [
            'model' => 'llama-3.3-70b-versatile',
            'messages' => $messages,
            'temperature' => 0.5,
            'max_tokens' => 200,
            'stream' => false
        ];

        return $this->makeRequest($data);
    }

    public function productRecommendation($userPreferences)
    {
        $message = "Dựa trên sở thích: $userPreferences. Hãy gợi ý 3 sản phẩm phù hợp với lý do ngắn gọn.";

        $messages = [
            [
                'role' => 'system',
                'content' => 'Bạn là chuyên gia tư vấn sản phẩm. Hãy đề xuất sản phẩm phù hợp với nhu cầu khách hàng.'
            ],
            [
                'role' => 'user',
                'content' => $message
            ]
        ];

        $data = [
            'model' => 'llama-3.3-70b-versatile',
            'messages' => $messages,
            'temperature' => 0.7,
            'max_tokens' => 500,
            'stream' => false
        ];

        return $this->makeRequest($data);
    }

    private function makeRequest($data)
    {
        $ch = curl_init($this->apiUrl);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->apiKey
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        curl_close($ch);

        if ($httpCode !== 200) {
            return [
                'error' => true,
                'message' => 'API request failed',
                'code' => $httpCode
            ];
        }

        $result = json_decode($response, true);
        
        if (isset($result['choices'][0]['message']['content'])) {
            return [
                'success' => true,
                'message' => $result['choices'][0]['message']['content'],
                'usage' => $result['usage'] ?? null
            ];
        }

        return [
            'error' => true,
            'message' => 'Invalid API response'
        ];
    }
}
