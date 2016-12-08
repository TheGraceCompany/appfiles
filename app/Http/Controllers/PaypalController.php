<?php



namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;
use Illuminate\Http\Request;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Sentinel;
use Session;

class PaypalController extends Controller
{
    private $_api_context;

    public function __construct()
    {
        // $this->middleware('sentinel.auth');
        $config = \App\Models\Payment::first();
        $settings = [
            'mode'                   => 'sandbox',
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled'         => true,
            'log.FileName'           => storage_path().'/logs/paypal.log',
            'log.LogLevel'           => 'FINE',
        ];
        $this->_api_context = new ApiContext(new OAuthTokenCredential($config->paypal_client_id, $config->paypal_secret));
        $this->_api_context->setConfig($settings);
    }

    public function postPayment()
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $items = [];
        $num = 1;
        $total = 0;
        $cart = Cart::where('user_id', Sentinel::getUser()->id)->get();
        foreach ($cart as $item) {
            //dd($item->product->price);
            ${'item_'.$num} = new Item();
            ${'item_'.$num}->setName($item->product->name)
                    ->setCurrency('USD')
                    ->setQuantity($item->amount)
                    ->setPrice($item->product->price);
            $items[] = ${'item_'.$num};
            $num++;
            $total += $item->product->price * $item->amount;
        }

        if (Session::has('shipping')) {
            $rate = Session::get('shipping.0.rate');
            ${'item_'.$num} = new Item();
            ${'item_'.$num}->setName('shipping')
                    ->setCurrency('USD')
                    ->setQuantity(1)
                    ->setPrice($rate);
            $items[] = ${'item_'.$num};
            $total += $rate;
        }
        if (Session::has('tax')) {
            $rate = Session::get('tax.0.rate');
            ${'item_'.$num} = new Item();
            ${'item_'.$num}->setName('tax')
                    ->setCurrency('USD')
                    ->setQuantity(1)
                    ->setPrice($rate);
            $items[] = ${'item_'.$num};
            $total += $rate;
        }

        if (Session::has('coupon')) {
            $discount = (($total * Session::get('coupon.discount')) / 100);
            $total = $total - $discount;
            ${'item_'.$num} = new Item();
            ${'item_'.$num}->setName('discount')
                    ->setCurrency('USD')
                    ->setQuantity(1)
                    ->setPrice(-$discount);
            $items[] = ${'item_'.$num};
        }

        // add item to list
        $item_list = new ItemList();
        $item_list->setItems($items);

        $amount = new Amount();
        $amount->setCurrency('USD')
                ->setTotal($total);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
                ->setItemList($item_list)
                ->setDescription(Sentinel::getUser()->email);

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(route('payment.status')) // Specify return URL
                ->setCancelUrl(route('payment.status'));
        // ->setCancelUrl(route('payment.status'));

        $payment = new Payment();
        $payment->setIntent('Sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirect_urls)
                ->setTransactions([$transaction]);

        try {
            //dd($this->_api_context);
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                echo 'Exception: '.$ex->getMessage().PHP_EOL;
                $err_data = json_decode($ex->getData(), true);
                exit;
            } else {
                die('Some error occur, sorry for inconvenient');
            }
        }

        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        // add payment ID to session
        Session::put('paypal_payment_id', $payment->getId());
        //https://api.sandbox.paypal.com/v1/oauth2/token

        if (isset($redirect_url)) {
            // redirect to paypal
            return Redirect::away($redirect_url);
        }

        return Redirect('/')
                        ->with('error', 'Unknown error occurred');
    }

    public function getPaymentStatus(Request $request)
    {
        // Get the payment ID before session clear
        $payment_id = Session::get('paypal_payment_id');
        // clear the session payment ID
        Session::forget('paypal_payment_id');

        if (empty($request->PayerID) || empty($request->token)) {
            return Redirect(getLang().'/checkout')
                            ->with('flash_error', 'An error occurred while handling your payment.');
        }

        $payment = Payment::get($payment_id, $this->_api_context);

        // PaymentExecution object includes information necessary
        // to execute a PayPal account payment.
        // The payer_id is added to the request query parameters
        // when the user is redirected from paypal back to your site
        $execution = new PaymentExecution();
        $execution->setPayerId($request->PayerID);

        //Execute the payment
        $result = $payment->execute($execution, $this->_api_context);

        // echo '<pre>';print_r($result);echo '</pre>';exit;
        //
        // // DEBUG RESULT, remove it later

        if ($result->getState() == 'approved') {
            // payment made
            $userCart = Cart::where('user_id', Sentinel::getUser()->id)->get();
            $total = 0;
            foreach ($userCart as $item) {
                $total += ($item->product->price) * ($item->amount);
            }
            if (Session::has('coupon')) {
                $total = $total - (($total * Session::get('coupon.discount')) / 100);
            }
            $user = User::find(Sentinel::getUser()->id);
            $userLocation = $user->location;
            $shipping = $userLocation->where('location_type', 'shipping')->first();

            $order = Order::create([
                        'user_id'          => Sentinel::getUser()->id,
                        'amount'           => $total,
                        'status'           => 'Processing',
                        'firstname'        => $shipping->first_name,
                        'lastname'         => $shipping->last_name,
                        'shipping_address' => $shipping->address,
                        'shipping_city'    => $shipping->city,
                        'shipping_zipcode' => $shipping->zipcode,
                        'shipping_country' => $shipping->country,
                        'payment_method'   => 'Paypal',
                        'phone'            => $shipping->phone,
                        'coupon_id'        => Session::get('coupon.id'),
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
        }

        return Redirect()->back()
                        ->with('alert-error', 'Payment failed');
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
}
