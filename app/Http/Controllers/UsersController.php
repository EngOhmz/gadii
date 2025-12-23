<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\User_Roles;
use App\Models\User_RolesCopy2;
use App\Models\Application;
use App\Models\Region;
use App\Models\Departments;
use App\Models\Designation;
use App\Models\CompanyRoles;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Imports\ImportUser;
use App\Imports\ImportUserDetails;
use App\Imports\CheckJournalEntry ;
use App\Models\Payroll\EmployeePayroll;
use App\Models\UserDetails\BasicDetails;
use App\Models\UserDetails\BankDetails;
use App\Models\UserDetails\SalaryDetails;
use App\Models\Client;
use App\Models\POS\Activity;
use App\Models\Notification;
use Response;
use Session;


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
        
        $users = User::all()->where('added_by',auth()->user()->added_by)->where('id','!=',auth()->user()->added_by);

        return view('manage.users.index',Compact('users'));
    }
    
    public function users_all()
    {
        //
        
        $users = User::all();

        return view('manage.users.all_users',Compact('users'));
    }



    public function update_access(Request $request, $userId)
    {
        // Validate input
        $request->validate([
            'due_date' => 'required|date'
        ]);

        // Get due date from request
        $newDueDate = $request->input('due_date');

        // Find user
        $user = User::find($userId);
        
        if (!$user) {
            return redirect()->route('users_all')->with('error', 'User not found');
        }

        // Update user's due_date
        $user->due_date = $newDueDate;
        $user->save();

        // Get role from User_RolesCopy2
        $userRoleCopy = User_RolesCopy2::where('user_id', $userId)->first();
        
        if (!$userRoleCopy) {
            return redirect()->route('users_all')->with('error', 'User role not found in User_RolesCopy2');
        }

        // Update due_date in User_RolesCopy2
        $userRoleCopy->due_date = $newDueDate;
        $userRoleCopy->save();

        // Check if user_id and role_id exist in User_Roles
        $userRole = User_Roles::where('user_id', $userId)
                            ->where('role_id', $userRoleCopy->role_id)
                            ->first();

        if (!$userRole) {
            User_Roles::create([
                'user_id' => $userId,
                'role_id' => $userRoleCopy->role_id,
                'updated_at' => now()
            ]);
        }
        
        return redirect()->route('users_all')->with('success', 'User access updated successfully');
    }


    public function affiliate_users_all()
    {
        //
        
        // $users = User::all();
        
        $users = User::whereNotNull('affiliate_no')->get();

        return view('manage.users.affiliate_users',Compact('users'));
    }
    
    public function affiliate_users_show($id)
    {
        //
        
        $affiliator = User::find($id);
        
        $affiliator_id = $affiliator->affiliate_no;
        
        
        
        $users = User::where('reference_no', $affiliator_id)->get();

        return view('manage.users.affiliate_users_show',Compact('users', 'affiliator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles = Role::all()->where('disabled','0')->where('status','0')->where('added_by',auth()->user()->added_by);
        //$region = Region::all();
      $department = Departments::all()->where('disabled','0')->where('added_by',auth()->user()->added_by);
        return view('manage.users.add',Compact('roles','department'));
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
            'role' => 'required|string',
            'address' => 'required|max:255|min:3|string',
            'email' => 'required|string|min:3|unique:users', 
            'phone' => 'required|not_in:0|min:9|unique:users',
           // 'password' => 'required|string|min:6|confirmed',
           
          
        ]);
        
        
        //dd($request->all());
        
        $user = User::create([
            'name' => $request['name'],
          
            'email' => $request['email'],
            'address' => $request['address'],
            'password' => Hash::make($request['password']),
            'phone' => $request['phone'],
            'added_by' => auth()->user()->added_by,
            'status' => 1,
            'user_type' => 'customer',
       'department_id' => $request['department_id'],
        'designation_id' => $request['designation_id'],
        'joining_date' => $request['joining_date'],
        ]);
        
        $roles['user_id'] = $user->id;
        $roles['added_by'] = auth()->user()->added_by;
        $roles['role_id'] = $request['role'];
        
        
         foreach(auth()->user()->roles as $value)
         $roles['admin_role'] = $value->id;
                          
        CompanyRoles::create($roles);

        if (!$user) {
          //  return redirect(route('users.index'));
        }

        $user->roles()->attach($request['role']);
        $usr=User::where('id',auth()->user()->id)->first();
        
         $notif = array(
        'name' => 'Add User',
        'description' =>$user->name .' has been created by ' .$usr->name  ,
        'date' =>   date('Y-m-d'),
        'from_user_id' => auth()->user()->id,
        'to_user_id' => $user->id,
        'added_by' => auth()->user()->added_by);
       
        Notification::create($notif);  ;
        
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
        $role = Role::all()->where('disabled','0')->where('status','0')->where('added_by',auth()->user()->added_by);
        $region = Region::all();
        //$user = User::with('Role')->where('id',$id)->get();
        $user = User::all()->where('id',$id);
      $users = User::find($id);
        $department = Departments::all()->where('disabled','0')->where('added_by',auth()->user()->added_by);
     $designation= Designation::where('department_id', $users->department_id)->get();
     $ur=User_Roles::where('user_id',$id)->first();

        return view('manage.users.edit',Compact('user','role','region','department','designation','ur'));
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
        
        //dd($request->all());
        
        $user = User::findOrFail($id);
        $user->name = $request['name'];
        
        $user->email = $request['email'];
        $user->phone = $request['phone'];
        $user->address = $request['address'];
        $user->department_id = $request['department_id'];
        $user->designation_id = $request['designation_id'];
           $user->joining_date = $request['joining_date'];
         $user->added_by = auth()->user()->added_by;
        $user->save();

        if (!$user) {
           
        }
        $user->roles()->detach();
        $user->roles()->attach($request['role']);
        
        $roles['user_id'] = $user->id;
        $roles['added_by'] = auth()->user()->added_by;
        $roles['role_id'] = $request['role'];
        foreach(auth()->user()->roles as $value)
        $roles['admin_role'] = $value->id;
        
        $exist = CompanyRoles::where('user_id',$id)->where('added_by',auth()->user()->id)->get();
        
        if(count($exist) > 0){
            CompanyRoles::where('user_id',$id)->update($roles);
            
            
        }else{
            CompanyRoles::create($roles);
        }
        
         $usr=User::where('id',auth()->user()->id)->first();
        
         $notif = array(
        'name' => 'Edit User',
        'description' =>$user->name .' Details has been edited by ' .$usr->name  ,
        'date' =>   date('Y-m-d'),
        'from_user_id' => auth()->user()->id,
        'to_user_id' => $user->id,
        'added_by' => auth()->user()->added_by);
       
        Notification::create($notif);  ;
        
        
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


public function details($id)
    {
        //
          $type = Session::get('type');
        if(empty($type))
        $type = "basic";

        $basic_details = BasicDetails::where('user_id',$id)->first();
        $bank_details = BankDetails::where('user_id',$id)->first();
        $salary_details = SalaryDetails::where('user_id',$id)->first();
        
         $us = User::where('id',$id)->first();
        
        if($us->added_by == $id){
    $unreadNotifications =  Notification::where('added_by', $us->added_by)->orderBy('created_at','desc')->latest()->get();
                       }
                       
    else{
    $unreadNotifications=  Notification::where('added_by', $us->added_by)->where('from_user_id', $id)
    ->orWhere->where('added_by', $us->added_by)->where('to_user_id', $id)->orderBy('created_at','desc')->get(); 
    
    
                       }
                       
                       
            $user =  User::find($id);
            $user_id=$id;
        return view('user_details.index',compact('type','basic_details','bank_details','salary_details','user','user_id','unreadNotifications'));
    }

   public function user_import(Request $request){
       
       if($request->id == 0){
           
           return view('manage.users.import');
       }
       
         $data = Excel::import(new ImportUser, $request->file('file')->store('files'));
        
        return redirect()->back()->with(['success'=>'File Imported Successfully']);
   }

public function details_import(Request $request){
       
       if($request->id == 0){
           
           return view('manage.users.import_details');
       }
       
         $data = Excel::import(new ImportUserDetails, $request->file('file')->store('files'));
        
        return redirect()->back()->with(['success'=>'File Imported Successfully']);
   }

 public function user_sample(Request $request){
        //return Storage::download('items_sample.xlsx');
        $filepath = public_path('user_sample.xlsx');
        return Response::download($filepath); 
    }

 public function details_sample(Request $request){
        //return Storage::download('items_sample.xlsx');
        $filepath = public_path('user_details_sample.xlsx');
        return Response::download($filepath); 
    }
    
    
    public function save_disable($id)
    {
        //
        $user =  User::find($id);

        $data['disabled_date']=date('Y-m-d');
         $data['disabled']='1';

       $user->update($data);

      $payroll=   EmployeePayroll::where('user_id', $id)->first();
        
if(!empty($payroll)){
$item['disabled']='1';
  $payroll->update($item);
}


      $client=Client::where('member_id', $id)->first();
        
if(!empty($client)){
$activity =Activity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
                             'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Client',
                            'activity'=>"Client " .  $client->name. "  Deleted",
                        ]
                        );                      
       
       $client->update(['disabled'=> '1']);;
}

 $usr=User::where('id',auth()->user()->id)->first();
        
         $notif = array(
        'name' => 'Delete User',
        'description' =>$user->name .' has been disabled by  ' .$usr->name  ,
        'date' =>   date('Y-m-d'),
        'from_user_id' => auth()->user()->id,
        'to_user_id' => $user->id,
        'added_by' => auth()->user()->added_by);
       
        Notification::create($notif);  ;

        return redirect(route('users.index'))->with(['success'=>'User Disabled Successfully']);
    }
    
    
    
    public function mark_as_read($id)
    {
       
    
        $notif =  Notification::find($id);
         $data['read']='1';
         $notif->update($data);
         
            $type = "notification";
       
        return redirect()->back()->with(['success'=>'Notification marked as read','type'=>$type]);
    }


 public function mark_all_as_read()
    {
     
      $countUnreadNotifications = Notification::where('added_by', auth()->user()->added_by)->where('read','0')->count();;
      
      if($countUnreadNotifications > 0){
       
     if(auth()->user()->added_by == auth()->user()->id){
    $notif =  Notification::where('added_by', auth()->user()->added_by)->update(['read' => '1']);
                       }
                       
    else{
    $notif =  Notification::where('added_by', auth()->user()->added_by)->where('from_user_id', auth()->user()->id)->orWhere->where('added_by', auth()->user()->added_by)->where('to_user_id', auth()->user()->id)->update(['read' => '1']); 
                       }
                       
    $type = "notification";
       
        return redirect()->back()->with(['success'=>'Notification marked as read','type'=>$type]);
      }
      
      
      else{
        $type = "notification";  
       return redirect()->back()->with(['success'=>'No unread notifications.','type'=>$type]);   
      }
      
    }

 public function view_all($id)
    {
       
        $type = "notification";


        return redirect(route('user.details',$id))->with(['type'=>$type]);
    }




}
