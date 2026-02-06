<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\User;

class UsersIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $role = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'role' => ['except' => ''],
    ];

    public function render(): \Illuminate\Contracts\View\View
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->role, function ($query) {
                $query->where('role', $this->role);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.users.users-index-view', [
            'users' => $users,
        ]);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        
        session()->flash('message', 'User deleted successfully!');
    }
}
