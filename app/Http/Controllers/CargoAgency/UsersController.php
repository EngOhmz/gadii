<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Application;
use App\Models\Region;
use App\Models\Departments;
use App\Models\Designation;
use App\Models\CompanyRoles;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
        $users = User::all();

        return view('manage.users.index',Compact('users'));
    }
    
    public function users_all()
    {
        //
        
        $users = User::all();

        return view('manage.users.all_users',Compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles = Role::all();
        //$region = Region::all();
    //   $department = Departments::all();
        return view('manage.users.add',Compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        $validatedData = $request->validate([
        
            'name' => 'required|max:255|min:3|string',
            'email' => 'required|string|min:3|unique:users', 
            'phone' => 'required|not_in:0|min:9',
           // 'password' => 'required|string|min:6|confirmed',
           
          
        ]);
        //
        $user = User::create([
            'name' => $request['name'],
          
            'email' => $request['email'],
            'address' => $request['address'],
            'password' => Hash::make($request['password']),
            'phone' => $request['phone'],
            'added_by' => auth()->user()->id,
            'status' => 1,
            'is_active' => 1,
        ]);
        
        // $roles['user_id'] = $user->id;
        // $roles['added_by'] = auth()->user()->id;
            $role_id = 2;
        
        
        //  foreach(auth()->user()->roles as $value)
        //  $roles['admin_role'] = $value->id;
                          
        // CompanyRoles::create($roles);

        // if (!$user) {
        //   //  return redirect(route('users.index'));
        // }

        $user->roles()->attach($role_id);
        
        return redirect(route('users.index'));
       
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
        $users = User::all();

        return view('manage.users.index2',Compact('users'));
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
        $role = Role::all();
        //$user = User::with('Role')->where('id',$id)->get();
        $user = User::all()->where('id',$id);
      $users = User::find($id);
        return view('manage.users.edit',Compact('user','role'));
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
        $user = User::findOrFail($id);
        $user->name = $request['name'];
        
        $user->email = $request['email'];
        $user->phone = $request['phone'];
        $user->address = $request['address'];
        $user->save();
        
        $role_id = 2;

        if (!$user) {
           
        }
        $user->roles()->detach();
        $user->roles()->attach($role_id);
        
        return redirect(route('users.index'));
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
        $user = User::find($id);
        $user->delete();
        return redirect(route('users.index'));
    }

public function findDepartment(Request $request)
    {

        $district= Designation::where('department_id',$request->id)->get();                                                                                    
               return response()->json($district);

}


}
