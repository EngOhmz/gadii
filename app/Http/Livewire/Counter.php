<?php
namespace App\Http\Livewire;
use App\Models\Group;
use App\Models\User;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class Counter extends Component
{
  
    use AuthorizesRequests;
 
    public $name;
    public $value=12;
    public function render()
    {
        $this->group = Group::all();
        return view('livewire.counter');
    }


    public function addgroupd()
    {
        

        $this->value=16;
        // $this->validate([
        //     'name' => 'required|min:5',
            
        // ]);
        // Group::create([
        //     'name' => $this->name,
        //     'email' => $this->email
        // ]);
        // $this->resetInput();
    }
    public function destroy($id)
    {
        if ($id) {
            $record =Mawasiliano::where('id', $id);
            $record->delete();
        }
    }
    
}
