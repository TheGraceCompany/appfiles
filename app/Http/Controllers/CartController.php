<?php

/*
 * @author Phillip Madsen
 */

namespace App\Http\Controllers;

use App;
use App\Models\Cart;
use App\Models\Location;
use App\Models\LocationUser;
use App\Models\OptionValue;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Tax;
use App\Models\User;
use App\Models\UserInfo;
use Config;
use Ecommerce\helperFunctions;
use Flash;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Sentinel;
use Session;
use Ups;
// use \Ecommerce\helperFunctions;
use Validator;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('sentinel.auth', ['except' => [
                'index',
                'add',
                'remove',
                'clear',
                'calcShipping',
        ]]);
    }

    public function getUserId()
    {
        return Sentinel::getUser()->getUserId();
    }

    public function index()
    {
        //        $ch = curl_init();
//
//curl_setopt($ch, CURLOPT_URL,"https://pilot-payflowpro.paypal.com");
//curl_setopt($ch, CURLOPT_POST, 1);
//curl_setopt($ch, CURLOPT_POSTFIELDS,
//            'PARTNER=PayPal&PWD=$onuverm81990&VENDOR=ravi9590&USER=ravi9590&CREATESECURETOKEN=Y&SECURETOKENID=12528208de1413abc3d60c86cb15&TRXTYPE=S&AMT=10');
//
//// in real life you should use something like:
//// curl_setopt($ch, CURLOPT_POSTFIELDS,
////          http_build_query(array('postvar1' => 'value1')));
//
//// receive server response ...
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//
//$server_output = curl_exec ($ch);
//
//curl_close ($ch);
//dd($server_output);
// $client = new \GuzzleHttp\Client();
//
//$response = $client->Request('POST', 'https://pilot-payflowpro.paypal.com',
//    ['form_params' => ['PARTNER' => 'PayPal', 'PWD' => '$onuverm81990', 'VENDOR' => 'ravi9590 ', 'USER' => 'ravi9590 ',
//        'TENDER' => 'C', 'ACCT' => '5105105105105100', 'TRXTYPE' => 'S', 'EXPDATE' => '1117', 'AMT' => '1']]);
////['PARTNER'=>'PayPal','PWD'=>'wood@2016','VENDOR'=>'philliptest','USER'=>'philliptest','TENDER'=>'C','ACCT'=>'4111111111111111 ','TRXTYPE'=>'S','EXPDATE'=>'1117','AMT'=>'1']);
//            parse_str($response->getBody()->getContents(), $output);
//        dd( $output);
        if (Sentinel::getUser()) {
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
        $options = new Collection();

        foreach ($cart as $item) {
            $total += number_format(floatval(preg_replace('/[\$,]/', '', $item->product->price)) * $item->amount, 2, '.', ',');
            if ($item->options) {
                $values = explode(',', $item->options);
                foreach ($values as $value) {
                    $options->add(OptionValue::find($value));
                }
            }
        }
        $shipping = Session::get('shipping')[0];

        return view('frontend.shop.cart', compact('total', 'shipping', 'cart', 'options'));
    }

    public function calcShipping(Request $request, $shipping = null)
    {
        if (Sentinel::getUser()) {
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
        Session::forget('shipping');
        Session::forget('tax');
        if (!$shipping) {
            $rules = [
                'zipcode' => 'required',
                'state'   => 'required',
                'country' => 'required',
            ];

            $validation = Validator::make(Input::all(), $rules);

            if ($validation->fails()) {
                return Redirect::to(getLang().'/cart')->withErrors($validation)->withInput();
            }
        } else {
            $request['zipcode'] = $shipping['to_zip'];
            $request['state'] = $shipping['to_state'];
            $request['country'] = $shipping['to_country'];
        }
        $total_amount = 0;
        foreach ($cart as $item) {
            $total_amount += ($item->product->price * $item->amount);
            $packages[] = ['number' => $item->amount,
                'weight'            => 50,
                'length'            => 6,
                'width'             => 5,
                'height'            => 5,
                'measurement'       => 'LBS', // Currently the UPS API will only allow LBS and KG, default is LBS
                'negotiated_rates'  => true, ];
        }

        $return = Ups::getQuote(
                        Config::get('ups'), [
                    'from_zip'     => Config::get('ups.from_zip'),
                    'from_state'   => Config::get('ups.from_state'), // Optional, may yield a more accurate quote
                    'from_country' => Config::get('ups.from_country'), // Optional, defaults to US
                    'to_zip'       => $request['zipcode'],
                    'to_state'     => $request['state'], // Optional, may yield a more accurate quote
                    'to_country'   => $request['country'], // Optional, defaults to US
                    'packages'     => $packages, // Optional, set true to return negotiated rates from UPS
                        ]
        );

        if (isset($return['03'])) {
            $tax = Tax::where('state', $request['state'])->get()->first();
            if ($tax) {
                //dd($total_amount);
                Session::push('tax', [
                    'state' => $request['state'],
                    'rate'  => ($total_amount * $tax->tax_rate) / 100,
                ]);
            }
            //dd($return);
            Session::push('shipping', [
                'to_zip'     => $request['zipcode'],
                'to_state'   => $request['state'],
                'to_country' => $request['country'],
                'service'    => $return['03']['service'],
                'rate'       => $return['03']['rate'] + (($return['03']['rate'] * Config::get('ups')['shipping_percent']) / 100),
            ]);
        } else {
            //dd(Session::all());
            return Redirect::to(getLang().'/cart')->with([
                        'flash_error' => (isset($return['Error'])) ? $return['Error']['ErrorDescription'] : 'Shipping Not available!',
            ]);
        }
        // dd(Session::all());
        return Redirect::to(getLang().'/cart')->withInput();
    }

    /**
     * @param $product_id
     * @param Request $request
     */
    public function add($product_id, Request $request)
    {
        //dd($product_id);
        $request->quantity = $request->qty;
        // dd(Session::all());
        //dd($product_id, $request->all());
        $pid = Product::findOrFail($product_id)->id;
        // dd($pid);
        if ((Product::find($pid)->quantity - $request->quantity) < 0) {
            FlashAlert()->error('Yikes!', 'The Product Was NOT Successfully Added');

            return Redirect()->back();
        }
        /*
         * Check If the user is a guest , if so store the cart in a session
         */
        if (Sentinel::check() === false) {
            $exists = 0;
            /*
             * Check if the product already exists in the cart, if so increment the quantity
             */
            if (Session::has('cart')) {
                // dd(Session::all());

                foreach (Session::get('cart') as $key => $cart) {
                    if ($cart['product_id'] == $product_id) {

                        //dd($cart['quantity']);
                        if ($request->input('plus')) {
                            $cart['quantity'] += 1;
                        } elseif ($request->input('minus')) {
                            $cart['quantity'] -= 1;
                        }
                        if ($cart['quantity'] <= 0) {
                            $this->remove($product_id);
                        } else {
                            Session::forget('cart.'.$key);
                            if ($request->options) {
                                Session::push('cart', [
                                    'product_id' => $product_id,
                                    'quantity'   => $cart['quantity'],
                                    'options'    => implode(',', $request->options),
                                ]);
                            } else {
                                Session::push('cart', [
                                    'product_id' => $product_id,
                                    'quantity'   => $cart['quantity'],
                                ]);
                            }
                        }
                        $exists = 1;

                        break;
                    }
                }
            }

            /*
             * If the product is not in the cart , add a new one
             */
            if (!$exists) {
                if ($request->options) {
                    Session::push('cart', [
                        'product_id' => $product_id,
                        'quantity'   => $request->quantity,
                        'options'    => implode(',', $request->options),
                    ]);
                } else {
                    Session::push('cart', [
                        'product_id' => $product_id,
                        'quantity'   => $request->quantity,
                    ]);
                }
            }
        }

        /*
         * If the user is logged in , store the cart in the database
         */ else {
            if (count($cart = Cart::whereProduct_idAndUser_id($product_id, Sentinel::getUser()->id)->get())) {
                //  $cart = Cart::where('user_id', Sentinel::getUser()->id)->first();

                foreach ($cart as $crt):
                    //dd();
                    //$request->input('quantity') ? $crt->amount += $request->input('quantity') : $crt->amount += 1;
                    if ($request->input('plus')) {
                        $crt->amount += 1;
                    } elseif ($request->input('minus')) {
                        $crt->amount -= 1;
                    } else {
                        $request->input('quantity') ? $crt->amount += $request->input('quantity') : $crt->amount += 1;
                    }
                if ($crt->amount <= 0) {
                    $this->remove($product_id);
                } else {
                    $crt->save();
                }
                endforeach;
            } else {
                $cart = new Cart();
                //$cart->user_id    = Sentinel::findById(1);
                $cart->user_id = Sentinel::getUser()->id;
                $cart->product_id = $pid;
                if ($request->options) {
                    $cart->options = implode(',', $request->options);
                }
                $request->quantity ? $cart->amount = $request->quantity : $cart->amount = 1;

                if ($cart->amount <= 0) {
                    $cart->amount = 1;
                }
                $cart->save();
            }
        }
        $this->calcShipping($request, Session::get('shipping')[0]);

        return \Redirect()->back()->with([
            'flash_message' => 'Added to Cart !',
        ]);
    }

    /**
     * @param $product_id
     */
    public function remove($product_id)
    {
        if (Sentinel::check()) {
            //            Cart::whereProduct_idAndUser_id($product_id,  $user_id = Sentinel::getUser()->getUserId()->delete());
            Cart::whereProduct_idAndUser_id($product_id, $user_id = Sentinel::getUser()->id)->delete();
        } else {
            foreach (Session::get('cart') as $key => $item) {
                if ($item['product_id'] == $product_id) {
                    Session::forget('cart.'.$key);
                    break;
                }
            }
        }

        return \Redirect()->back()->with([
                    'flash_message' => 'Product Removed From Cart !',
                    'flash-warning' => true,
        ]);
    }

    public function clear()
    {
        if (Sentinel::check()) {
            //Sentinel::getUser()->cart()->delete();
            Cart::whereUser_id($user_id = Sentinel::getUser()->id)->delete();
        } else {
            Session::flush('cart');
        }

        return \Redirect()->back();
    }

    /**
     * @param Request $request
     */
    public function payment(Request $request)
    {
        $userCart = Cart::where('user_id', Sentinel::getUser()->id)->get();
        $id = Sentinel::getUser()->id;
        $total = 0;
        $shipping_amount = $tax_amount = $discount_amount = 0;
        foreach ($userCart as $item) {
            $total += ($item->product->price) * ($item->amount);
        }
        if (Session::has('coupon')) {
            $discount_amount = (($total * Session::get('coupon.discount')) / 100);
            $total = $total - $discount_amount;
        }
        if (Session::has('shipping')) {
            $total = $total + Session::get('shipping.0.rate');
            $shipping_amount = Session::get('shipping.0.rate');
        }
        if (Session::has('tax')) {
            $total = $total + Session::get('tax.0.rate');
            $tax_amount = Session::get('tax.0.rate');
        }

        try {
            $rules = [
                'billing-form-name'         => 'required|min:3',
                'billing-form-lname'        => 'required|min:3',
                'billing-form-address'      => 'required|min:3',
                'billing-form-companyname'  => 'required|min:3',
                'billing-form-city'         => 'required',
                'billing-form-email'        => 'required',
                'billing-form-phone'        => 'required',
                'shipping-form-name'        => 'required|min:3',
                'shipping-form-lname'       => 'required|min:3',
                'shipping-form-address'     => 'required|min:3',
                'shipping-form-companyname' => 'required|min:3',
                'shipping-form-city'        => 'required',
                'shipping-form-email'       => 'required',
                'shipping-form-phone'       => 'required',
                'terms'                     => 'required',
                'cardNumber'                => 'required',
                'cardExpiry'                => 'required',
            ];

            $validation = Validator::make(Input::all(), $rules);

            if ($validation->fails()) {
                return Redirect::to(getLang().'/checkout')->withErrors($validation)->withInput();
            }
            $billing = [
                'first_name'    => Input::get('billing-form-name'),
                'last_name'     => Input::get('billing-form-lname'),
                'address'       => Input::get('billing-form-address'),
                'street'        => Input::get('billing-form-street'),
                'company'       => Input::get('billing-form-companyname'),
                'city'          => Input::get('billing-form-city'),
                'email'         => Input::get('billing-form-email'),
                'phone'         => Input::get('billing-form-phone'),
                'zipcode'       => Input::get('billing-form-zipcode'),
                'country'       => Input::get('billing-form-country'),
                'id'            => Input::get('billing_id'),
                'location_type' => 'billing',
            ];
            $location = Location::updateOrCreate(['id' => Input::get('billing_id')], $billing);

            LocationUser::updateOrCreate(['location_id' => $location->id, 'user_id' => $id]);

            $shipping = [
                'first_name'    => Input::get('shipping-form-name'),
                'last_name'     => Input::get('shipping-form-lname'),
                'address'       => Input::get('shipping-form-address'),
                'street'        => Input::get('shipping-form-street'),
                'company'       => Input::get('shipping-form-companyname'),
                'city'          => Input::get('shipping-form-city'),
                'email'         => Input::get('shipping-form-email'),
                'phone'         => Input::get('shipping-form-phone'),
                'zipcode'       => Input::get('shipping-form-zipcode'),
                'country'       => Input::get('shipping-form-country'),
                'id'            => Input::get('shipping_id'),
                'location_type' => 'shipping',
            ];
            $location = Location::updateOrCreate(['id' => Input::get('shipping_id')], $shipping);

            LocationUser::updateOrCreate(['location_id' => $location->id, 'user_id' => $id]);

            Flash::message('Locations successfully saved');
        } catch (ValidationException $e) {
            return Redirect::to(getLang().'/checkout')->withInput()->withErrors($e->getErrors());
        }
//        $billing = App::make('App\Ecommerce\Billing\BillingInterface');
//        dd();
//        $billing->charge([
//            'email' => Sentinel::getUser()->email,
//            'token' => $request->stripeToken,
//            'amount' => $total
//        ]);
        if (Input::get('paypal-check')) {
            $client = new \GuzzleHttp\Client();
            $acct = Input::get('cardNumber');

            $expiry = preg_replace('/[^0-9]/', '', Input::get('cardExpiry'));
//            dd(round($total,2));
            $response = $client->Request('POST', 'https://pilot-payflowpro.paypal.com', ['form_params' => ['PARTNER' => 'PayPal', 'PWD' => '6428joel', 'VENDOR' => 'suncrest1234', 'USER' => 'suncrest1234',
                    'TENDER'                                                                                         => 'C', 'ACCT' => $acct, 'TRXTYPE' => 'S', 'EXPDATE' => $expiry, 'AMT' => round($total, 2), ]]);

            parse_str($response->getBody()->getContents(), $output);
//dd($output);
              if ($output['RESULT'] == '0' && $output['RESPMSG'] == 'Approved') {
                  $order = Order::create([
                            'user_id'          => Sentinel::getUser()->id,
                            'amount'           => $total,
                            'status'           => 'Processing',
                            'firstname'        => Input::get('shipping-form-name'),
                            'lastname'         => Input::get('shipping-form-lname'),
                            'shipping_address' => Input::get('shipping-form-address'),
                            'shipping_city'    => Input::get('shipping-form-city'),
                            'shipping_zipcode' => Input::get('shipping-form-zipcode'),
                            'shipping_country' => Input::get('shipping-form-country'),
                            'payment_method'   => 'Credit Card',
                            'phone'            => Input::get('shipping-form-phone'),
                            'coupon_id'        => Session::get('coupon.id'),
                            'shipping_amount'  => $shipping_amount,
                            'tax_amount'       => $tax_amount,
                            'discount_amount'  => $discount_amount,
                ]);

                  Session::forget('coupon');

                  foreach ($userCart as $item) {
                      OrderProduct::create([
                        'order_id'   => $order->id,
                        'product_id' => $item->product_id,
                        'amount'     => $item->amount,
                        'options'    => $item->options,
                    ]);

                      $item->product->quantity -= $item->amount;
                      $item->product->save();
                  }

                  $this->clear();

                  return \Redirect(getLang().'/thank-you/'.$order->id)->with([
                            'alert-success' => 'Payment success',
                ]);
              } else {
                  return Redirect(getLang().'/checkout')
                                ->with('flash_error', 'An error occurred while handling your payment.');
              }
            //return Redirect::to(getLang().'/payment/paypal')->withInput();
        }
    }

    public function shipping()
    {
        if (!Sentinel::getUser()->cart->count()) {
            return \Redirect()->back()->with([
                        'flash_message' => 'Your Cart is empty !',
                        'flash-warning' => true,
            ]);
        } else {
            $user = Sentinel::getUser();
            helperFunctions::getCartInfo($cart, $total);

            return view('frontend.account.shipping', compact('total', 'cart', 'user'));
        }
    }

    /**
     * @param Request $request
     */
    public function storeShippingInformation(Request $request)
    {
        $this->validate($request, [
            'firstname' => 'required',
            'lastname'  => 'required',
            'phone'     => 'required',
            'address'   => 'required',
            'city'      => 'required',
            'country'   => 'required',
        ]);
        $user = Sentinel::findUserById();
        Session::put('shipping', $request->except('_token'));
        $userInfo = userInfo::where('user_id', $user()->id);
        $userInfo->update([
            'firstname' => $request->firstname,
            'lastname'  => $request->lastname,
            'address'   => $request->address,
            'city'      => $request->city,
            'country'   => $request->country,
            'zipcode'   => $request->zipcode,
        ]);
        helperFunctions::getCartInfo($cart, $total);
        $publishable_key = Payment::first()->stripe_publishable_key;

        return view('frontend.ecom.payment', compact('total', 'cart', 'publishable_key'));
    }
}
