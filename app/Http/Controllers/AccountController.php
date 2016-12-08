<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Support\Str;

use Sentinel;
use Cartalyst\Sentinel\Users\EloquentUser;
use App\Models\Role;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{

	protected $redirectTo = '/dashboard';

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data)
	{
		return Validator::make($data, [
			'first_name' => 'required|max:255',
			'last_name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
		]);
	}


<<<<<<< HEAD
=======

	public function dashboard()
	{
		$user = Sentinel::getUser();

		helperFunctions::getCartInfo($cart,$total);
		return view('frontend.account.dashboard', compact('total', 'cart', 'user'));
	}



>>>>>>> b82bc0bdf312fbeb68e9c84864f4ee5b5d6fdd41
	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array $data
	 * @return User
	 */
	protected function create(array $data)
	{


		$user = User::create([

			'first_name' => $data['first_name'],
			'last_name' => $data['last_name'],
			'username' => $data['first_name'] . " " . $data['last_name'],
			'slug' => Str::slug($data['first_name'] . " " . $data['last_name']),
			// 'slug' => str_slug(($data['first_name'] . " " . $data['last_name']), '-'),
			'email' => $data['email'],
			'isAdmin' => 0,
			'password' => bcrypt($data['password']),


		]);

		//$user = Sentinel::findById(1);

		$role = Sentinel::getRoleRepository()->createModel()->create([
			'name' => 'Members',
			'slug' => 'members',
		]);

		$role = Sentinel::findRoleByName('Members');

		$role->users()->attach($user);


		File::makeDirectory(public_path() . "/users/" . $user->username);
		File::makeDirectory(public_path() . "/users/" . $user->username . "/photos/");
		$dest = public_path() . "/users/" . $user->username . "/photos/profile.png";
		$file = public_path() . "/img/profile.png";
		File::copy($file, $dest);

		UserInfo::create([
			"user_id" => $user->id, "photo" => "/users/" . $user->username . "/photos/profile.png",

		]);

		return $user;
	}

<<<<<<< HEAD
	public function getSignin()
	{

		if(!Sentinel::getUser()){

			$this->user = Sentinel::findById();
			$user = $this->user;
			$cart = $user()->cart;
		}else{
			$cart = new Collection;
			if(Session::has('cart')){
				foreach(Session::get('cart') as $item){
					$elem = new Cart;
					$elem->product_id = $item['product_id'];
					$elem->amount = $item['qty'];
					if(isset($item['options'])){
						$elem->options = $item['options'];
					}
					$cart->add($elem);
				}
			}
		}
		$total = 0;
		foreach($cart as $item){
			$total += $item->product->price * $item->amount;
		}
		return view('frontend.auth.signin', compact('total', 'cart'));
	}


	public function getSignup()
	{

		if(!Sentinel::check()){
			$this->user = Sentinel::findById($id);
			$user = $this->user;
			$cart = $user()->cart;
		}else{
			$cart = new Collection;
			if(Session::has('cart')){
				foreach(Session::get('cart') as $item){
					$elem = new Cart;
					$elem->product_id = $item['product_id'];
					$elem->amount = $item['qty'];
					if(isset($item['options'])){
						$elem->options = $item['options'];
					}
					$cart->add($elem);
				}
			}
		}
		$total = 0;
		foreach($cart as $item){
			$total += $item->product->price * $item->amount;
		}
		return view('frontend.auth.signin', compact('cart', 'total'));
	}


	public function moveCartToDB()
	{
		if(Session::has('cart')){
			foreach(Session::get('cart') as $item){
				if(count($cart = Cart::whereProduct_idAndUser_id($item['product_id'], Auth::user()->id)->first())){
					$cart->amount += $item['qty'];
					$cart->save();
				}else{
					$cart = new Cart;
					$cart->user_id = Auth::user()->id;
					$cart->product_id = $item['product_id'];
					$cart->amount = $item['qty'];
					if(isset($item['options'])){
						$cart->options = $item['options'];
					}
					$cart->save();
				}
			}
		}
	}

	protected function handleUserWasAuthenticated(Request $request, $throttles)
	{
		$this->moveCartToDB();
		return redirect()->intended($this->redirectPath());
	}



//	public function postSignup(Request $request)
//	{
//		$validator = $this->validator($request->all());
//
//		if ($validator->fails()) {
//			$this->throwValidationException(
//				$request, $validator
//			);
//		}
//
//		Auth::login($this->create($request->all()));
//		$this->moveCartToDB();
//		return redirect($this->redirectPath());
//	}


	public function postSignup(Request $request)
	{
		$credentials = array(
			'email' => $request->get('email'),
			'password' => $request->get('password'),
		);

		$rememberMe = $request->get('rememberMe');

		try{
			if(!empty($rememberMe)){
				$result = Sentinel::authenticateAndRemember($credentials);
			}else{
				$result = Sentinel::authenticate($credentials);
			}

			if($result){
				$this->moveCartToDB();
				return Redirect::route('frontend.account.dashboard');
			}
		}catch(\Cartalyst\Sentinel\Checkpoints\NotActivatedException $e){
			return Redirect::back()->withErrors($e->getMessage());
		}

		flash()->error('Invalid login or password!');

		return Redirect::back()->withInput();
	}

	/**
	 * Logout action.
	 *
	 * @return Redirect
	 */
	public function getLogout()
	{
		Sentinel::logout(Sentinel::getUser());

		return Redirect::route('admin.login');
	}

	public function getForgotPassword()
	{
		if(!Sentinel::check()){
			return view('backend/auth/forgot-password');
		}

		return Redirect::route('admin.dashboard');
	}

	public function postForgotPassword(Request $request)
	{
		$credentials = array(
			'email' => $request->get('email'),
		);

		$rules = array(
			'email' => 'required|email',
		);

		$validation = Validator::make($credentials, $rules);

		if($validation->fails()){
			return Redirect::back()->withErrors($validation)->withInput();
		}

		// Find the user using the user email address
		$this->user = Sentinel::findByCredentials($credentials);

		if(!$this->user){

			FlashAlert()->error('E-mail address you entered is not found!');
			return Redirect::route('admin.forgot.password');
		}

		$reminderData = Reminder::create($this->user);

		// Get the password reset code
		$resetCode = $reminderData->code;

		$formData = array('userId' => $this->user->id, 'resetCode' => $resetCode);

		try{
			Mail::send('emails.auth.reset-password', $formData, function($message) use ($request){
				$message->from('noreply@graceframe.com', 'Grace');
				$message->to($request->get('email'), 'Lorem Lipsum')->subject('Reset Password');
			});

			return Redirect::route('admin.login');
		}catch(Exception $ex){
			return Redirect::route('admin.forgot.password')->withErrors(array('forgot-password' => 'Password reset failed'));
		}
		/*$mailer = new Mailer;
		$mailer->send('emails.auth.reset-password', 'user@graceframe.com', 'Reset Password', $formData);*/
	}

	public function getResetPassword($id, $code)
	{
		// Find the user using the user id
		$this->user = Sentinel::findById($id);

		if($reminder = Reminder::exists($this->user, $code)){
			flash()->success('Please enter your new password!');

			return view('frontend.auth.reset-password', compact('id', 'code'));
		}else{
			return Redirect::route('admin.login');
		}
	}

	public function postResetPassword(Request $request)
	{
		$formData = array(
			'id' => $request->get('id'),
			'code' => $request->get('code'),
			'password' => $request->get('password'),
			'confirm-password' => $request->get('confirm_password'),
		);

		$rules = array(
			'id' => 'required',
			'code' => 'required',
			'password' => 'required|min:4',
			'confirm-password' => 'required|same:password',
		);

		$validation = Validator::make($formData, $rules);

		if($validation->fails()){
			return Redirect::back()->withErrors($validation)->withInput();
		}

		// Find the user using the user id
		$this->user = Sentinel::findById($formData['id']);

		if($reminder = Reminder::complete($this->user, $formData['code'], $formData['password'])){
			// Password reset passed
			return Redirect::route('auth.signin');
		}else{
			// Password reset failed
			return Redirect::route('account.reset.password')->withErrors(array('forgot-password' => 'Password reset failed'));
		}
	}
=======


>>>>>>> b82bc0bdf312fbeb68e9c84864f4ee5b5d6fdd41


	public function show()
	{

		$user = Sentinel::getUser();
		$user_email = Sentinel::getUser()->email;
		$orders = DB::table('orders')->where('client', $user_email)->get();
		return view('/frontend/account', ['orders' => $orders]);
	}

}
