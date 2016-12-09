<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Sentinel;

class AccountController extends Controller
{
    protected $redirectTo = '/dashboard';

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name'  => 'required|max:255',
            'email'      => 'required|email|max:255|unique:users',
            'password'   => 'required|confirmed|min:6',
        ]);
    }

    public function dashboard()
    {
        $user = Sentinel::getUser();

        helperFunctions::getCartInfo($cart, $total);

        return view('frontend.account.dashboard', compact('total', 'cart', 'user'));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([

            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'username'   => $data['first_name'].' '.$data['last_name'],
            'slug'       => Str::slug($data['first_name'].' '.$data['last_name']),
            // 'slug' => str_slug(($data['first_name'] . " " . $data['last_name']), '-'),
            'email'    => $data['email'],
            'isAdmin'  => 0,
            'password' => bcrypt($data['password']),

        ]);

        //$user = Sentinel::findById(1);

        $role = Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Members',
            'slug' => 'members',
        ]);

        $role = Sentinel::findRoleByName('Members');

        $role->users()->attach($user);

        File::makeDirectory(public_path().'/users/'.$user->username);
        File::makeDirectory(public_path().'/users/'.$user->username.'/photos/');
        $dest = public_path().'/users/'.$user->username.'/photos/profile.png';
        $file = public_path().'/img/profile.png';
        File::copy($file, $dest);

        UserInfo::create([
            'user_id' => $user->id, 'photo' => '/users/'.$user->username.'/photos/profile.png',

        ]);

        return $user;
    }

    public function show()
    {
        $user = Sentinel::getUser();
        $user_email = Sentinel::getUser()->email;
        $orders = DB::table('orders')->where('client', $user_email)->get();

        return view('/frontend/account', ['orders' => $orders]);
    }
}
