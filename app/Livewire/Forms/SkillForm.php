<?php

namespace App\Livewire\Forms;

use App\Models\Skill;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SkillForm extends Form
{
    public ?int $skillId = null;

    #[Validate('required|string|max:100')]
    public string $group = '';

    #[Validate('required|string|max:100')]
    public string $skill = '';

    #[Validate('required|string|max:100')]
    public string $description = '';

    #[Validate('required|numeric|digits_between:1,5')]
    public int $level = 0;

    public function save()
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
    }

    public function delete($id)
    {
        Skill::findOrFail($id)->delete();
    }

    public function fillById($id)
    {
        $this->fill(Skill::select(['id as skillId', 'group', 'skill', 'description', 'level'])->findOrFail($id));
    }
}
