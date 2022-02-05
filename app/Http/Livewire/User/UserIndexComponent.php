<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class UserIndexComponent extends Component
{
    public $search = "";
    public $username;
    public $fname, $lname, $email, $password;
    public $userId;
    public $editMode = false;
    use WithPagination;

    protected $rules = [
        'username' => 'required',
        'fname' => 'required',
        'lname' => 'required',
        'email' => 'required|email',
    ];

    public function storeUser()
    {
        $this->validate();

        User::create([
            'username' => $this->username,
            'fname' => $this->fname,
            'lname' => $this->lname,
            'email' => $this->email,
            'password' => Hash::make($this->password)
        ]);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#userModal', 'actionModal' => 'hide']);

        session()->flash('message', 'User Stored Successfully');
    }


    public function showEditModal($id)
    {
        $this->reset();
        $this->editMode = true;

        $this->userId = $id;

        $this->loadUser();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#userModal', 'actionModal' => 'show']);
    }
    public function loadUser()
    {
        $user = User::find($this->userId);
        $this->username = $user->username;
        $this->fname = $user->fname;
        $this->lname = $user->lname;
        $this->email = $user->email;
    }

    public function updateUser()
    {
        $validated = $this->validate([
            'username' => 'required',
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email',
        ]);


        $user = User::find($this->userId);
        $user->update($validated);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#userModal', 'actionModal' => 'hide']);
        session()->flash('message', 'User Updated Successfully');
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();

        session()->flash('message', 'User Deleted Successfully');
    }

    public function closeModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#userModal', 'actionModal' => 'hide']);
    }

    public function render()
    {
        $users = User::paginate(5);
        if (strlen($this->search) > 2) {
            $users = User::where('username', 'like', "%{$this->search}%")->paginate(5);
        }
        return view('livewire.user.user-index-component', ['users' => $users])->layout('layouts.main');
    }
}
