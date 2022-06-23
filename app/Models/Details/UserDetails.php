<?php

namespace App\Models\Details;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;

    protected $table = "tbl_user_details";

    protected $fillable = ['added_by','company_name','location','company_email','tin','website','logo'];

}
