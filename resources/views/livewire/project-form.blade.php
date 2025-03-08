<?php

use App\Livewire\Forms\ProjectForm;
use App\Models\Project;
use App\Traits\WithNotification;
use Livewire\Volt\Component;

new class extends Component {
    use WithNotification;
    public Project $project;

    public ProjectForm $form;

    public function mount(Project $project): void
    {
        $this->form->fill($project->getAttributes());
    }

    public function save(): void
    {
        $this->form->save();
        $this->notify('Project saved')->info()->send();
    }

    public function delete(string $id): void
    {
        $this->form->delete();

        $this->modal('delete-profile-' . $id)->close();

        $this->dispatch('refreshParentComponent');
    }
}; ?>
<flux:grid>
    <flux:grid cols="2" class="mb-6">
        <flux:input wire:model="form.title" label="Title" />
        <flux:input wire:model="form.url" label="URL" />
        <flux:input wire:model="form.github_url" label="Github URL" />
    </flux:grid>

    <flux:grid class="mb-6">
        <flux:textarea wire:model="form.description" label="Description" />
    </flux:grid>

    <flux:row right>
        <flux:spacer />
        <flux:modal.trigger name='delete-profile-{{$project->id}}'>
            <flux:button class="mr-2" type="button" variant="subtle">
                Delete
            </flux:button>
        </flux:modal.trigger>
        <flux:modal name='delete-profile-{{$project->id}}' class="min-w-sm">
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
                <flux:button type="submit" wire:click="delete({{ $project->id }})" variant="danger">
                    Delete
                </flux:button>
            </flux:row>
        </flux:modal>
        <flux:button type="button" wire:click="save({{ $project->id }})">
            save
        </flux:button>
    </flux:row>
</flux:grid>
