<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RecommendationController extends Controller
{
    public function getRecommendations($customerId)
    {
        // URL của API Flask
        $url = 'http://127.0.0.1:5001/recommend';  // Thay bằng URL thực tế của Flask API

        // Gửi yêu cầu GET đến API Flask với tham số customer_id
        $response = Http::get($url, [
            'customer_id' => $customerId
        ]);

        // Kiểm tra nếu API trả về lỗi
        if ($response->failed()) {
            return response()->json([
                'error' => 'Không thể lấy thông tin gợi ý từ API Flask.'
            ], 500);
        }

        // Kiểm tra nếu API trả về dữ liệu hợp lệ
        $data = $response->json();

        if (isset($data['error'])) {
            return response()->json($data, 404);
        }

        // Trả về kết quả JSON từ API Flask
        return response()->json($data, 200);
    }
}
