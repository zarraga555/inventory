<?php

namespace App\Helpers;

class ToastHelper
{
    public static function flashSuccess(string $message, string $title = 'Success'): void
    {
        session()->flash('toast', [
            'type' => 'success',
            'title' => __($title),
            'message' => __($message),
        ]);
    }

    public static function flashError(string $message, string $title = 'Error'): void
    {
        session()->flash('toast', [
            'type' => 'error',
            'title' => __($title),
            'message' => __($message),
        ]);
    }

    public static function flashWarning(string $message, string $title = 'Warning'): void
    {
        session()->flash('toast', [
            'type' => 'warning',
            'title' => __($title),
            'message' => __($message),
        ]);
    }
}