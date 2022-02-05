<?php

namespace App\Http\Livewire\State;

use App\Models\Country;
use App\Models\State;
use Livewire\Component;
use Livewire\WithPagination;

class StateIndexComponent extends Component
{
    use WithPagination;
    public $editMode = false;
    public $search = '';
    public $country_id, $name, $stateId;

    protected $rules = [
        'country_id' => 'required',
        'name' => 'required',
    ];

    public function storeState()
    {
        $this->validate();
        State::create([
            'country_id' => $this->country_id,
            'name' => $this->name,
        ]);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#userModal', 'actionModal' => 'hide']);

        session()->flash('message', 'State Stored Successfully');
    }

    public function showEditModel($id)
    {

        $this->reset();
        $this->stateId = $id;
        $this->loadState();
        $this->editMode = true;
        $this->dispatchBrowserEvent('modal', ['modalId' => '#userModal', 'actionModal' => 'show']);
    }


    public function loadState()
    {
        $state = State::find($this->stateId);
        $this->country_id = $state->country_id;
        $this->name = $state->name;
    }


    public function updateState()
    {
        $validated = $this->validate([
            'country_id' => 'required',
            'name' => 'required',
        ]);

        $state = State::find($this->stateId);
        $state->update($validated);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#userModal', 'actionModal' => 'hide']);
        session()->flash('message', 'State Updated Successfully');
    }

    public function deleteState($id)
    {
        $state = State::find($id);
        $state->delete();
        session()->flash('message', 'State Deleted Successfully');
    }

    public function closeModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#userModal', 'actionModal' => 'hide']);
    }

    public function render()
    {
        $country = Country::all();
        $state = State::paginate(5);
        if (strlen($this->search) > 2) {
            $state = State::where('name', 'like', "%{$this->search}%")->paginate(5);
        }
        return view('livewire.state.state-index-component', ['states' => $state, 'countries' => $country])->layout('layouts.main');
    }
}
