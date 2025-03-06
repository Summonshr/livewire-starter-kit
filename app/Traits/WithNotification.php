<?php

namespace App\Traits;

trait WithNotification
{
    public function notify(string $message, string $type = 'info', int $duration = 3000): void
    {
        $this->js("notify('$message', '$type', $duration);");
    }
}
