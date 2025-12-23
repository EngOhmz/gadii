<?php


namespace App\Permissions;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

trait HasPermissionsTrait {

 
    public function hasRole(...$roles)
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('slug', $role)) {
                return true;
            }
        }
        return false;
    }

    public function giveRole(...$role)
    {
       // $roles = $this->getRoles(array_flatten($role));
        $roles = $this->getRoles(($role))->flatten();
        if (count($roles) < 1) {
            return false;
        }
        $this->roles()->saveMany($roles);
        return true;
    }

    public function getRoles(array $roles)
    {
        return $this->roles->whereIn('slug', $roles);
    }

    // Getting all

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    /**
     * Checks if User has access to $permissions.
     * @param $permission
     * @return bool
     */

    public function hasModuleTo($module)
    {
        if ($module == '' || $module == null) {
            return false;
        }
        // foreach($this->roles()->get() as $row){
            
        //     //dd($row->permissions->contains('modules.slug', $module->slug));
        //     //dd($row->permissions);
            
            
        //     if (!$row->permissions->contains('modules.slug', $module->slug)) {
        //         return false;
        //     }
            
        // }
        if (!$this->roles()->first()->permissions->contains('modules.slug', $module->slug)) {
            return false;
        }
        return  true;
    }
    
   public function givePermissionsTo(... $permissions) {

    $permissions = $this->getAllPermissions($permissions);
    // dd($permissions);
    if($permissions === null) {
      return $this;
    }
    $this->permissions()->saveMany($permissions);
    return $this;
  }

  public function withdrawPermissionsTo( ... $permissions ) {

    $permissions = $this->getAllPermissions($permissions);
    $this->permissions()->detach($permissions);
    return $this;

  }

  public function refreshPermissions( ... $permissions ) {

    $this->permissions()->detach();
    return $this->givePermissionsTo($permissions);
  }

  public function hasPermissionTo($permission) {
      
     
    
    
    $permission_id = $permission->id;
    $user_id = auth()->user()->id;
    $query =  " SELECT rp.* from roles_permissions rp,users_roles ur where rp.role_id = ur.role_id and ur.user_id = '".$user_id."' and rp.permission_id  = '".$permission_id."' and rp.status = 1";
    $row = DB::select(DB::raw($query));
    
    //  dd($row);
    if(count($row) > 0){
        // return true;
        return $this->hasPermissionThroughRole($permission);
    }else{
        return false;
    }

    
  
    
  }

  public function hasPermissionThroughRole($permission) {

    foreach ($permission->roles as $role){
      if($this->roles->contains($role)) {
        return true;
      }
    }
    return false;
  }

  public function permissions() {
      

    return $this->belongsToMany(Permission::class,'users_permissions');

  }
  protected function hasPermission($permission) {

    return (bool) $this->permissions->where('slug', $permission->slug)->count();
  }

  protected function getAllPermissions(array $permissions) {

    return Permission::whereIn('slug',$permissions)->get();
    
  }


}