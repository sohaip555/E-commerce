<?php

namespace App\Helpers;

use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class CartManagement
{

    static public function  addItemToCart($product_id): int
    {
        $cart_items = self::getCartItemsFromCookie();
        $existing_item = null;

//        dd($cart_items, $product_id);

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id)  {
                $existing_item = $key;
                break;
            }
        }

//        dd($existing_item);

        if ($existing_item !== null){
            $cart_items[$existing_item]['quantity']++;
            $cart_items[$existing_item]['total_amount'] = $cart_items[$existing_item]['quantity'] * $cart_items[$existing_item]['unit_amount'];

//            dd($cart_items);
        } else {
            $product = Product::where('id', $product_id)->first(['id', 'name', 'images', 'price']);
//            dd($product);
//            dd(Product::where('id', $product_id)->get(['id', 'name', 'images', 'price']));
            if ($product)
            {
                $cart_items[] = [
                    'product_id' => $product_id,
                    'name' => $product->name,
                    'image' => $product->images[0],
                    'quantity' => 1,
                    'unit_amount' => $product->price,
                    'total_amount' => $product->price,
                ];
            }
        }
//        dd($cart_items, $product_id);

        self::addCartItemsToCookie($cart_items);
        return count($cart_items);
    }

    public static function removeCartItem($product_id)
    {
        $cart_items = self::getCartItemsFromCookie();

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                unset($cart_items[$key]);
                break;
            }
        }

        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    public static function addCartItemsToCookie($cart_items): void
    {
//        dd($cart_items);
        Cookie::queue('cart_items', json_encode($cart_items), 60 * 24 * 30);
    }

    public static function clearCartItems(): void
    {
        Cookie::queue(Cookie::forget('cart_items'));
    }

    public static function getCartItemsFromCookie()
    {
        $cart_items = json_decode(Cookie::get('cart_items'), true);
        if ($cart_items == null)  {
            $cart_items = [];
        }

        return $cart_items;
    }

    static public function incrementQuantityToCartItems($product_id): array
    {
        $cart_items = self::getCartItemsFromCookie();

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id)  {
                $cart_items[$key]['quantity']++;
                $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount'];
                break;
            }
        }

        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    static public function decrementQuantityToCartItems($product_id): array
    {
        $cart_items = self::getCartItemsFromCookie();

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id)  {
                if ($item['quantity'] > 1) {
                    $cart_items[$key]['quantity']--;
                    $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount'];
                    break;
                }
            }
        }

        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    public static function calculateGrandTotal($items): float|int
    {
        return array_sum(array_column($items, 'total_amount'));
    }

}
