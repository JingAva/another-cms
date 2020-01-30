<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Resources\Users as UsersResource;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
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
        // $cmsUsers = User::all();

        $cmsUsers = DB::table('users')
            ->join('cms_user_groups', 'users.access_id', '=', 'cms_user_groups.access_id')
            ->select('users.*', 'cms_user_groups.access_name')
            ->get();

        // Return collection of users as a resource
        // return UsersResource::collection($cmsUsers);
        return $cmsUsers;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->access_id = $request->access_id;
        $user->status = $request->status;
        $user->password = $request->password;

        $user->save();

        $cmsUsers = DB::table('users')
            ->join('cms_user_groups', 'users.access_id', '=', 'cms_user_groups.access_id')
            ->select('users.*', 'cms_user_groups.access_name')
            ->where('users.id', $user['id'])
            ->get();

        return $cmsUsers;
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
     * @param  $userId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $userId)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CmsUsers  $cmsUsers
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId)
    {
        //
        DB::table("users")->delete($userId);

    }
}
