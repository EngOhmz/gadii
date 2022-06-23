<?php

namespace App\Http\Livewire;
use App\Models\Mawasiliano;
use Livewire\Component;
//use App\Models\Contact;


class Contact extends Component
{
    public $data, $name, $email, $selected_id;
    public $updateMode = false;
    public $value=0;

    public function render()
    {
        $this->data = Mawasiliano::all();
        return view('livewire.contact');
    }
    private function resetInput()
    {
        $this->name = null;
        $this->email = null;
    }
    public function store()
    {
        $this->validate([
            'name' => 'required|min:5',
            'email' => 'required|email'
        ]);
        Mawasiliano::create([
            'name' => $this->name,
            'email' => $this->email
        ]);
        $this->resetInput();
    }
    public function edit($id)
    {
        $record = Mawasiliano::findOrFail($id);
        $this->selected_id = $id;
        $this->name = $record->name;
        $this->email = $record->email;
        $this->updateMode = true;
    }
    public function update()
    {
        $this->validate([
            'selected_id' => 'required|numeric',
            'name' => 'required|min:5',
            'email' => 'required|email:rfc,dns'
        ]);
        if ($this->selected_id) {
            $record = Mawasiliano::find($this->selected_id);
            $record->update([
                'name' => $this->name,
                'email' => $this->email
            ]);
            $this->resetInput();
            $this->updateMode = false;
        }
    }
    public function destroy($id)
    {
        if ($id) {
            $record =Mawasiliano::where('id', $id);
            $record->delete();
        }
    }
    public function test()
    {
        $this->value=15;

    }
    public function addgroup()
    {
        $this->validate(['name'=>'required'

    ]);
    }

}
