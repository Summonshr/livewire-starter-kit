<?php

use Livewire\Volt\Component;
use App\Models\Skill;
use App\Livewire\Forms\ContactForm;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Url;
use Illuminate\Support\Collection;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public ?int $skillId = null;

    #[Validate('required|string|max:100')]
    public string $group = '';

    #[Validate('required|string|max:100|unique:skills,skill')]
    public string $skill = '';

    #[Validate('required|string|max:100')]
    public string $description = '';

    #[Validate('required|numeric|digits_between:1,5')]
    public int $level = 0;

    #[Url]
    public $sortBy = '';

    #[Url]
    public $sortDirection = 'desc';

    public int $toDelete = 0;

    public function sort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function with(): array
    {
        return [
            'skills' => $this->skills,
        ];
    }

    #[\Livewire\Attributes\Computed]
    public function skills(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Skill::query()->tap(fn($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)->paginate(5);
    }

    public function updateSkill()
    {
        $this->validate();

        Skill::updateOrCreate(
            [
                'id' => $this->skillId,
            ],
            [
                'group' => $this->group,
                'skill' => $this->skill,
                'description' => $this->description,
                'level' => $this->level,
            ],
        );

        $this->modal('skill-form')->close();

        $this->close();
    }

    public function deleteSkill($id)
    {
        Skill::findOrFail($id)->delete();

        $this->modal('delete-profile')->close();

        $this->reset('toDelete');
    }

    public function edit($id)
    {
        $this->fill(Skill::select(['id as skillId', 'group', 'skill', 'description', 'level'])->findOrFail($id));
        $this->modal('skill-form')->show();
    }

    public function close()
    {
        $this->reset();
        $this->resetValidation();
    }
};
?>
<flux:container>
    <flux:row>
        <flux:heading size="lg">Skills</flux:heading>
        <flux:spacer />
        <flux:modal.trigger name="skill-form">
            <flux:button>Add Skill Group</flux:button>
        </flux:modal.trigger>
    </flux:row>
    <flux:separator />
    <flux:table :paginate="$skills">
        <flux:table.header>
            <flux:table.header.row>
                <flux:table.header.cell sortable :sorted="$sortBy === 'group'" :direction="$sortDirection"
                    wire:click="sort('group')">Skill Group</flux:table.header.cell>
                <flux:table.header.cell sortable :sorted="$sortBy === 'skill'" :direction="$sortDirection"
                    wire:click="sort('skill')">Skill</flux:table.header.cell>
                <flux:table.header.cell sortable :sorted="$sortBy === 'description'" :direction="$sortDirection"
                    wire:click="sort('description')">Description</flux:table.header.cell>
                <flux:table.header.cell sortable :sorted="$sortBy === 'level'" :direction="$sortDirection"
                    wire:click="sort('level')">Level</flux:table.header.cell>
                <flux:table.header.cell>Actions</flux:table.header.cell>
            </flux:table.header.row>
        </flux:table.header>
        <flux:table.body>
            @foreach ($skills as $skill)
                <flux:table.row>
                    <flux:table.body.cell>{{ $skill->group }}</flux:table.body.cell>
                    <flux:table.body.cell>{{ $skill->skill }}</flux:table.body.cell>
                    <flux:table.body.cell>{{ $skill->description }}</flux:table.body.cell>
                    <flux:table.body.cell>{{ $skill->level }}</flux:table.cell>
                        <flux:table.body.cell>
                            <flux:modal.trigger name="edit-profile">
                                <flux:button icon="pencil-square" class="mr-2" wire:click="edit({{ $skill->id }})"
                                    variant="ghost" inset />
                            </flux:modal.trigger>
                            <flux:modal.trigger name="delete-profile">
                                <flux:button icon="trash" x-on:click="$wire.toDelete = {{ $skill->id }}"
                                    variant="ghost" inset />
                            </flux:modal.trigger>
                        </flux:table.body.cell>
                </flux:table.row>
            @endforeach
        </flux:table.body>
    </flux:table>
    <flux:modal name="delete-profile" class="min-w-xs">
        <flux:spaced>
            <flux:heading size="lg">Delete project?</flux:heading>
            <flux:subheading>
                This action cannot be reversed.
            </flux:subheading>

            <flux:row no-width>
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
            <flux:heading size="lg">{{ $skillId ? 'Edit Skill Group' : 'Add New Skill Group' }}</flux:heading>
            <flux:subheading>Shown like Front End Development: Javascript</flux:subheading>
            <flux:separator class="mb-6" />
            <flux:grid>
                <flux:select placeholder="Select a skill group" wire:model="group">
                    @foreach (\App\Enums\SkillGroup::cases() as $value)
                        <flux:select.option value="{{ $value }}">{{ $value }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:input wire:model="skill" label="Skill Name" placeholder="Laravel" />
                <flux:input wire:model="description" label="Skill Description"
                    placeholder="Laravel is a PHP web framework" />
                <flux:input type="range" max="10" min="0" wire:model="level" label="Skill Level"
                    placeholder="0-9" />
                <flux:row no-width>
                    <flux:modal.close>
                        <flux:button variant="ghost">Cancel</flux:button>
                    </flux:modal.close>
                    <flux:spacer />
                    <flux:button type="submit" variant="primary">Save changes</flux:button>
                </flux:row>
            </flux:grid>
        </form>
    </flux:modal>
</flux:container>
