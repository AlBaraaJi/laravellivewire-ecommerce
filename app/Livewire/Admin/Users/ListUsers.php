<?php

namespace App\Livewire\Admin\Users;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use Validator;
use Livewire\WithPagination;

class ListUsers extends Component
{
    use WithPagination;
    // protected $paginationTheme = "bootstrap";
    protected string $paginationTheme = 'bootstrap';
    public $state = [];
    public $user;
    public $showEditModal = false;
    public $userIdDelete = null;
    public $searchTerm = null;
    public $selectedRows = [];
    public $selectedPageRows = false;
    public $hobbies = [];
    public $newHobby = '';

    // ############ Create User ###############
    public function addNew()
    {
        // dd('test');
        $this->reset();
        $this->state = [];
        $this->hobbies = [];
        $this->showEditModal = false;
        $this->dispatch("show-form");
    }


    public function createUser()
    {
        
        $this->state['hobbies'] = $this->hobbies;
        
        try {
            $validatedata = Validator::make($this->state, [
                "name" => "required",
                "email" => "required|string|email|unique:users",
                "password" => "required|confirmed",
                "role_id" => "required",
                "hobbies" => "nullable|array",
                
            ])->validate();
            
            $validatedata["password"] = bcrypt($validatedata["password"]);
            
            // dd($validatedata);
            
            User::create($validatedata);
            

            $this->reset('state'); // Reset the form
            $this->dispatch('hide-form'); // Trigger event to hide modal
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->addError('validation', $e->validator->errors());
            $this->dispatch('show-form');
        }
    }


    // ############ Edit User ###############
    public function edit(User $user)
    {
        $this->reset();
        $this->showEditModal = true;
        $this->user = $user;
        $this->state = $user->toArray(); //to get the user data
        $this->hobbies = $user->hobbies ?? []; // Populate hobbies if they exist
        $this->dispatch('show-form');
        // dd($user);
    }

    public function updateUser()
    {
        $validatedata = Validator::make($this->state, [
            "name" => "required",
            "email" => "required | string | email | unique:users,email," . $this->user->id,
            "password" => "sometimes | confirmed",
            "role_id" => "required",
            "hobbies" => "nullable|array",
        ])->validate();

        if (!empty($validatedata["password"])) {

            $validatedata["password"] = bcrypt($validatedata["password"]);
        }

        $validatedata['hobbies'] = $this->hobbies;
        $this->user->update($validatedata);

        // hide modal and show the toast with message
        $this->dispatch("hide-form", ['message' => 'User Updated Successfully']);
    }

    // ############ Delete User ###############
    public function confirmDelete($userId)
    {
        $this->userIdDelete = $userId;
        $this->dispatch("show-delete-modal");
        // dd($userId);
    }

    public function deleteUser()
    {
        $user = User::findOrFail($this->userIdDelete);
        $user->delete();
        $this->dispatch("hide-delete-form", ['message' => 'User Deleted Successfully']);
        // dd($user);
    }


    // ########################## BULK ACTIONS #####################################

    public function updatedSelectedPageRows($value)
    {
        if ($value) {
            $this->selectedRows = User::query()
                ->where('name', 'like', '%' . $this->searchTerm . '%')
                ->orWhere('email', 'like', '%' . $this->searchTerm . '%')
                ->latest()
                ->paginate(5)
                ->pluck('id')
                ->toArray();
        } else {
            $this->reset('selectedRows');
        }
    }
    public function deleteSelectedRows()
    {
        User::whereIn('id', $this->selectedRows)->delete();
        $this->dispatch('deleted', ['message' => 'Selected users have been deleted.']);
        $this->reset(['selectedRows', 'selectedPageRows']);
    }

    // Change selected users' roles to USER
    public function changeToUser()
    {
        if (!empty($this->selectedRows)) {
            User::whereIn('id', $this->selectedRows)->update(['role_id' => 2]); // Role ID 2 = USER
            $this->dispatch('role-changed', ['message' => 'Selected users are now USERS.']);
        }
    }

    // Change selected users' roles to ADMIN
    public function changeToAdmin()
    {
        if (!empty($this->selectedRows)) {
            User::whereIn('id', $this->selectedRows)->update(['role_id' => 1]); // Role ID 1 = ADMIN
            $this->dispatch('role-changed', ['message' => 'Selected users are now ADMINS.']);
        }
    }


    ################################################# Hobbies #################################################

    public function addHobby()
    {
        if (!empty($this->newHobby)) {
            $this->hobbies[] = $this->newHobby;
            // dd($this->hobbies);
            $this->newHobby = ''; // Clear the input
        }
    }

    public function removeHobby($index)
    {
        unset($this->hobbies[$index]);
        $this->hobbies = array_values($this->hobbies); // Reindex the array
    }


    // ############ Render #################################################################
    #[Layout('layouts.app')]
    public function render()
    {
        $users = User::query()
            ->where('name', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('email', 'like', '%' . $this->searchTerm . '%')
            ->latest()
            ->paginate(5);
        return view('livewire.admin.users.list-users', compact('users'));
    }
}
