<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';
    protected $fillable = [
        'cname',
        'mandatory_id',
        'companyDeclarartion_id',
        'organization',
        'regDate',
        'regNo',
        'employeeNo',

        'regHead',
        'employeeBox',
        'tinNo',
        'phone',


        'contactName',
        'email',
        'personalPhone',
    ];

    public function membership_fees(){
        return $this->hasMany('App\Models\Member\MembershipFee','company_id');
    }
    public function membership_payments(){
        return $this->hasMany('App\Models\Member\MembershipPayment','company_id');
    }

}
