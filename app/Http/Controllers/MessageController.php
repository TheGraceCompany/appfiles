<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Section;
use App\Models\Cart;
use Auth;
use Session;
use \Illuminate\Database\Eloquent\Collection;
use \Ecommerce\helperFunctions;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('isAdmin', ['only' => [
            'delete',
        ]]);
    }

    public function show()
    {
        helperFunctions::getCartInfo($cart,$total);
        return view('site.contact', compact('total', 'cart'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required'
        ]);
        $message = $request->all();
        $message['user_id'] = Auth::user()->id;
        Message::create($message);
        return \Redirect('/dashboard')->with([
            'alert-success' => 'Message Successfully Sent !'
        ]);
    }

    public function delete($id)
    {
        Message::destroy($id);
        return \Redirect('/admin/messages');
    }
}
