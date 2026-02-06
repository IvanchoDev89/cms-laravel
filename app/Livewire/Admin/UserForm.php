<?php

namespace App\Livewire\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserForm extends Component
{
    public $userId = null;

    public $name = '';

    public $email = '';

    public $password = '';

    public $passwordConfirmation = '';

    public $selectedRoles = [];

    protected $rules = [
        'name' => 'required|min:2|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'nullable|min:8|confirmed',
        'selectedRoles' => 'array',
    ];

    public function mount($userId = null)
    {
        if (! auth()->check() || ! auth()->user()->hasPermission('users.manage')) {
            abort(403, 'Unauthorized');
        }

        if ($userId) {
            $user = User::findOrFail($userId);
            $this->userId = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->selectedRoles = $user->roles->pluck('id')->toArray();

            // Update email unique rule for edit mode
            $this->rules['email'] = "required|email|unique:users,email,{$userId}";
            $this->rules['password'] = 'nullable|min:8|confirmed';
        }
    }

    public function save()
    {
        $this->validate();

        try {
            if ($this->userId) {
                $user = User::findOrFail($this->userId);
                $user->update([
                    'name' => $this->name,
                    'email' => $this->email,
                ]);
                if ($this->password) {
                    $user->update(['password' => Hash::make($this->password)]);
                }
                session()->flash('message', 'User updated successfully');
            } else {
                $user = User::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => Hash::make($this->password),
                    'email_verified_at' => now(),
                ]);
                session()->flash('message', 'User created successfully');
            }

            // Sync roles
            if ($this->selectedRoles) {
                $user->roles()->sync($this->selectedRoles);
            } else {
                $user->roles()->detach();
            }

            $this->redirect(route('admin.users.index'));
        } catch (\Exception $e) {
            session()->flash('error', 'Error saving user: '.$e->getMessage());
        }
    }

    public function getRolesProperty()
    {
        return Role::orderBy('display_name')->get();
    }

    public function render()
    {
        return view('livewire.admin.users.form', [
            'roles' => $this->getRolesProperty(),
        ]);
    }
}
