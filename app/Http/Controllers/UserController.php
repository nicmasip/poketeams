<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon;
use App\Models\User;
use App\Http\Requests\ProfileEditRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserEditRequest;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('verified', ['only' => ['useredit','userupdate']]);
        $this->middleware('admin', ['except' => ['useredit','userupdate']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index', ['users' => User::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create', ['roles' => ['user', 'advanced', 'admin']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        $data = [];
        $data['message'] = 'The user has been created successfully.';
        $data['type'] = 'success';
        
        $user = new User($request->all());
        $user->password = Hash::make($request->input('password'));
        $user->email_verified_at = Carbon\Carbon::now();
        try{
            $user->save();
        } catch(\Exception $e){
            $data['message'] = 'The user has NOT been created.';
            $data['type'] = 'danger';
            return back()->withInput()->with($data);
        }
        return redirect('user')->with($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('user.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('user.edit', ['roles' => ['user', 'advanced', 'admin'], 'user' => $user]);
    }
    
    public function useredit(){
        return view('useredit', ['roles' => ['user', 'advanced', 'admin'], 'user' => auth()->user()]);
    }
    
    public function userupdate(ProfileEditRequest $request){
        if($request->password != null && $request->oldpassword != null){
            $r = Hash::check($request->oldpassword, auth()->user()->password);
            if($r){
                $result = $this->userSave($request, true);
            }
            else{
                return back()->withInput()->withErrors(['oldpassword' => 'The previous password is NOT correct.']);
            }
        }
        elseif($request->password == null && $request->oldpassword == null){
            $result = $this->userSave($request, false);
        }
        else{
            return back()->withInput()->withErrors(['generic' => 'Either all fields must be empty or all must be full.']);
        }
        if($result){
            $data = ['message' => 'Success.'];
        }
        else{
            $data = ['message' => 'Error.'];
        }
        return redirect(url('/home'))->with($data);
    }
    
    private function userSave(Request $request, $isNewPassword){
        $result = true;
        $user = auth()->user();
        $user->name = $request->input('name');
        if($user->email != $request->input('email')){
            $user->email = $request->input('email');
            $user->email_verified_at = null;
        }
        if($isNewPassword){
            $user->password = Hash::make($request->input('password'));
        }
        try{
            $user->save();
            $user->sendEmailVerificationNotification();
        } catch(\Exception $e){
            $result = false;
        }
        return $result;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserEditRequest $request, User $user)
    {
        $data = [];
        $data['message'] = 'The user ' . $user->name . ' has been updated successfully.';
        $data['type'] = 'success';
        if($request->password == null){
            $requestData = $request->except(['password']);
        }
        else{
            $requestData = $request->all();
            $requestData->password = Hash::make($request->input('password'));
        }
        try{
            $user->update($requestData);
        } catch(\Exception $e){
            $data['message'] = 'The user ' . $user->name . ' has NOT been updated.';
            $data['type'] = 'danger';
        }
        return redirect('user')->with($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $data = [];
        $data['message'] = 'The user ' . $user->name . ' has been deleted successfully.';
        $data['type'] = 'success';
        try {
            $user->delete();
        } catch(\Exception $e) {
            $data['message'] = 'The user ' . $user->name . ' has NOT been deleted.';
            $data['type'] = 'danger';
        }
        return redirect('user')->with($data);
    }
}
