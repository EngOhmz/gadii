<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $table = "tbl_purchases";

    protected $fillable = ['reference_no','supplier_id','purchase_date','due_date','user_id','status','purchase_amount','due_amount','purchase_tax','currency_code','exchange_rate'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier','supplier_id');
    }          

   
     public function purchase_items()
    {
        return $this->hasMany('App\Models\Purchase_items','purchase_id');
    }
}
