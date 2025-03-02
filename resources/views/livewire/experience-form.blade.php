<?php

use App\Livewire\Forms\ExperienceForm;
use App\Models\Experience;
use Livewire\Volt\Component;

new class extends Component {
    public Experience $experience;

    public ExperienceForm $form;

    public function mount(Experience $experience)
    {
        $this->form->fill($experience->getAttributes());
    }

    public function save()
    {
        $this->form->save();
    }

    public function delete($id)
    {
        $this->form->delete($id);

        $this->modal('delete-profile-'.$id)->close();

        $this->dispatch('refreshParentComponent');

    }
}; ?>
<flux:grid>
    <flux:grid cols="2" class="mb-6">
        <flux:input wire:model="form.title" label="Title" />
        <flux:input wire:model="form.company" label="Company" />
        <flux:input wire:model="form.start_date" type="date" label="Start Date" />
        <flux:input wire:model="form.end_date" type="date" label="End Date" />
    </flux:grid>

    <flux:grid class="mb-6">
        <flux:textarea wire:model="form.summary" label="Summary">{{ $experience->summary }}</flux:textarea>
    </flux:grid>

    <flux:row right>
        <flux:checkbox label="Current Experience" wire:model="form.current" />
        <flux:spacer />
        <flux:modal.trigger name='delete-profile-{{$experience->id}}'>
            <flux:button class="mr-2" type="button" variant="subtle">
                Delete
            </flux:button>
        </flux:modal.trigger>
        <flux:modal name='delete-profile-{{$experience->id}}' class="min-w-sm">
            <flux:grid>
                <flux:col>
                    <flux:heading size="lg">Delete project?</flux:heading>
                    <flux:subheading>
                        This action cannot be reversed.
                    </flux:subheading>
                </flux:col>
            </flux:grid>
            <flux:row>
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:spacer />
                <flux:button type="submit" wire:click="delete({{ $experience->id }})" variant="danger">
                    Delete
                </flux:button>
            </flux:row>
        </flux:modal>
        <flux:button type="button" wire:click="save({{ $experience->id }})">
            save
        </flux:button>
    </flux:row>
</flux:grid>
