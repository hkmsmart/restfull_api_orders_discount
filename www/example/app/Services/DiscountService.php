<?php
namespace App\Services;

use App\Models\Discount;

class DiscountService
{
    public function calculateDiscounts($order)
    {
        $discounts = [];
        $totalAmount = 0;

        foreach ($order['items'] as $item) {
            $totalAmount += $item['total'];
        }

        $appliedDiscounts = Discount::all();
        foreach ($appliedDiscounts as $discount) {
            switch ($discount->type) {
                case 'percentage':
                    if ($discount->min_total && $totalAmount >= $discount->min_total) {
                        $discountAmount = $totalAmount * ($discount->value / 100);
                        $discounts[] = $this->formatDiscount('PERCENTAGE_DISCOUNT', $discountAmount, $totalAmount);
                        $totalAmount -= $discountAmount;
                    }
                    break;

                case 'fixed':
                    if ($discount->min_total && $totalAmount >= $discount->min_total) {
                        $discountAmount = $discount->value;
                        $discounts[] = $this->formatDiscount('FIXED_DISCOUNT', $discountAmount, $totalAmount);
                        $totalAmount -= $discountAmount;
                    }
                    break;

                case 'free_item':
                    foreach ($order['items'] as $item) {
                        if ($item['category_id'] == $discount->category_id && $item['quantity'] >= $discount->min_quantity) {
                            $freeItems = intdiv($item['quantity'], $discount->min_quantity);
                            $discountAmount = $freeItems * $item['price'];
                            $discounts[] = $this->formatDiscount('BUY_X_GET_1', $discountAmount, $totalAmount);
                            $totalAmount -= $discountAmount;
                        }
                    }
                    break;
            }
        }

        $totalDiscount = array_sum(array_column($discounts, 'discountAmount'));

        return [
            'status' => 'success',
            'orderId' => $order['orderId'],
            'discounts' => $discounts,
            'totalDiscount' => number_format($totalDiscount, 2),
            'discountedTotal' => number_format($totalAmount, 2),
        ];
    }

    private function formatDiscount($reason, $amount, $subtotal)
    {
        return [
            'discountReason' => $reason,
            'discountAmount' => number_format($amount, 2),
            'subtotal' => number_format($subtotal - $amount, 2)
        ];
    }
}
