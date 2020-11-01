<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use App\Models\Role;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserProfile;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('role','profile')->paginate(3);
        return view('admin.users.index')->with('users',$users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $countries = Country::all();
        return view('admin.users.create')->with([
            'roles' => $roles,
            'countries' => $countries,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserProfile $request)
    {
        $path = 'images/profile/no-thimbnail.jpg';
        if($request->has('thumbnail')){
            $extension = ".".$request->thumbnail->getClientOriginalExtension();
            $name = basename($request->thumbnail->getClientOriginalName(),$extension).time();
            $name = $name.$extension;
            $path = $request->thumbnail->storeAs('images/profile',$name);
        }
        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'status' => $request->status,
        ]);
        if($user){
            $profile = Profile::create([
                'user_id' =>$user->id,
                'address'=>$request->address,
                'name'=>$request->name,
                'thumbnail'=>$path,
                'country_id'=> $request->country_id,
                'state_id'=> $request->state_id,
                'city_id'=> $request->city_id,
                'phone'=> $request->phone,
                'slug'=>$request->slug,
            ]);
        }
        if($user && $profile){
            return redirect(route('admin.profile.index'))->with('message','User Created Successfully!!');
        }else{
            return back()->with('message','Error Inserting new User!!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        $roles = Role::all();
        $countries = Country::all();
        $user = User::all();
        return view('admin.users.create')->with([
            'roles' => $roles,
            'countries' => $countries,
            'profile'=>$profile,
            'user'=>$user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
       if( $profile->users()->ForceDelete() && $profile->ForceDelete() ){
           return back()->with('message','User Deleted Successfully!');
       }else{
        return back()->with('message','Error in Deleting a User!');
       }
    }

    public function getStates(Request $request , $id){
        if($request->ajax()){
            return State::where('country_id',$id)->get();
        }else{
            return 0;
        }
    }

    public function getCities(Request $request , $id){
        if($request->ajax()){
            return City::where('state_id',$id)->get();
        }else{
            return 0;
        }
    }
}
