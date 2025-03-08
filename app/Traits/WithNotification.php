<?php

namespace App\Traits;

use Closure;

trait WithNotification
{
    public function notify(string $subtitle = '', string $title = '', string $variant = 'info', string $position = 'bottom right', int $duration = 3000): object
    {
        return new class($subtitle, $title, $variant, $position = 'bottom right', $duration, $this->dispatch(...))
        {
            public function __construct(public string $subtitle, public string $title, public string $type, public string $position = 'bottom right', public int $duration, public Closure $dispatch) {}

            public function title(string $title): self
            {
                $this->title = $title;

                return $this;
            }

            public function position(string $position): self
            {
                $this->position = $position;

                return $this;
            }

            public function subtitle(string $subtitle): self
            {
                $this->subtitle = $subtitle;

                return $this;
            }

            public function duration(int $duration): self
            {
                $this->duration = $duration;

                return $this;
            }

            public function success(): self
            {
                $this->type = 'success';

                return $this;
            }

            public function warning(): self
            {
                $this->type = 'warning';

                return $this;
            }

            public function danger(): self
            {
                $this->type = 'danger';

                return $this;
            }

            public function error(): self
            {
                $this->type = 'danger';

                return $this;
            }

            public function info(): self
            {
                $this->type = 'info';

                return $this;
            }

            public function send(): void
            {
                call_user_func(
                    $this->dispatch,
                    'notify',
                    slots: ['heading' => $this->title, 'text' => $this->subtitle],
                    dataset: ['variant' => $this->type, 'position' => $this->position],
                    duration: $this->duration,
                );
            }
        };
    }
}
