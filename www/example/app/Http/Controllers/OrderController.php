<?php

namespace App\Http\Controllers;

use App\Http\Request\MusteriRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::with(['items' => function($query) {
            $query->select('order_id','product_id AS productId', 'quantity', 'unit_price AS unitPrice', 'total');
            }])
            ->select('id','customer_id AS customerId', 'total')
            ->get();

        if (!$orders) {
            return response()->json(['status'=>'error','message' => 'Siparişler bulunamadı'], 404);
        }

        return response()->json(['status'=>'success','orders'=>$orders]);
    }
    public function show($orderId){
        $order = Order::with(['items' => function ($query) {
            $query->select('order_id', 'product_id as ProductId', 'quantity', 'unit_price as unitPrice', 'total');
        }])
            ->select('id', 'customer_id', 'total')
            ->where('id', $orderId)
            ->first();

        if (!$order) {
            return response()->json(['status'=>'error','message' => 'Sipariş bulunamadı'], 404);
        }
        return response()->json(['status'=>'success','order'=>$order]);
    }
    public function getOrdersByCustomerId($customerId){
        $orders = Order::with(['items' => function ($query) {
            $query->select('order_id', 'product_id AS productId', 'quantity', 'unit_price as unitPrice', 'total');
        }])
            ->select('id', 'customer_id', 'total')
            ->where('customer_id', $customerId)
            ->get();

        if ($orders->isEmpty()) {
            return response()->json(['status'=>'error','message' => 'Bu müşteri için sipariş bulunamadı'], 404);
        }

        return response()->json(['status'=>'success','orders'=>$orders]);
    }
    public function delete($orderId){
        $order = Order::find($orderId);
        if (!$order) {
            return response()->json(['status'=>'error','message' => 'Sipariş bulunamadı'], 404);
        }
        $order->items()->delete();
        $order->delete();
        return response()->json(['status'=>'success','message' => 'Sipariş başarıyla silindi']);
    }

    public function store(StoreOrderRequest $request){
        $validated = $request->validated();
        $items     = $validated['items'];
        $totalAmount = 0;

        DB::beginTransaction();
        try {
            $order = Order::create([
                'customer_id' => $validated['customerId'],
                'total'       => $totalAmount,
            ]);

            foreach ($items as $item) {
                $product = Product::find($item['productId']);
                if (!$product) {
                    return response()->json(['status'=>'error','message' => 'Ürün bulunamadı: ' . $item['productId']], 404);
                }
                if ($product->stock < $item['quantity']) {
                    return response()->json(['status'=>'error','message' => 'Yeterli stok yok: ' . $product->name . ', Mevcut stok: ' . $product->stock], 400);
                }
                $product->decrement('stock', $item['quantity']);
                $totalAmount += $product->price * $item['quantity'];
                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity'   => $item['quantity'],
                    'unit_price' => $product->price,
                    'total'      => $totalAmount,
                ]);
            }
            $order->update(['total' => $totalAmount]);
            DB::commit();
            return response()->json(['status'=>'success','message' => 'Sipariş başarıyla oluşturuldu.','order' => $order], 201);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status'=>'error','error' => 'Bir hata oluştu: ' . $e->getMessage()], 500);
        }
    }
    public function update(StoreOrderRequest $request, $id){
        $validated   = $request->validated();
        $items       = $validated['items'];
        $totalAmount = 0;
        DB::beginTransaction();
        try {
            $order = Order::find($id);
            if (!$order) {
                return response()->json(['status'=>'error','message' => 'Sipariş bulunamadı.',], 404);
            }
            $order->customer_id = ($validated['customerId'] ?? $order->customer_id);

            foreach ($items as $item) {
                $product = Product::find($item['productId']);
                if (!$product) {
                    return response()->json(['status'=>'error','message' => 'Ürün bulunamadı: ' . $item['productId']], 404);
                }
                if ($product->stock < $item['quantity']) {
                    return response()->json(['status'=>'error','message' => 'Yeterli stok yok: ' . $product->name], 400);
                }
                $totalAmount += $product->price * $item['quantity'];
                $orderItem    = $order->items()->where('product_id', $product->id)->first();
                if ($orderItem) {
                    $orderItem->update([
                        'quantity'   => $item['quantity'],
                        'unit_price' => $product->price,
                        'total'      => $totalAmount,
                    ]);
                }
            }

            $allTotalAmount = Order::where('id', $id)->first()->items->sum(function($item) {
                return $item->total;
            });
            $order->total = $allTotalAmount;
            $order->save();
            DB::commit();
            return response()->json(['status'=>'success','message' => 'Sipariş başarıyla güncellendi.','order' => $order,], 200);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status'=>'error','message' => 'Bir hata oluştu: ' . $e->getMessage()], 500);
        }
    }
}
