<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\UserInfo;
use File;
use Flash;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Sentinel;
use Validator;
use View;

/**
 * Class UserController.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'DESC')->paginate(10);

        if ($users) {
            //Get User Roles
            foreach ($users as &$user) {
                $userRoles = $user->getRoles()->lists('name', 'id')->toArray();
                if (count($userRoles) > 0) {
                    $user['roles'] = implode(', ', $userRoles);
                    $user->roles = implode(',<br/>', $userRoles);
                }
            }
        }

        return view('backend.user.index', compact('users'))->with('active', 'user');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $roles = Role::lists('name', 'id');

        return view('backend.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            $user = User::create(Input::all());

            UserInfo::create(array_merge(Input::get('userInfo'), ['user_id' => $user->id]));
            if ($request->hasFile('userInfo')) {
                $dest = 'uploads/users/'.$user->username.'/photos/';
                File::delete(public_path().$user->userInfo->photo);
                $name = str_random(11).'_'.$request->file('userInfo')['photo']->getClientOriginalName();
                $request->file('userInfo')['photo']->move($dest, $name);

                $user->userInfo->where('user_id', $user->id)->update(['photo' => '/'.$dest.$name]);
            }
            $oldRoles = $user->getRoles()->lists('name', 'id')->toArray();

            foreach ($oldRoles as $id => $role) {
                $roleModel = Sentinel::findRoleByName($role);
                $roleModel->users()->detach($user);
            }

            if (Input::get('roles')) {
                foreach (Input::get('roles') as $role => $id) {
                    $role = Sentinel::findRoleByName($role);
                    $role->users()->attach($user);
                }
            }
            Flash::message('User was successfully updated');

            return Redirect::to('admin/user/'.$user->id.'/edit#panel_user_locations');
        } catch (ValidationException $e) {
            return langRedirectRoute('admin.user.edit')->withInput()->withErrors($e->getErrors());
        }
    }

    public function storee(Request $request)
    {
        $formData = [
            'first_name'       => $request->get('first_name'),
            'last_name'        => $request->get('last_name'),
            'username'         => $request->get('first_name').' '.$request->get('last_name'),
            'slug'             => str_slug(($request->get('first_name').' '.$request->get('last_name')), '-'),
            'email'            => $request->get('email'),
            'password'         => $request->get('password'),
            'confirm-password' => $request->get('confirm_password'),
            'roles'            => $request->get('roles'),
            'isAdmin'          => $request->get('isAdmin'),
            'uuid'             => \Uuid::generate(3, $request->get('first_name').$request->get('last_name'), Uuid::NS_DNS),
        ];

        $rules = [
            'first_name'       => 'required|min:3',
            'last_name'        => 'required|min:3',
            'email'            => 'required|email|unique:users,email',
            'password'         => 'required|min:4',
            'confirm-password' => 'required|same:password',
        ];

        $validation = Validator::make($formData, $rules);

        if ($validation->fails()) {
            return Redirect::action('Admin\UserController@create')->withErrors($validation)->withInput();
        }

        $user = Sentinel::registerAndActivate([
            'email'      => $formData['email'],
            'password'   => $formData['password'],
            'first_name' => $formData['first_name'],
            'last_name'  => $formData['last_name'],
            'username'   => $formData['username'],
            'isAdmin'    => $formData['isAdmin'],
            'slug'       => $formData['slug'],
            'activated'  => 1,
        ]);

        if (isset($formData['roles'])) {
            foreach ($formData['roles'] as $role => $id) {
                $role = Sentinel::findRoleByName($role);
                $role->users()->attach($user);
            }
        }

        Flash::message('User was successfully created');

        return langRedirectRoute('admin.user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $user = Sentinel::findUserById($id);
        $userRoles = $user->getRoles()->lists('name', 'id')->toArray();
        if (count($userRoles) > 0) {
            $user['roles'] = implode(', ', $userRoles);
        }

        return view('backend.users.show', compact('user'))->with('active', 'user');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //$user = Sentinel::findUserById($id);
        $user = User::find($id);
        //$user->isAdmin = $request->isAdmin;
        $userInfo = $user->userInfo;
        //    dd($user);
        $userRoles = $user->getRoles()->lists('name', 'id')->toArray();
        $roles = Role::lists('name', 'id');

        return view('backend.user.edit', compact('user', 'roles', 'userRoles', 'userInfo'))->with('active', 'user');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);
            $user->update(Input::all());

            $user->userInfo->update(Input::get('userInfo'));
            if ($request->hasFile('userInfo')) {
                $dest = 'uploads/users/'.$user->username.'/photos/';
                File::delete(public_path().$user->userInfo->photo);
                $name = str_random(11).'_'.$request->file('userInfo')['photo']->getClientOriginalName();
                $request->file('userInfo')['photo']->move($dest, $name);

                $user->userInfo->where('user_id', $user->id)->update(['photo' => '/'.$dest.$name]);
            }
            $oldRoles = $user->getRoles()->lists('name', 'id')->toArray();

            foreach ($oldRoles as $id => $role) {
                $roleModel = Sentinel::findRoleByName($role);
                $roleModel->users()->detach($user);
            }

            if (Input::get('roles')) {
                foreach (Input::get('roles') as $role => $id) {
                    $role = Sentinel::findRoleByName($role);
                    $role->users()->attach($user);
                }
            }
            Flash::message('User was successfully updated');

            return langRedirectRoute('admin.user.index');
        } catch (ValidationException $e) {
            return langRedirectRoute('admin.user.edit')->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $user = Sentinel::findById($id);
        $user->delete();

        Flash::message('User was successfully deleted');

        return langRedirectRoute('admin.user.index');
    }

    public function confirmDestroy($id)
    {
        $user = Sentinel::findById($id);

        return view('backend.user.confirm-destroy', compact('user'))->with('active', 'user');
    }
}
