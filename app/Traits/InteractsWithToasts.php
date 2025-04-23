<?php

namespace App\Traits;

trait InteractsWithToasts
{
    public function showToastSuccess(string $message, string $title = 'Success'): void
    {
        $this->dispatch('show-toast', [
            'type' => 'success',
            'title' => __($title),
            'message' => __($message),
        ]);
    }

    public function showToastError(string $message, string $title = 'Error'): void
    {
        $this->dispatch('show-toast', [
            'type' => 'error',
            'title' => __($title),
            'message' => __($message),
        ]);
    }

    public function showToastWarning(string $message, string $title = 'Warning'): void
    {
        $this->dispatch('show-toast', [
            'type' => 'warning',
            'title' => __($title),
            'message' => __($message),
        ]);
    }
}