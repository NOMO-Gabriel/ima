<?php

use App\Models\History;
use Illuminate\Support\Facades\Auth;

if (!function_exists('log_history')) {

    /**
     * Log a user action in the history table.
     *
     * @param string $action Action type (e.g. 'created', 'updated', 'deleted')
     * @param object $subject The Eloquent model subject of the action
     * @param array $changes Optional array describing changes ['before' => [...], 'after' => [...]]
     * @param string|null $description Optional description of the action
     * @return \App\Models\History
     */
    function log_history(string $action, $subject, array $changes = [], string $description = "")
    {
        $userId = Auth::user()->id;

        return History::create([
            'user_id'      => $userId,
            'subject_type' => get_class($subject),
            'subject_id'   => $subject->id,
            'action'       => $action,
            'changes'      => $changes,
            'description'  => $description,
            'ip_address'   => request()->ip(),
            'user_agent'   => request()->userAgent(),
        ]);
    }

}
