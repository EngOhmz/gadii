<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use  App\Models\User_RolesCopy2;
use  App\Models\User_Roles;
use App\Models\Permission;
use App\Models\SystemModule;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{  

    public function index()
    {
        if(auth()->user()->added_by == auth()->user()->id ){
        $roles = Role::all()->where('added_by', auth()->user()->added_by)->where('disabled','0');  
        }
        else{
        $roles = Role::all()->where('user_id', auth()->user()->id)->where('disabled','0');
        }
        $permissions = Permission::all();
        $modules = SystemModule::where('disabled','0')->get();  
        return view('manage.role.index', compact('roles', 'permissions', 'modules'));
    }
    
    
     public function enhacement()
    {
        
        
        
        ;
        
        $added_by = auth()->user()->added_by;
        
        $rowDatampya = "SELECT * FROM `roles` WHERE `status` = 1 AND `id` NOT IN (SELECT `role_id` FROM `user_role_copy2` WHERE `user_id` = '".$added_by."')";
        
        $roles = DB::select($rowDatampya);
        
        // dd($roles);
        
        // $items = DB::table('integration_deposits')->where('user_id',  Auth::user()->id)->select("*")->orderBy('id', 'desc')->select("*")->get();
       
    //   $roles = Role::leftJoin('user_role_copy2', 'roles.id','user_role_copy2.role_id')
    //                       ->where('user_role_copy2.user_id',auth()->user()->id)
    //                       ->where('roles.status','1')
    //                       ->select('roles.*')
    //                           ->get();
                              
        return view('manage.role.enhacement',compact('roles'));
    }

    public function create(Request $request)
    {

        $role = Role::find($request->role_id);
        if($role->added_by == auth()->user()->added_by){
        if (isset($request->permissions)) {
            $role->refreshPermissions($request->permissions);
            
            $this->checking();
        } else {
            $role->permissions()->detach();
        }
        $message = "permission updated successfully";
        $type = "success";
       }else{
           $message = "You dont have permission to perform this action";
           $type = "error";
       }

        return redirect()->back()->with([$type=>$message]);
    }
    
    public function checking()
    {
        $nowDT = Carbon::now();
    
        $usrRoles = User_RolesCopy2::where('user_id', auth()->user()->added_by)->whereDate('due_date', '<', $nowDT)->get();
        
        if($usrRoles->isNotEmpty()){
            
            foreach($usrRoles as $row22){
                
                $usr_rol = User_Roles::where('user_id', $row22->user_id)->where('role_id', $row22->role_id)->first();
                
                if(!empty($usr_rol)){
                    
                    $xyzDD =  User::find($usr_rol->user_id);
                    
                    $expire_role = $row22->role_id;
                    
                    $rolesunder = Role::where('added_by', auth()->user()->added_by)->get();
                    
                    foreach($rolesunder as $underss){
                        
                        $role_id = $underss->id;
                        
                        
                        
                        $query = "UPDATE roles_permissions rp set rp.status = 0 WHERE  rp.role_id = '".$role_id."' and rp.permission_id IN (SELECT permission_id from roles_permissions where roles_permissions.role_id = '".$expire_role."')";
                        $row = DB::insert(DB::raw($query));
                        
                        // dd($row);
       
                        
                    }
                    
                    
                    $ttupdt =  $xyzDD->update(['mobile_status' => 'inactive']);
                    
                    $xyzDD->roles()->detach($usr_rol->role_id);
                    
                    // dd($expire_role);
                }
                
                
                
            }
            
            // $countUr = User_Roles::where('user_id', auth()->user()->added_by)->count();
            
            
            
        }
    }

    public function store(Request $request)
    {
        $role = Role::create([
            'slug' => str_replace(' ', '-', $request->slug),
            'added_by'=>auth()->user()->added_by,
             'user_id'=>auth()->user()->id,
            
        ]);
        return redirect(route('roles.index'));
    }

    public function show($id)
    {
        $role = Role::find($id);
        $permissions = Permission::orderBy('hidden','asc')->get();
       $modules = SystemModule::where('disabled','0')->get();  
         //$modules = Permission::groupBy('sys_module_id')->get(); 
        // dd($modules);
        
         $md = SystemModule::where('disabled','0')->get(); 
         
          foreach($md as $mo){
         foreach($permissions as $permission){
        $x = $permission->slug;
         if( Gate::check($x) || auth()->user()->id == 1){
          $a = $permission->sys_module_id ;
          $m = $mo->slug; 
          if( $a == $mo->id || auth()->user()->id == 1){
            $b[]= $mo->id;  
          }
        
         }
        
         }
         
          }
          
          
        return view('manage.role.assign', compact('permissions', 'modules', 'role','b'));
    }

    public function edit(Request $request)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($request->id);

        $role->slug = str_replace(' ', '-', $request->slug);
        $role->save();
        return redirect(route('roles.index'));
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        $role->update(['disabled'=> '1']);
        return redirect(route('roles.index'));
    }
    
    
     public function view()
    {
        $first=Role::where('status',1)->orderBy('slug','asc')->first();
        $prev=Role::where('status',1)->orderBy('slug','desc')->first();
        $last=Role::where('status',1)->orderBy('slug','desc')->skip(1)->take(1)->first();
        $role = Role::where('status',1)->orderBy('slug','asc')->whereNotIn('id', [$first->id, $prev->id, $last->id])->get();
        return view('manage.role.view', compact('role','first','prev','last'));
        
      //   
    }
    
    
}
