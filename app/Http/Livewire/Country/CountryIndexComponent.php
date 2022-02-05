<?php

namespace App\Http\Livewire\Country;

use App\Models\Country;
use Livewire\Component;

class CountryIndexComponent extends Component
{
    public $search = '';
    public $country_code, $name, $countryId;
    public $editMode = false;

    protected $rules = [
        'country_code' => 'required',
        'name' => 'required',
    ];

    public function storeCountry()
    {
        $this->validate();
        Country::create([
            'country_code' => $this->country_code,
            'name' => $this->name,
        ]);

        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#userModal', 'actionModal' => 'hide']);

        session()->flash('message', 'Country Stored Successfully');
    }
    public function showEditModel($id)
    {

        $this->reset();
        $this->countryId = $id;
        $this->loadCountry();
        $this->editMode = true;
        $this->dispatchBrowserEvent('modal', ['modalId' => '#userModal', 'actionModal' => 'show']);
    }


    public function loadCountry()
    {
        $country = Country::find($this->countryId);
        $this->country_code = $country->country_code;
        $this->name = $country->name;
    }

    public function updateCountry()
    {
        $validated = $this->validate([
            'country_code' => 'required',
            'name' => 'required',
        ]);

        $country = Country::find($this->countryId);
        $country->update($validated);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#userModal', 'actionModal' => 'hide']);
        session()->flash('message', 'Country Updated Successfully');
    }

    public function deleteCountry($id)
    {
        $country = Country::find($id);
        $country->delete();
        session()->flash('message', 'Country Deleted Successfully');
    }

    public function closeModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#userModal', 'actionModal' => 'hide']);
    }

    public function render()
    {
        $countries = Country::paginate(5);
        if (strlen($this->search) > 2) {
            $countries = Country::where('country_code', 'like', "%{$this->search}%")->paginate(5);
        }
        return view('livewire.country.country-index-component', ['countries' => $countries])->layout('layouts.main');
    }
}
