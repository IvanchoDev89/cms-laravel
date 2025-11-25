<?php

use Livewire\Volt\Component;
use App\Livewire\Admin\UsersIndex;

new class extends Component {
    public function with()
    {
        return [
            'component' => new UsersIndex(),
        ];
    }
};

?>

<div>
    <livewire:admin.users-index />
</div>
