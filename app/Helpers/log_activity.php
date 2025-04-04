<?php

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

if (!function_exists('logActivity')) {
    function logActivity($action, $model, $changes = [], $description = null)
    {
        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => $action,
            'model_type'  => get_class($model),
            'model_id'    => $model->id,
            'changes'     => $changes,
            'ip'          => Request::ip(),
            'description' => $description,
        ]);
    }
}