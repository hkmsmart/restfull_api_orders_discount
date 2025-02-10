<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\DiscountService;

class DiscountController extends Controller
{
    protected $discountService;

    public function __construct(DiscountService $discountService)
    {
        $this->discountService = $discountService;
    }

    public function discount($orderId)
    {
        $order = Order::with(['items' => function ($query) {
            $query->select('order_id', 'product_id as ProductId', 'quantity', 'unit_price as unitPrice', 'total');
        }])
            ->select('id', 'customer_id', 'total')
            ->where('id', $orderId)
            ->first();

        if (!$order) {
            return response()->json(['status'=>'error','message' => 'Sipariş bulunamadı'], 404);
        }

        $response = $this->discountService->calculateDiscounts($order);
        return response()->json($response);
    }
}
