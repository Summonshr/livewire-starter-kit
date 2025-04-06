<?php

namespace App\Livewire\Forms;

use App\Models\Project;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ProjectForm extends Form
{
    public null|int $id = null;

    #[Validate('required|string|max:100')]
    public null|string $title = '';

    #[Validate('required|string|max:500')]
    public null|string $description = '';

    #[Validate('required|string|max:100')]
    public null|string $url = '';

    #[Validate('required|string|max:100')]
    public null|string $github_url = '';

    #[Validate('image|nullable')]
    public null|string $image = null;

    public function save(): void
    {
        $this->validate();

        Project::query()->where('id', $this->id)->update(
            [
                'title' => $this->title,
                'description' => $this->description,
                'url' => $this->url,
                'github_url' => $this->github_url,
                'image' => $this->image,
            ],
        );

    }

    public function delete(): void
    {
        Project::query()->findOrFail($this->id)->delete();
    }
}
