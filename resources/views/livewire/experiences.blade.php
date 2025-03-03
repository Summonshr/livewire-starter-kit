<?php

use App\Models\Experience;
use Livewire\Attributes\Computed;
use Livewire\Volt\Component;

new class extends Component {
    public $listeners = ['refreshParentComponent' => '$refresh'];

    #[Computed]
    public function experiences()
    {
        return Experience::all();
    }

    public function add(): void
    {
        \App\Models\Experience::query()->create([]);
    }
}; ?>

<flux:container>
    <flux:grid>
        <flux:row>
            <flux:heading>Experience</flux:heading>
            <flux:spacer />
            <flux:button type="button" wire:click="add">
                Add
            </flux:button>
        </flux:row>
    </flux:grid>
    <flux:separator />
    @foreach($this->experiences as $experience)
    <livewire:experience-form :key="$experience->id" :experience="$experience" />
    <flux:separator />
    @endforeach
</flux:container>
