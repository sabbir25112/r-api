<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::limitPaginate();
        return $this->setStatusCode(200)
                    ->setMessage("Users Fetch Successfully")
                    ->setResourceName('users')
                    ->responseWithCollection($users);
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
        if (!auth()->user()->can('user.create')) {
            return $this->responseWithNotAllowed();
        }

        $this->validate($request, [
            'name'          => 'required',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
            'user_type'     => 'required|integer|in:' . implode(',', User::TYPES),
            'merchant_id'   => 'required_if:user_type,==,2|integer|exists:merchants,id' //here 2 for Merchant
        ]);
        try {
            $user = User::create(
                [
                    'name'          => $request->name,
                    'email'         => $request->email,
                    'password'      => bcrypt($request->password),
                    'user_type'     => $request->user_type,
                    'merchant_id'   => $request->merchant_id
                ]);
            return $this->setStatusCode(200)
                        ->setMessage("User Created Successfully")
                        ->setResourceName('user')
                        ->responseWithItem($user);
        } catch (\Exception $exception) {
            return $this->setStatusCode(500)
                        ->setMessage($exception->getMessage())
                        ->responseWithError();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
