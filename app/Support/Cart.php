<?php

namespace App\Support;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class Cart
{
    public const KEY = 'cart';

    /** @return array<int, array{pid:int, pname:string, price:float, qty:int}> */
    public static function items(): array
    {
        return Session::get(self::KEY, []);
    }

    public static function add(Product $product, int $qty): bool
    {
        $items = self::items();
        foreach ($items as $item) {
            if ((int) $item['pid'] === (int) $product->id) {
                return false;
            }
        }
        $items[] = [
            'pid'   => $product->id,
            'pname' => $product->item_name,
            'image' => $product->image,
            'price' => (float) $product->price,
            'qty'   => max(1, $qty),
        ];
        Session::put(self::KEY, array_values($items));
        return true;
    }

    public static function updateQty(int $key, int $qty): void
    {
        $items = self::items();
        if (isset($items[$key])) {
            $items[$key]['qty'] = max(1, $qty);
            Session::put(self::KEY, array_values($items));
        }
    }

    public static function remove(int $pid): void
    {
        $items = self::items();
        $items = array_filter($items, fn ($i) => (int) $i['pid'] !== $pid);
        Session::put(self::KEY, array_values($items));
    }

    public static function clear(): void
    {
        Session::put(self::KEY, []);
    }

    public static function totalQty(): int
    {
        return array_sum(array_column(self::items(), 'qty'));
    }

    public static function totalAmount(): float
    {
        $sum = 0.0;
        foreach (self::items() as $i) {
            $sum += $i['qty'] * $i['price'];
        }
        return $sum;
    }
}
