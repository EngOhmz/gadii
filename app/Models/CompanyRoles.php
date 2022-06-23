<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyRoles extends Model
{
    protected $table = "company_roles";
    
    protected $fillable = ['user_id','role_id','added_by','admin_role'];

    //  protected $guarded = ['id','_token'];

    //     public function chart()
    // {
    //     return $this->hasOne(ChartOfAccount::class, 'id', 'account_id');
    // }


}
