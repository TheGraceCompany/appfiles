<?php

/*
 * @author Phillip Madsen
 */

namespace app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Message;
use App\Models\OptionValue;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Page;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Section;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class EcomController extends Controller
{
    public function __construct()
    {

        // $this->middleware('isAdmin');
    }

    //Admin Dashboard

    public function index()
    {
        $timestamps = Order::where('created_at', '>=', Carbon::today()->startOfMonth())->lists('created_at');
        foreach ($timestamps as $key => $timestamp) {
            $format = new Carbon($timestamp);
            $timestamps[$key] = $format->toFormattedDateString();
        }
        $totals = Order::where('created_at', '>=', Carbon::today()->startOfMonth())->lists('amount');
        foreach ($totals as $key => $value) {
            $totals[$key] = round($value, 0, PHP_ROUND_HALF_EVEN);
        }
        $total = 0;
        foreach ($totals as $val) {
            $total += $val;
        }

        return view('backend.ecom.dashboard', compact('timestamps', 'totals', 'total'));
    }

    public function products(Request $request)
    {
        if ($request->sort && $request->orderby) {
            $products = Product::orderBy($request->sort, $request->orderby)->paginate(15);
        } else {
            $products = Product::orderBy('created_at', 'desc')->paginate(15);
        }

        return view('backend.ecom.products.products', compact('products'));
    }

    public function createProduct()
    {
        $categories = Category::all();

        return view('backend.ecom.products.createProduct', compact('categories'));
    }

    public function editProduct($id)
    {
        $product = Product::find($id);
        $categories = Category::all();

        return view('backend.ecom.products.editProduct', compact('product', 'categories'));
    }

    //Categories Area

    public function categories()
    {
        $categories = Category::orderBy('created_at', 'desc')->paginate(15);

        return view('backend.ecom.categories', compact('categories'));
    }

    public function createCategory()
    {
        $sections = Section::all();

        return view('backend.ecom.createCategory', compact('sections'));
    }

    public function editCategory($id)
    {
        $category = Category::find($id);
        $sections = Section::all();

        return view('backend.ecom.editCategory', compact('category', 'sections'));
    }

    //Users Area

    //Sections Area

    public function sections(Request $request)
    {
        if ($request->sort && $request->orderby) {
            $sections = Section::orderBy($request->sort, $request->orderby)->paginate(15);
        } else {
            $sections = Section::orderBy('created_at', 'desc')->paginate(15);
        }

        return view('backend.ecom.sections', compact('sections'));
    }

    public function createSection()
    {
        return view('backend.ecom.createSection');
    }

    public function editSection($id)
    {
        $section = Section::find($id);

        return view('backend.ecom.editSection', compact('section'));
    }

    //Payment Area

    public function payment()
    {
        $payment = Payment::first();

        return view('backend.ecom.payment', compact('payment'));
    }

    public function paymentConfig(Request $request)
    {
        Payment::first()->update($request->all());

        return \Redirect()->back()->with([
            'flash_message' => 'Payment Information Successfully Saved',
        ]);
    }

    //Orders Area

    public function orders(Request $request)
    {
        if ($request->sort && $request->orderby) {
            $orders = Order::orderBy($request->sort, $request->orderby)->paginate(15);
        } else {
            $orders = Order::orderBy('created_at', 'desc')->paginate(15);
        }

        return view('backend.ecom.orders', compact('orders'));
    }

    public function showOrder($id)
    {
        $orderDetails = OrderProduct::where('order_id', $id)->get();
        $order = Order::find($id);
        $order->update(['opened' => 1]);
        $options = new Collection();
        foreach ($orderDetails as $detail) {
            if ($detail->options) {
                $values = explode(',', $detail->options);
                foreach ($values as $value) {
                    $options->add(OptionValue::find($value));
                }
            }
        }

        return view('backend.ecom.showOrder', compact('orderDetails', 'order', 'options'));
    }

    //Messages Area

    public function messages()
    {
        $messages = Message::orderBy('created_at', 'desc')->paginate(15);

        return view('backend.ecom.messages', compact('messages'));
    }

    public function showMessage($id)
    {
        $message = Message::find($id);
        $message->update(['opened' => 1]);

        return view('backend.ecom.showMessage', compact('message'));
    }

    //Pages Builder Area

    public function pages()
    {
        $pages = Page::paginate(15);

        return view('backend.ecom.pages', compact('pages'));
    }

    public function createPage()
    {
        return view('backend.ecom.createPage');
    }

    public function editPage($page_name)
    {
        $page = Page::where('page_name', $page_name)->first();

        return view('backend.ecom.editPage', compact('page'));
    }

    //Coupons Area

    public function coupons()
    {
        $coupons = Coupon::paginate(15);

        return view('backend.ecom.coupons', compact('coupons'));
    }

    public function createCoupon()
    {
        return view('backend.ecom.createCoupon');
    }

    public function editCoupon($id)
    {
        $coupon = Coupon::find($id);

        return view('backend.ecom.editCoupon', compact('coupon'));
    }
}
