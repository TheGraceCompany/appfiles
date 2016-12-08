<?php

namespace App\Http\Controllers;

use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Illuminate\Http\Request;
use Lang;
use Mail;
use Redirect;
use Reminder;
use Sentinel;
use URL;
use Validator;
use View;
use Session;
use \Ecommerce\helperFunctions;
<<<<<<< HEAD
<<<<<<< HEAD
use App\Http\Controllers\CartController;
=======
>>>>>>> 3ca5f53dc8a62f4d5afc4db6692f6df4569cb0f3
=======
use App\Http\Controllers\CartController;
>>>>>>> a89cdcfcadf0e0d3342e49c36e4bfa850e185a22
use App\Models\User;
use App\Models\UserInfo;
use App\Models\Cart;
use Auth;

class AuthController extends Controller {

    /**
     * Account sign in.
     *
     * @return View
     */
    public function getSignin(Request $request) {
        $user = Auth::user();
        $userinfo = NULL;
        // Is the user logged in?
        if (Sentinel::check()) {
            return Redirect::route('dashboard');
        }
        $redirect = $request->redirect;
        helperFunctions::getCartInfo($cart, $total);
        return view('frontend/auth/signin-signup', compact('page', 'cart', 'total', 'user', 'userinfo', 'redirect'));
    }

    /**
     * Account sign in form processing.
     * @param Request $request
     * @return Redirect
     */
    public function postSignin(Request $request) {
        $cart_old = Session::get('cart');

        try {
            // Try to log the user in
            if (Sentinel::authenticate($request->only(['email', 'password']), $request->get('remember-me', false))) {
                // Session::put('cart', $cart);
<<<<<<< HEAD
<<<<<<< HEAD
                //$request->qty=1;
                //dd($request->qty);
                if (Session::has('cart')) {
                    // dd(Session::all());
                    foreach ($cart_old as $crt):
                       // dd($crt);
                        $cart =new CartController;
                        $request->qty=$crt['quantity'];
                        $cart->add($crt['product_id'],$request);
                        
=======
=======
                //$request->qty=1;
                //dd($request->qty);
>>>>>>> a89cdcfcadf0e0d3342e49c36e4bfa850e185a22
                if (Session::has('cart')) {
                    // dd(Session::all());
                    foreach ($cart_old as $crt):
                       // dd($crt);
                        $cart =new CartController;
                        $request->qty=$crt['quantity'];
                        $cart->add($crt['product_id'],$request);
                        
<<<<<<< HEAD
                        $cart->amount = $crt['quantity'];

                        $cart->save();

>>>>>>> 3ca5f53dc8a62f4d5afc4db6692f6df4569cb0f3
=======
>>>>>>> a89cdcfcadf0e0d3342e49c36e4bfa850e185a22
                    endforeach;
                }

                if ($request->redirect) {
                    return Redirect::route("checkout");
                } else {
                    // Redirect to the dashboard page
                    return Redirect::route("dashboard")->with('success', Lang::get('auth/message.signin.success'));
                }
            }

            $this->messageBag->add('email', Lang::get('auth/message.account_not_found'));
        } catch (NotActivatedException $e) {
            $this->messageBag->add('email', Lang::get('auth/message.account_not_activated'));
        } catch (ThrottlingException $e) {
            $delay = $e->getDelay();
            $this->messageBag->add('email', Lang::get('auth/message.account_suspended', compact('delay')));
        }

        // Ooops.. something went wrong
        return back()->withInput()->withErrors($this->messageBag);
    }

    /**
     * Account sign up form processing.
     *
     * @return Redirect
     */
    public function postSignup(Request $request) {
        // Declare the rules for the form validation
        $rules = array(
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'email_confirm' => 'required|email|same:email',
            'password' => 'required|between:3,32',
            'password_confirm' => 'required|same:password',
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make($request->all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::to(URL::previous() . '#toregister')->withInput()->withErrors($validator);
        }

        try {
            // Register the user
            $user = Sentinel::registerAndActivate(array(
                        'first_name' => $request->get('first_name'),
                        'last_name' => $request->get('last_name'),
                        'username' => $request->get('first_name') . " " . $request->get('last_name'),
                        'slug' => Str::slug($request->get('first_name') . " " . $request->get('last_name'), '-'),
                        'isAdmin' => 0,
                        'email' => $request->get('email'),
                        'password' => $request->get('password')
            ));

            //add user to 'User' group
            $role = Sentinel::findRoleById(2);
            $role->users()->attach($user);


            /*
              //un-comment below code incase if user have to activate manually

              // Data to be used on the email view
              $data = array(
              'user'          => $user,
              'activationUrl' => URL::route('activate', $user->getActivationCode()),
              );

              // Send the activation code through email
              Mail::send('emails.register-activate', $data, function ($m) use ($user) {
              $m->to($user->email, $user->first_name . ' ' . $user->last_name);
              $m->subject('Welcome ' . $user->first_name);
              });

              //Redirect to login page
              return Redirect::to("admin/login")->with('success', Lang::get('auth/message.signup.success'));

             */

            // login user automatically
            // Log the user in
            Sentinel::login($user, false);

            // Redirect to the home page with success menu
            return Redirect::route("account.dashboard")->with('success', Lang::get('auth/message.signup.success'));
        } catch (UserExistsException $e) {
            $this->messageBag->add('email', Lang::get('auth/message.account_already_exists'));
        }

        // Ooops.. something went wrong
        return Redirect::back()->withInput()->withErrors($this->messageBag);
    }

    /**
     * User account activation page.
     *
     * @param number $userId
     * @param string $activationCode
     * @return
     */
    public function getActivate($userId, $activationCode = null) {
        // Is user logged in?
        if (Sentinel::check()) {
            return Redirect::route('dashboard');
        }

        $user = Sentinel::findById($userId);
        $activation = Activation::create($user);

        if (Activation::complete($user, $activation->code)) {
            // Activation was successful
            // Redirect to the login page
            return Redirect::route('signin')->with('success', Lang::get('auth/message.activate.success'));
        } else {
            // Activation not found or not completed.
            $error = Lang::get('auth/message.activate.error');
            return Redirect::route('signin')->with('error', $error);
        }
    }

    /**
     * Forgot password form processing page.
     * @param Request $request
     *
     * @return Redirect
     */
    public function postForgotPassword(Request $request) {
        // Declare the rules for the validator
        $rules = array(
            'email' => 'required|email',
        );

        // Create a new validator instance from our dynamic rules
        $validator = Validator::make($request->all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::to(URL::previous() . '#toforgot')->withInput()->withErrors($validator);
        }

        try {
            // Get the user password recovery code
            $user = Sentinel::findByCredentials(['email' => $request->get('email')]);

            if (!$user) {
                return Redirect::route('forgot-password')->with('error', Lang::get('auth/message.account_not_found'));
            }
            $activation = Activation::completed($user);
            if (!$activation) {
                return Redirect::route('forgot-password')->with('error', Lang::get('auth/message.account_not_activated'));
            }
            $reminder = Reminder::exists($user) ? : Reminder::create($user);
            // Data to be used on the email view
            $data = array(
                'user' => $user,
                //'forgotPasswordUrl' => URL::route('forgot-password-confirm', $user->getResetPasswordCode()),
                'forgotPasswordUrl' => URL::route('forgot-password-confirm', [$user->id, $reminder->code]),
            );

            // Send the activation code through email
            Mail::send('emails.forgot-password', $data, function ($m) use ($user) {
                $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                $m->subject('Account Password Recovery');
            });
        } catch (UserNotFoundException $e) {
            // Even though the email was not found, we will pretend
            // we have sent the password reset code through email,
            // this is a security measure against hackers.
        }

        //  Redirect to the forgot password
        return Redirect::to(URL::previous() . '#toforgot')->with('success', Lang::get('auth/message.forgot-password.success'));
    }

    /**
     * Forgot Password Confirmation page.
     *
     * @param number $userId
     * @param  string $passwordResetCode
     * @return View
     */
    public function getForgotPasswordConfirm($userId, $passwordResetCode = null) {
        // Find the user using the password reset code
        if (!$user = Sentinel::findById($userId)) {
            // Redirect to the forgot password page
            return Redirect::route('forgot-password')->with('error', Lang::get('auth/message.account_not_found'));
        }

        if ($reminder = Reminder::exists($user)) {
            if ($passwordResetCode == $reminder->code) {
                return View('admin.auth.forgot-password-confirm');
            } else {
                return 'code does not match';
            }
        } else {
            return 'does not exists';
        }

        // Show the page
        // return View('admin.auth.forgot-password-confirm');
    }

    /**
     * Forgot Password Confirmation form processing page.
     *
     * @param Request $request
     * @param number $userId
     * @param  string   $passwordResetCode
     * @return Redirect
     */
    public function postForgotPasswordConfirm(Request $request, $userId, $passwordResetCode = null) {
        // Declare the rules for the form validation
        $rules = array(
            'password' => 'required|between:3,32',
            'password_confirm' => 'required|same:password'
        );

        // Create a new validator instance from our dynamic rules
        $validator = Validator::make($request->all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::route('forgot-password-confirm', $passwordResetCode)->withInput()->withErrors($validator);
        }

        // Find the user using the password reset code
        $user = Sentinel::findById($userId);
        if (!$reminder = Reminder::complete($user, $passwordResetCode, $request->get('password'))) {
            // Ooops.. something went wrong
            return Redirect::route('signin')->with('error', Lang::get('auth/message.forgot-password-confirm.error'));
        }

        // Password successfully reseted
        return Redirect::route('signin')->with('success', Lang::get('auth/message.forgot-password-confirm.success'));
    }

    /**
     * Logout page.
     *
     * @return Redirect
     */
    public function getLogout() {
        // Log the user out
        Sentinel::logout();

        // Redirect to the users page
        return Redirect::to('admin/signin')->with('success', 'You have successfully logged out!');
    }

    /**
     * Account sign up form processing for signup page
     *
     * @param Request $request
     *
     * @return Redirect
     */
}