<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Order;
use Auth;
use Illuminate\Http\Request;
use Session;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('isAdmin', ['only' => [
            'store',
            'delete',
            'edit',
        ]]);
        $this->middleware('sentinel.auth', ['only' => [
            'apply',
        ]]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required',
            'discount' => 'required|max:100',
            'uses'     => 'required',
        ]);
        Coupon::create($request->all());

        return \Redirect('/admin/coupons')->with([
            'flash_message' => 'Coupon Successfully Created',
        ]);
    }

    public function edit(Request $request, $id)
    {
        $this->validate($request, [
            'name'     => 'required',
            'discount' => 'required|max:100',
            'uses'     => 'required',
        ]);
        Coupon::find($id)->update($request->all());

        return \Redirect()->back()->with([
            'flash_message' => 'Coupon Successfully Updated',
        ]);
    }

    public function delete($id)
    {
        Coupon::destroy($id);

        return \Redirect()->back()->with([
            'flash_message' => 'Coupon has been Successfully removed',
            'flash-warning' => true,
        ]);
    }

    public function apply(Request $request)
    {
        Session::forget('coupon');
        $coupon = Coupon::where('name', $request->coupon)->first();

        if ($coupon != null) {
            $coupon = $coupon->toArray();
            if (Order::where('coupon_id', $coupon['id'])->get()->count() < $coupon['uses']) {
                Session::put('coupon', $coupon);

                return \Redirect()->back()->with([
                    'flash_message' => 'Coupon Applied',
                ])->withInput();
            } else {
                return \Redirect()->back()->with([
                    'flash_message' => 'Maximum Usage Exceeded',
                    'flash-warning' => true,
                ]);
            }
        } else {
            return \Redirect()->back()->with([
                'flash_message' => 'Invalid Coupon Code',
                'flash-warning' => true,
            ]);
        }
    }
}
