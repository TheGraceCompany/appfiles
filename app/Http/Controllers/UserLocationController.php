<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Input;
use Redirect;
use Flash;
use App\Models\Location;
use App\Models\LocationUser;

class UserLocationController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request) {
        try {
            $rules = array(
                'nickname' => 'required|min:3',
                'street' => 'required|min:3',
                'city' => 'required',
                'country' => 'required',
                'zipcode' => 'required',
            );

            $validation = Validator::make(Input::all(), $rules);

            if ($validation->fails()) {
                return Redirect::to('admin/user/' . $id . '/edit#panel_user_locations')->withErrors($validation)->withInput();
            }
            
            $location = Location::updateOrCreate(array('id'=>Input::get('id')) ,Input::except('_method', '_token'));

            LocationUser::updateOrCreate(array('location_id' => $location->id, 'user_id' => $id));


            Flash::message('Locations successfully saved');

            return Redirect::to('admin/user/' . $id . '/edit#panel_user_locations');
        } catch (ValidationException $e) {
            return langRedirectRoute('admin.user.edit')->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
