<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Barangay;
use App\Http\Requests\UserRequest;
use App\Transformers\UserTransformer;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if($user->role != "admin"){
            abort(404);
        }
        $user = User::with('barangay')->orderBy('created_at','desc')->get();
        return [
            'users' => fractal($user, new UserTransformer)->parseIncludes('barangay')->toArray()
        ];
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
    public function store(UserRequest $request)
    {
        if($request->position == "LGU Municipality Staff"){
            $barangay = Barangay::where("city_psgc", $request->city)->first();
            $barangay_id = $barangay->id;
        }else{
            $barangay_id = $request->barangay_id;
        }
        User::create([
            'name' => $request->name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'position' => $request->position,
            'barangay_id' => $barangay_id,
            'username' => $request->username,
            'role' => 'user',
            'password' => bcrypt($request->password),
            'confirmed' => false,
        ]);
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
    public function update(UserRequest $request, $id)
    {
        if($request->change_password){
            $data = $request->all();
            $data['password'] = bcrypt($data['password']);
        }else{
            $data = $request->except(['password']);
        }
        if($data['position'] == "Field Staff"){
            $data['barangay_id'] = null;
        }
        User::find($id)->update($data);
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

    public function activeStatus(User $userModel, $id)
    {
        $user = $userModel->find($id);
        if($user->confirmed == 0){
            $is_active = 1;
        }else{
            $is_active = 0;
            $user->AauthAcessToken()->delete();
        }
        $user->update([
            'confirmed' => $is_active
        ]);

        return $user;
    }

    public function roleStatus(User $userModel, $id)
    {
        $user = $userModel->find($id);
        if($user->role == "admin"){
            $role = "user";
        }else{
            $role = "admin";
        }
        $user->update([
            'role' => $role
        ]);

        return $user;
    }
}
