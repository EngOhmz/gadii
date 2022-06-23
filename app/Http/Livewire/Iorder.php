<?php

namespace App\Http\Livewire;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Product;
use App\Models\User;
use App\Models\Supply;
class Iorder extends Component
{
    //public $user;
    public $supply;
    public $product;
    public $quantity2;
    public $quantity;
    public $products;
    public  $supplier;
    public function render()
    { 
        $user=auth()->user()->id;
        $this->supply=User::find($user)->supply;
        $this->product=User::find($user)->product;
        return view('livewire.iorder');
    }
    public function adddata()
    {
        // $this->validate([
        //     'products' => 'required',
        //     'quantity' => 'required',
        //     'supplier' => 'required'
        // ]);
        $this->quantity=$this->quantity2;
        
    }
}
