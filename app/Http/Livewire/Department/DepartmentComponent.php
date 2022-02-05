<?php

namespace App\Http\Livewire\Department;

use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;

class DepartmentComponent extends Component
{
    use WithPagination;
    public $editMode = false;
    public $search = '';
    public $name, $deptId;

    protected $rules = [
        'name' => 'required',
    ];

    public function storeDept()
    {
        $this->validate();
        Department::create([
            'name' => $this->name,
        ]);

        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#deptModal', 'actionModal' => 'hide']);

        session()->flash('message', 'City Stored Successfully');
    }

    public function showEditModel($id)
    {
        $this->reset();
        $this->deptId = $id;
        $this->loadDept();
        $this->editMode = true;
        $this->dispatchBrowserEvent('modal', ['modalId' => '#deptModal', 'actionModal' => 'show']);
    }

    public function loadDept()
    {
        $dept = Department::find($this->deptId);
        $this->name = $dept->name;
    }

    public function updateDept()
    {
        $validation = $this->validate([
            'name' => ' required',
        ]);
        $dept = Department::find($this->deptId);
        $dept->update($validation);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#deptModal', 'actionModal' => 'hide']);
        session()->flash('message', 'Department Updated Successfully');
    }

    public function deleteDept($id)
    {
        $dept = Department::find($id);
        $dept->delete();
        session()->flash('message', 'Department Deleted Successfully');
    }


    public function closeModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#deptModal', 'actionModal' => 'hide']);
    }

    public function render()
    {
        $dept = Department::paginate(5);
        if (strlen($this->search) > 2) {
            $dept = Department::where('name', 'like', "%{$this->search}%")->paginate(5);
        }
        return view('livewire.department.department-component', ['depts' => $dept])->layout('layouts.main');
    }
}
