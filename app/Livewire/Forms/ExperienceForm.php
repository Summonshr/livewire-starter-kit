<?php

namespace App\Livewire\Forms;

use App\Models\Experience;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ExperienceForm extends Form
{
    public ?int $id = null;

    #[Validate('required|string|max:100')]
    public ?string $title = '';

    #[Validate('required|string|max:100')]
    public ?string $company = '';

    #[Validate('required|date|before:end_date')]
    public ?string $start_date = '';

    #[Validate('required|date|after:start_date')]
    public ?string $end_date = '';

    #[Validate('required|string|max:5000')]
    public ?string $summary = '';

    #[Validate('required|boolean')]
    public bool $current = false;

    public function save(): void
    {
        $this->validate();

        Experience::query()->where('id', $this->id)->update(
            [
                'title' => $this->title,
                'company' => $this->company,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'summary' => $this->summary,
                'current' => $this->current,
            ],
        );
    }

    public function delete(): void
    {
        Experience::query()->findOrFail($this->id)->delete();
    }
}
