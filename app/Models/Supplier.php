<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    
    protected $table = 'suppliers';
    
    protected $guarded = ['id'];

    // protected $fillable = ['user_id','name','address','phone','TIN','VAT','email'];
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function purchase()
    {
        return $this->hasMany('App\Models\Purchase','id');
    }
    
    public function shipments()
    {
        return $this->hasMany(\App\Models\Cf\ShipmentPlanning::class, 'supplier_id', 'id');
    }
    
}