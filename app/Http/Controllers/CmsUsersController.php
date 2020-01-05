<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Resources\Users as UsersResource;
use App\Http\Requests;
use Illuminate\Http\Request;

class CmsUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get users
        $cmsUsers = User::all();

        // Return collection of users as a resource
        return UsersResource::collection($cmsUsers);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CmsUsers  $cmsUsers
     * @return \Illuminate\Http\Response
     */
    public function show(CmsUsers $cmsUsers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CmsUsers  $cmsUsers
     * @return \Illuminate\Http\Response
     */
    public function edit(CmsUsers $cmsUsers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CmsUsers  $cmsUsers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CmsUsers $cmsUsers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CmsUsers  $cmsUsers
     * @return \Illuminate\Http\Response
     */
    public function destroy(CmsUsers $cmsUsers)
    {
        //
    }
}
