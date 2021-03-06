<?php

namespace App\Http\Controllers;

use App\Models\OptionValue;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Sentinel;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('isAdmin', ['only' => [
            'update',
        ]]);
        $this->middleware('sentinel.auth', ['only' => [
            'show',
        ]]);
    }

    public function show($id)
    {
        $orderDetails = OrderProduct::where('order_id', $id)->get();
        $order = Order::find($id);
        $options = new Collection();
        foreach ($orderDetails as $detail) {
            if ($detail->options) {
                $values = explode(',', $detail->options);
                foreach ($values as $value) {
                    $options->add(OptionValue::find($value));
                }
            }
        }

        return view('frontend.account.showOrder', compact('orderDetails', 'order', 'options'));
    }

    public function history()
    {
        //$orderDetails = OrderProduct::where('order_id', $id)->get();
        $orders = Order::where('user_id', Sentinel::getUser()->id)->get();
        foreach ($orders as $key=> $item):
        $orders[$key]['product'] = OrderProduct::where('order_id', $item->id)->get();
        endforeach;

        return view('frontend.account.order-history', compact('orders'));
    }

    public function update(Request $request, $id)
    {
        Order::find($id)->update(['status' => $request->status]);

        return \Redirect()->back()->with([
            'flash_message' => 'Order Status Successfully Updated',
        ]);
    }
}
