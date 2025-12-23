<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\post;
use Laravel\Sanctum\HasApiTokens;
use App\Permissions\HasPermissionsTrait;

use App\Models\School\StudentSubject;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    
    protected $guarded = ['id','_token'];

/*
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'phone',
        'added_by',
        'status',
        'store_id',
        'user_type',
        'reference_no',
        'affiliate_no',
        'joining_date',
    'disabled_date',
    'disabled',
 'department_id',
'designation_id'
    ];
*/
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function subjects()
    {
        return $this->belongsToMany(StudentSubject::class, 'teacher_subject', 'teacher_id', 'subject_id')
                    ->withTimestamps();
    }
    
    public function posts()
    {
        return $this->hasMany('App\Models\post');
    }
    public function farmer()
    {
        return $this->hasMany('App\Models\Farmer');
    }
    public function group()
    {
        return $this->hasMany('App\Models\Group');
    }
    public function land()
    {
        return $this->hasMany('App\Models\FarmLand');
    }
    public function supply()
    {
        return $this->hasMany('App\Models\Supply');
    }
    public function unit()
    {
        return $this->hasMany('App\Models\Unit');
    }
    public function product()
    {
        return $this->hasMany('App\Models\Product');
    }
    public function orders()
    {
        return $this->hasMany('App\Models\order');
    }
    public function Warehouse()
    {
        return $this->hasMany('App\Models\Warehouse','id');
    }
    
       public function basic_details()
    {
        return $this->hasOne('App\Models\UserDetails\BasicDetails','user_id');
    }

    public function bank_details()
    {
        return $this->hasOne('App\Models\UserDetails\BankDetails','user_id');
    }
    
    public function designation(){
    
        return $this->belongsTo('App\Models\Designation','designation_id');
      }
  public function department(){
    
        return $this->belongsTo('App\Models\Departments','department_id');
      }
    use HasPermissionsTrait; //Import The Trait
}
