<?php

namespace App\Http\Livewire\City;

use Livewire\WithPagination;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Livewire\Component;

class CityIndexComponent extends Component
{
    use WithPagination;
    public $editMode = false;
    public $search = '';
    public $cityId, $name, $state_id;

    protected $rules = [
        'state_id' => 'required',
        'name' => 'required',
    ];

    public function storeCity()
    {
        $this->validate();
        City::create([
            'state_id' => $this->state_id,
            'name' => $this->name,
        ]);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#cityModal', 'actionModal' => 'hide']);

        session()->flash('message', 'City Stored Successfully');
    }

    public function showEditModel($id)
    {

        $this->reset();
        $this->cityId = $id;
        $this->loadCity();
        $this->editMode = true;
        $this->dispatchBrowserEvent('modal', ['modalId' => '#cityModal', 'actionModal' => 'show']);
    }


    public function loadCity()
    {
        $city = City::find($this->cityId);
        $this->state_id = $city->state_id;
        $this->name = $city->name;
    }

    public function updateCity()
    {
        $validated = $this->validate([
            'state_id' => 'required',
            'name' => 'required',
        ]);

        $city = City::find($this->cityId);
        $city->update($validated);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#cityModal', 'actionModal' => 'hide']);
        session()->flash('message', 'City Updated Successfully');
    }


    public function deleteCity($id)
    {
        $city = City::find($id);
        $city->delete();
        session()->flash('message', 'City Deleted Successfully');
    }
    public function closeModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#cityModal', 'actionModal' => 'hide']);
    }

    public function render()
    {
        $country = Country::all();
        $city = City::paginate(5);
        $state = State::all();
        if (strlen($this->search) > 2) {
            $city = City::where('name', 'like', "%{$this->search}%")->paginate(5);
        }

        return view('livewire.city.city-index-component', ['cities' => $city, 'countries' => $country, 'states' => $state])->layout('layouts.main');
    }
}
