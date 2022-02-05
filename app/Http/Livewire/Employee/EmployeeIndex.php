<?php

namespace App\Http\Livewire\Employee;

use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use App\Models\Employee;
use App\Models\State;
use Livewire\Component;
use Livewire\WithPagination;

class EmployeeIndex extends Component
{
    use WithPagination;
    public $search = '';
    public $firstName, $lastName, $middleName, $address, $countryId, $stateId, $cityId, $deptId;
    public $editMode = false;
    public $zipCode, $birthDay, $dateHired, $employeeId;
    public $selectDeptId = null;

    protected $rules = [
        'firstName' => 'required',
        'lastName' => 'required',
        'middleName' => 'required',
        'address' => 'required',
        'countryId' => 'required',
        'stateId' => 'required',
        'cityId' => 'required',
        'deptId' => 'required',
        'zipCode' => 'required',
        'birthDay' => 'required',
        'dateHired' => 'required',
    ];

    public function storeEmployee()
    {
        $this->validate();

        Employee::create([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'middle_name' => $this->middleName,
            'address' => $this->address,
            'country_id' => $this->countryId,
            'state_id' => $this->stateId,
            'city_id' => $this->cityId,
            'department_id' => $this->deptId,
            'zip_code' => $this->zipCode,
            'birthdate' => $this->birthDay,
            'date_hired' => $this->dateHired,
        ]);

        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#employeeModal', 'actionModal' => 'hide']);

        session()->flash('message', 'Employee Stored Successfully');
    }

    public function showEditModel($id)
    {

        $this->reset();
        $this->employeeId = $id;
        $this->loadEmployee();
        $this->editMode = true;
        $this->dispatchBrowserEvent('modal', ['modalId' => '#employeeModal', 'actionModal' => 'show']);
    }


    public function loadEmployee()
    {
        $employee = Employee::find($this->employeeId);
        $this->firstName = $employee->first_name;
        $this->lastName = $employee->last_name;
        $this->middleName = $employee->middle_name;
        $this->address = $employee->address;
        $this->countryId = $employee->country_id;
        $this->stateId = $employee->state_id;
        $this->cityId = $employee->city_id;
        $this->zipCode = $employee->zip_code;
        $this->deptId = $employee->department_id;
        $this->birthDay = $employee->birthdate;
        $this->dateHired = $employee->date_hired;
    }

    public function updateEmployee()
    {
        $validated = $this->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'middleName' => 'required',
            'address' => 'required',
            'countryId' => 'required',
            'stateId' => 'required',
            'cityId' => 'required',
            'deptId' => 'required',
            'zipCode' => 'required',
            'birthDay' => 'required',
            'dateHired' => 'required',

        ]);

        $employee = Employee::find($this->employeeId);
        $employee->update($validated);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#employeeModal', 'actionModal' => 'hide']);
        session()->flash('message', 'Employee Updated Successfully');
    }

    public function deleteEmployee($id)
    {
        $employee = Employee::find($id);
        $employee->delete();
        session()->flash('message', 'Employee Deleted Successfully');
    }


    public function showModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#employeeModal', 'actionModal' => 'show']);
    }

    public function closeModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#employeeModal', 'actionModal' => 'hide']);
    }

    public function render()
    {
        $countries = Country::all();
        $state = State::all();
        $city = City::all();
        $dept = Department::all();
        $employee = Employee::paginate(5);

        if (strlen($this->search) > 2) {
            if ($this->selectDeptId) {
                $employee = Employee::where('first_name', 'like', "%{$this->search}%")
                    ->where('department_id ', $this->selectDeptId)
                    ->paginate(5);
            } else {
                $employee = Employee::where('first_name', 'like', "%{$this->search}%")->paginate(5);
            }
        } elseif ($this->selectDeptId) {
            $employee = Employee::where('department_id ', $this->selectDeptId)->paginate(5);
        }
        return view('livewire.employee.employee-index', ['countries' => $countries, 'states' => $state, 'cities' => $city, 'employees' => $employee, 'depts' => $dept])->layout('layouts.main');
    }
}
