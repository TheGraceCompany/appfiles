<?php

/*
 * @author Phillip Madsen
 */

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Sentinel;
use Session;

/**
 * Interface CartInterface.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
interface CartInterface extends RepositoryInterface
{
    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getBySlug($slug, $isPublished = false);

    public static function getCartInfo(&$sections, &$cart, &$total)
    {
        if (Sentinel::check()) {
            $cart = Auth::user()->cart;
        } else {
            $cart = new Collection();
            if (Session::has('cart')) {
                foreach (Session::get('cart') as $item) {
                    $elem = new Cart();
                    $elem->product_id = $item['product_id'];
                    $elem->amount = $item['qty'];
                    if (isset($item['options'])) {
                        $elem->options = $item['options'];
                    }
                    $cart->add($elem);
                }
            }
        }
        $total = 0;
        foreach ($cart as $item) {
            $total += $item->product->price * $item->amount;
        }
    }
}
