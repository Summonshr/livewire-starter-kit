<?php

use Livewire\Volt\Component;
use App\Models\Skill;
use Livewire\WithPagination;
use App\Livewire\Forms\SkillForm;
use App\Traits\WithSorting;

new class extends Component {

    use WithPagination;
    use WithSorting;

    public $paginationTheme = 'tailwind';

    public SkillForm $form;

    public ?int $toDelete = null;

    public function with(): array
    {
        return [
            'skills' => $this->skills,
        ];
    }

    #[\Livewire\Attributes\Computed]
    public function skills(): \Illuminate\Pagination\LengthAwarePaginator
    {
        $skills = Skill::query()->tap(fn($query) => $this->sortBy !== '' && $this->sortBy !== '0' ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)->paginate(5);

        if ($skills->count() > 0) {
            return $skills;
        }

        $this->resetPage();

        return Skill::query()->tap(fn($query) => $this->sortBy !== '' && $this->sortBy !== '0' ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)->paginate(5);
    }

    public function updateSkill(): void
    {
        $this->validate();

        $this->form->save();

        $this->modal('skill-form')->close();

        $this->close();
    }

    public function deleteSkill($id): void
    {
        $this->form->delete($id);

        $this->modal('delete-profile')->close();

        $this->reset('toDelete');
    }

    public function edit($id): void
    {
        $this->form->fillById($id);
        $this->modal('skill-form')->show();
    }

    public function close(): void
    {
        $this->reset();
        $this->resetValidation();
    }
};
?>
<flux:container>
    <flux:grid>
        <flux:row>
            <flux:heading size="lg">Skills</flux:heading>
            <flux:spacer />
            <flux:modal.trigger name="skill-form">
                <flux:button>Add Skill</flux:button>
            </flux:modal.trigger>
        </flux:row>
    </flux:grid>
    <flux:separator />
    <flux:grid>
        <flux:table :paginate="$skills">
            <flux:table.header>
                <flux:table.header.column>
                    <flux:table.header.cell sortable :sorted="$sortBy === 'group'" :direction="$sortDirection"
                        wire:click="sort('group')">Skill Group</flux:table.header.cell>
                    <flux:table.header.cell sortable :sorted="$sortBy === 'skill'" :direction="$sortDirection"
                        wire:click="sort('skill')">Skill</flux:table.header.cell>
                    <flux:table.header.cell sortable :sorted="$sortBy === 'description'" :direction="$sortDirection"
                        wire:click="sort('description')">Description</flux:table.header.cell>
                    <flux:table.header.cell sortable :sorted="$sortBy === 'level'" :direction="$sortDirection"
                        wire:click="sort('level')">Level</flux:table.header.cell>
                    <flux:table.header.cell>Actions</flux:table.header.cell>
                </flux:table.header.column>
            </flux:table.header>
            <flux:table.body>
                @foreach ($skills as $skill)
                <flux:table.body.column>
                    <flux:table.body.cell>{{ $skill->group }}</flux:table.body.cell>
                    <flux:table.body.cell>{{ $skill->skill }}</flux:table.body.cell>
                    <flux:table.body.cell>{{ $skill->description }}</flux:table.body.cell>
                    <flux:table.body.cell>{{ $skill->level }}</flux:table.cell>
                        <flux:table.body.cell>
                            <flux:modal.trigger name="edit-profile">
                                <flux:button icon="pencil-square" class="mr-2" wire:click="edit({{ $skill->id }})"
                                    variant="subtle" inset />
                            </flux:modal.trigger>
                            <flux:modal.trigger name="delete-profile">
                                <flux:button icon="trash" x-on:click="$wire.toDelete = {{ $skill->id }}"
                                    variant="subtle" inset />
                            </flux:modal.trigger>
                        </flux:table.body.cell>
                </flux:table.body.column>
                @endforeach
            </flux:table.body>
        </flux:table>
    </flux:grid>
    <flux:modal name="delete-profile" class="min-w-xs">
        <flux:spaced>
            <flux:heading size="lg">Delete project?</flux:heading>
            <flux:subheading>
                This action cannot be reversed.
            </flux:subheading>

            <flux:row>
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:spacer />
                <flux:button type="submit" x-on:click="$wire.deleteSkill($wire.toDelete)" variant="danger">Delete
                </flux:button>
            </flux:row>
        </flux:spaced>
    </flux:modal>
    <flux:modal wire:close="close" name="skill-form" class="md:w-128">
        <form wire:submit.prevent="updateSkill">
            <flux:heading size="lg">{{ $form?->skillId ? 'Edit Skill Group' : 'Add New Skill Group' }}</flux:heading>
            <flux:subheading>Shown like Front End Development: Javascript</flux:subheading>
            <flux:separator class="mb-6" />
            <flux:grid>
                <flux:select placeholder="Select a skill group" wire:model="form.group">
                    @foreach (\App\Enums\SkillGroup::cases() as $value)
                    <flux:select.option value="{{ $value }}">{{ $value }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:input wire:model="form.skill" label="Skill Name" placeholder="Laravel" />
                <flux:input wire:model="form.description" label="Skill Description"
                    placeholder="Laravel is a PHP web framework" />
                <flux:input type="range" max="10" min="0" wire:model="form.level" label="Skill Level"
                    placeholder="0-9" />
            </flux:grid>
            <flux:row>
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:spacer />
                <flux:button type="submit" variant="primary">Save changes</flux:button>
            </flux:row>
        </form>
    </flux:modal>
</flux:container>
