<?php

namespace App\Models\Bar;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bar extends Model
{
    use HasFactory;

    
    
    protected $table       = 'bars';
    protected $guarded     = ['id','_token'];
   
  

    public function cuisines()
    {
        return $this->belongsToMany(Cuisine::class, 'restaurant_cuisines');
    }

   

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function place()
    {
        return $this->belongsTo('App\Models\Inventory\Location','location');
   
    }


   
    public function qrCode()
    {
        return $this->hasOne(QrCode::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
