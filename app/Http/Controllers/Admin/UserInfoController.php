<?php

/*
 * @author Phillip Madsen
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserInfo;
use Flash;
use Illuminate\Support\Str;
use Input;
use Redirect;
use Validator;
use View;

/**
 * Class UserInfoController.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class UserInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $roles = UserInfo::orderBy('created_at', 'DESC')->paginate(10);

        return view('backend.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $permissions = [];

        foreach (Input::get('permissions') as $k => $v) {
            $permissions[$k] = ($v == '1') ? true : false;
        }

        $formData = [
            'slug'        => Str::slug(Input::get('name')),
            'name'        => Input::get('name'),
            'permissions' => $permissions,
        ];

        $rules = [
            'name' => 'required|min:3',
        ];

        $validation = Validator::make($formData, $rules);

        if ($validation->fails()) {
            return Redirect::action('Admin\UserInfosController@create')->withErrors($validation)->withInput();
        }

        UserInfo::create($formData);
        Flash::message('UserInfo was successfully added');

        return Redirect::action('Admin\UserInfoController@index');
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
        $role = UserInfo::find($id);

        return view('backend.role.show', compact('role'));
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
        $role = UserInfo::find($id);

        return view('backend.role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update($id)
    {
        $permissions = [];

        foreach (Input::get('permissions') as $k => $v) {
            $permissions[$k] = ($v == '1') ? true : false;
        }

        $formData = [
            'slug'        => Str::slug(Input::get('name')),
            'name'        => Input::get('name'),
            'permissions' => $permissions,
        ];

        $role = UserInfo::find($id);
        $role->slug = $formData['slug'];
        $role->name = $formData['name'];
        $role->permissions = $permissions;

        $role->save();

        Flash::message('UserInfo was successfully updated');

        return Redirect::action('App\Controllers\Admin\UserInfoController@index');
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
        $role = UserInfo::find($id);
        $role->delete();

        Flash::message('UserInfo was successfully deleted');

        return Redirect::action('App\Controllers\Admin\UserInfoController@index');
    }

    /**
     * @param $id
     *
     * @return View
     */
    public function confirmDestroy($id)
    {
        $role = UserInfo::find($id);

        return view('backend.role.confirm-destroy', compact('role'));
    }
}
