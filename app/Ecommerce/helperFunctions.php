<?php

/*
 * @author Phillip Madsen
 */

namespace Ecommerce;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Collection;
use Sentinel;
use Session;

class helperFunctions
{
    /**
     * @param $cart
     * @param $total
     */
    public static function getCartInfo(&$cart, &$total)
    {
        if (Sentinel::check()) {

            //$cart = Sentinel::getUser()->cart;
            $cart = Cart::where('user_id', Sentinel::getUser()->id)->get();
        } else {
            $cart = new Collection();
            if (Session::has('cart')) {
                foreach (Session::get('cart') as $item) {
                    $elem = new Cart();
                    $elem->product_id = $item['product_id'];
                    $elem->amount = $item['quantity'];
                    if (isset($item['options'])) {
                        $elem->options = $item['options'];
                    }
                    $cart->add($elem);
                }
            }
        }
        $total = 0;
        if ($cart) {
            foreach ($cart as $item) {
                $total += floatval(preg_replace('/[\$,]/', '', $item->product->price)) * $item->amount;
            }
        } else {
            $cart = new Collection();
        }
    }
}
