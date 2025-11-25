<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;

class UsersIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';
    public $perPage = 10;
    public $showDeleteModal = false;
    public $userToDelete = null;

    public function mount()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('users.view')) {
            abort(403, 'Unauthorized');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
    {
        $this->resetPage();
    }

    public function deleteUser($id)
    {
        if (!auth()->user()->hasPermission('users.manage')) {
            return;
        }

        $user = User::findOrFail($id);
        
        // Prevent deleting your own account
        if ($user->id === auth()->id()) {
            session()->flash('error', 'Cannot delete your own account');
            return;
        }

        $user->delete();
        session()->flash('message', 'User deleted successfully');
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->hasPermission('users.manage')) {
            return;
        }

        $this->userToDelete = User::findOrFail($id);
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->userToDelete = null;
    }

    public function getUsersProperty()
    {
        $query = User::query()
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%"))
            ->when($this->roleFilter, fn ($q) => $q->whereHas('roles', fn ($r) => $r->where('name', $this->roleFilter)))
            ->latest()
            ->paginate($this->perPage);

        return $query;
    }

    public function getRolesProperty()
    {
        return Role::orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.admin.users.index', [
            'users' => $this->getUsersProperty(),
            'roles' => $this->getRolesProperty(),
        ]);
    }
}
