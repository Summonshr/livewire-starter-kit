<?php

use App\Models\Project;
use Livewire\Attributes\Computed;
use Livewire\Volt\Component;

new class extends Component {
    public $listeners = ['refreshParentComponent' => '$refresh'];

    #[Computed]
    public function projects()
    {
        return Project::all();
    }

    public function add(): void
    {
        Project::query()->create([]);
    }
}; ?>

<flux:container>
    <flux:grid>
        <flux:row>
            <flux:heading>Project</flux:heading>
            <flux:spacer />
            <flux:button type="button" wire:click="add">
                Add
            </flux:button>
        </flux:row>
    </flux:grid>
    <flux:separator />
    @foreach($this->projects as $project)
        <livewire:project-form :key="$project->id" :project="$project" />
        <flux:separator />
    @endforeach
</flux:container>
