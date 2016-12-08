<?php



namespace app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserInfo;
use Ecommerce\helperFunctions;
use File;
use Illuminate\Http\Request;
use Sentinel;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => [
            'dashboard',
            'editAccount',
            'editInfo',
        ]]);
    }

    public function dashboard()
    {
        $user = Sentinel::getUser();
        helperFunctions::getCartInfo($cart, $total);

        return view('frontend.account.user_account', compact('total', 'cart', 'user'));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|unique:users',
            'password' => 'required|confirmed',
            'email'    => 'required',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'username'   => $request->first_name.' '.$request->last_name,
            'slug'       => str_slug(($request->first_name.' '.$request->last_name), '-'),
            'isAdmin'    => 0,
            'password'   => bcrypt($request->password),
            'email'      => $request->email,
        ]);

        $user->isAdmin = $request->isAdmin;
        $user->save();

        File::makeDirectory(public_path().'/users/'.$user->slug);
        File::makeDirectory(public_path().'/users/'.$user->slug.'/photos/');
        $dest = public_path().'/users/'.$user->slug.'/photos/profile.png';
        $file = public_path().'/img/profile.png';
        File::copy($file, $dest);
        UserInfo::create([
                         'user_id' => $user->id,
                         'photo'   => '/users/'.$user->slug.'/photos/profile.png',
                         ]);

        return \Redirect('/admin/users')->with([
            'flash_message' => 'User Successfully Added !',
        ]);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $user = User::find($id);
        File::deleteDirectory(public_path().'/content/'.$user->username);
        $user->delete();

        return \Redirect('/admin/users')->with([
            'flash_message' => 'User has been Successfully removed',
            'flash-warning' => true,
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, $id)
    {
        $user = User::find($id);
        $user->isAdmin = $request->isAdmin;
        $user->update([
                    'first_name' => $request->first_name,
            'last_name'          => $request->last_name,
            'username'           => $request->first_name.' '.$request->last_name,
            'slug'               => str_slug(($request->first_name.' '.$request->last_name), '-'),
            'email'              => $request->email,
        ]);

        $user->userInfo()->update([
            'photo'              => $request->photo,
            'address'            => $request->address,
            'city'               => $request->city,
            'state'              => $request->state,
            'zipcode'            => $request->zipcode,
            'country'            => $request->country,
            'about_me'           => $request->about_me,
            'website'            => $request->website,
            'company'            => $request->company,
            'gender'             => $request->gender,
            'phone'              => $request->phone,
            'mobile'             => $request->mobile,
            'work'               => $request->work,
            'other'              => $request->other,
            'dob'                => $request->dob,
            'skypeid'            => $request->skypeid,
            'githubid'           => $request->githubid,
            'twitter_username'   => $request->twitter_username,
            'instagram_username' => $request->instagram_username,
            'facebook_username'  => $request->facebook_username,
            'facebook_url'       => $request->facebook_url,
            'linked_in_url'      => $request->linked_in_url,
            'google_plus_url'    => $request->google_plus_url,

            'display_name' => $request->display_name,
        ]);

        FlashAlert()->success('Success!', 'User Successfully Edited');

        return \Redirect()->back();
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editAccount(Request $request)
    {
        $user = Sentinel::getUser();
        $this->validate($request, [
            'photo'        => 'image',
            'new_password' => 'confirmed',
        ]);
        if (\Hash::check($request->old_password, $user->password)) {
            Sentinel::getUser()->update(['password' => bcrypt($request->new_password)]);
        }
        if ($request->hasFile('photo')) {
            $dest = 'users/'.$user->username.'/photos/';
            File::delete(public_path().$user->userInfo->photo);
            $name = str_random(11).'_'.$request->file('photo')->getClientOriginalName();
            $request->file('photo')->move($dest, $name);

            UserInfo::where('user_id', $user->id)->update(['photo' => '/'.$dest.$name]);
        }
        $user->update([
            'email' => $request->email,
        ]);

        return \Redirect()->back();
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editInfo(Request $request)
    {
        UserInfo::where('user_id', Sentinel::getUser()->id)->update($request->except('_token'));

        return \Redirect()->back()->with([
            'flash_message' => 'Successfully saved !',
        ]);
    }
}
