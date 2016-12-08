<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\OptionValue;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Redirect;
use Sentinel;
// use \Ecommerce\helperFunctions;
use Session;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        if (!Session::has('shipping')) {
            return Redirect::to(getLang().'/cart')->with([
                        'flash_message' => (isset($return['Error'])) ? $return['Error']['ErrorDescription'] : 'Fill all fields!',
            ]);
        }

        if (Sentinel::getUser()) {
            $cart = Cart::where('user_id', Sentinel::getUser()->id)->get();
            $user = User::find(Sentinel::getUser()->id);
            $userLocation = $user->location;
            $userInfo = $user->userInfo;
            $billing = $userLocation->where('location_type', 'billing')->first();

            $shipping = $userLocation->where('location_type', 'shipping')->first();
            //dd($shipping->first_name);
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
        $options = new Collection();
        if (!count($cart)) {
            return Redirect::to(getLang().'/cart');
        }
        foreach ($cart as $item) {
            $total += number_format(floatval(preg_replace('/[\$,]/', '', $item->product->price)) * $item->amount, 2, '.', ',');
            if ($item->options) {
                $values = explode(',', $item->options);
                foreach ($values as $value) {
                    $options->add(OptionValue::find($value));
                }
            }
        }

        $sub_total = number_format($total, 2, '.', ',');
        $discount = 0;
        if (Session::has('coupon')):
            $discount = number_format((($total * Session::get('coupon.discount')) / 100), 2, '.', ',');
        $total = $total - $discount;
        endif;
        $shipping_rate = (isset(Session::get('shipping')[0]['rate']) ? number_format(Session::get('shipping')[0]['rate'], 2, '.', '') : 0);
        $tax_rate = (isset(Session::get('tax')[0]['rate']) ? number_format(Session::get('tax')[0]['rate'], 2, '.', '') : 0);
        $total += $shipping_rate + $tax_rate;

        $total = number_format($total, 2, '.', ',');
        //dd(Session::get('coupon'));
        return view('frontend.shop.checkout', compact('shipping_rate', 'total', 'discount', 'sub_total', 'cart', 'billing', 'shipping', 'userInfo', 'options'));
    }

    public function thankyou($id)
    {
        $orderDetails = OrderProduct::where('order_id', $id)->get();
        $order = Order::find($id);
        $options = new Collection();
        $total = 0;

        foreach ($orderDetails as $detail) {
            $total += number_format(floatval(preg_replace('/[\$,]/', '', $detail->product->price)) * $detail->amount, 2, '.', ',');

            if ($detail->options) {
                $values = explode(',', $detail->options);
                foreach ($values as $value) {
                    $options->add(OptionValue::find($value));
                }
            }
        }

        return view('frontend.shop.thankyou', compact('total', 'orderDetails', 'order', 'options'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
