<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GroqAI;

class AIChatController extends Controller
{
    public function chat(Request $request)
    {
        try {
            $message = $request->input('message');
            
            if (!$message) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng nhập tin nhắn'
                ]);
            }

            $groqAI = new GroqAI();
            $response = $groqAI->chat($message);

            if (isset($response['success']) && $response['success'] && isset($response['message'])) {
                return response()->json([
                    'success' => true,
                    'message' => $response['message']
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xử lý tin nhắn. Vui lòng thử lại!'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
}
}
