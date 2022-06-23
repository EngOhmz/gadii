<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Manage extends Component

{
    public $fnumber,$lnumber;
    public $result=0;
    public $count = 0;

 

    public function plus()

    {
        
        $this->result=$this->fnumber+$this->lnumber;
       
    }

    public function decrement()



    {

        $this->count--;

    }


    public function render()

    {
        
        return view('livewire.counter');

    }

}