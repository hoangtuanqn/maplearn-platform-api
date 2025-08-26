<?php

namespace App\Traits;

use App\Models\UserActivityLog;

trait LogsActivity
{
    public function logActivity($action, $description = null)
    {
        UserActivityLog::create([
            'user_id' => $this->id,
            'action' => $action,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
